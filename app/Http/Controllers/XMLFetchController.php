<?php

namespace App\Http\Controllers;

use App\Models\XMLBook;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Spatie\Regex\Regex;

use Illuminate\Support\Facades\Storage;
use File;

use Intervention\Image\Laravel\Facades\Image;

class XMLFetchController extends Controller
{
    public function index(){
        return view('pages.xml_fetch.xml_fetch_index');
    }

    public function xmlFetch(Request $request){
        ini_set('max_execution_time', 36000);
        XMLBook::truncate();

        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        $xmlString = settings()->group('api_settings')->get('xml_address');

        if($xmlString != ""){
            $xmlFile = file_get_contents($xmlString);
            $xmlContent = simplexml_load_string($xmlFile);
            $xmlArray = json_decode(json_encode((array)$xmlContent), TRUE);
            $xmlArrayCount = json_decode(json_encode((array)$xmlContent), TRUE);
            $bookCount = 1;

            foreach ($xmlArray['Stok'] as $dataBook) {
                if($dataBook['BARKOD'] && $dataBook['ADI']) {
                    $xmlBook = new XMLBook();

                    $xmlBook->book_barcode_no = $dataBook['BARKOD'];
                    $xmlBook->book_name = $dataBook['ADI'];

                    if($dataBook['YAZAR']){$xmlBook->book_author_name = $dataBook['YAZAR'];}else{$xmlBook->book_author_name = null;}
                    if($dataBook['YAYINEVI']){$xmlBook->book_publisher_name = $dataBook['YAYINEVI'];}else{$xmlBook->book_publisher_name = null;}
                    if($dataBook['FIYAT']){$xmlBook->book_price = $dataBook['FIYAT'];}else{$xmlBook->book_price = null;}
                    if($dataBook['MIKTAR']){$xmlBook->book_stock = $dataBook['MIKTAR'];}else{$xmlBook->book_stock = null;}
                    if($dataBook['RESIM']){

                        $imageContent = file_get_contents($dataBook['RESIM']);
                        $bookBarcode = $dataBook['BARKOD'];
                        $bookDataPath = public_path('uploads/'.$bookBarcode);

                        if(!File::exists($bookDataPath)){
                            File::makeDirectory($bookDataPath, 0755, true, true);
                        }

                        $image = Image::read($imageContent);
                        $image->contain(500, 500);
                        $image->resizeCanvas(500, 500, 'ff0');

                        $image->save($bookDataPath.'/'.$bookBarcode.'.jpg');

                        $xmlBook->book_image = 'https://www.rwisehq.com/uploads/'.$bookBarcode.'/'.$bookBarcode.'.jpg';

                        //$xmlBook->book_image = $dataBook['RESIM'];

                    }else{$xmlBook->book_image = null;}
                    if($dataBook['ACIKLAMA']){
                        $xmlBook->book_description = html_entity_decode(ltrim(Regex::replace('/<.*?>/', '', $dataBook['ACIKLAMA'])->result()));
                    }else{$xmlBook->book_description = null;}

                    $xmlBook->xml_fetch_group = $randomString;
                    $xmlBook->save();
                    $bookCount += 1;
                }
            }
            $status = "Success";
        } else {
            $status = "EmptyXML";
        }

        return response()->json([
            "status" => $status,
            "bookCount" => $bookCount
        ]);
    }
}
