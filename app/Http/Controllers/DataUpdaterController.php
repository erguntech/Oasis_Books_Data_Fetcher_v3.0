<?php

namespace App\Http\Controllers;

use App\Models\XMLBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DataUpdaterController extends Controller
{
    public function index(Request $request){
        $apiKey = settings()->group('api_settings')->get('api_key');
        $apiPassword = settings()->group('api_settings')->get('api_password');
        $storeCode = settings()->group('api_settings')->get('store_code');
        $storeDomain = "www.oasisbooks.com.tr";

        $response = Http::post('https://kmk.apiservisi.com/api/c2c/ProductServices/GetByStoreCode', [
            "ApiKey" => $apiKey,
            "ApiPassword" => $apiPassword,
            "StoreCode" => $storeCode,
        ]);

        $arrayKeyExists = array_key_exists('hata', json_decode($response->body(), true)) ? true : false;

        if($arrayKeyExists == true) { $kmkBookCount = "Başarısız"; } else {
            $kmkBookCount = count(json_decode($response->body(), true));
        }

        $bookCount = XMLBook::all()->count();
        return view('pages.data_updater.data_updater_index', compact('bookCount', 'kmkBookCount'));
    }

    public function update(Request $request){
        ini_set('max_execution_time', 3600000);

        $apiKey = settings()->group('api_settings')->get('api_key');
        $apiPassword = settings()->group('api_settings')->get('api_password');
        $storeCode = settings()->group('api_settings')->get('store_code');
        $storeApiKey = settings()->group('api_settings')->get('store_api_key');
        $storeApiPassword = settings()->group('api_settings')->get('store_api_password');
        $storeCategory = settings()->group('api_settings')->get('category_name');
        $storeBrand = settings()->group('api_settings')->get('brand_name');
        $storeDomain = "www.oasisbooks.com.tr";

        $response = Http::post('https://kmk.apiservisi.com/api/c2c/ProductServices/GetByStoreCode', [
            "ApiKey" => $apiKey,
            "ApiPassword" => $apiPassword,
            "StoreCode" => $storeCode,
        ]);

        $arrayKeyExists = array_key_exists('hata', json_decode($response->body(), true)) ? true : false;

        if($arrayKeyExists == true) { $status = "Failed"; } else {
            foreach (json_decode($response->body(), true) as $kmkBook) {
                $xmlBook = XMLBook::where('book_barcode_no', $kmkBook['urunKodu'])->first();
                if($xmlBook) {
                    if ($xmlBook->book_is_updated == false) {
                        // KMK tarafındaki kitap bizdeki ile eşleşirse stok sorgula ve güncelle
                        Http::post('https://kmk.apiservisi.com/api/c2c/StoreProductServices/UpdateProductStockByProductCode', [
                            "Domain" => $storeDomain,
                            "ApiKey" => $storeApiKey,
                            "ApiPassword" => $storeApiPassword,
                            "UrunKodu" => $xmlBook->book_barcode_no,
                            "UrunStok" => $xmlBook->book_stock
                        ]);
                        $xmlBook->book_is_updated = true;
                    }

                    $xmlBook->save();
                } else {
                    // KMK tarafındaki kitap bizdeki ile eşleşmezse stoğu 0'a çek
                    Http::post('https://kmk.apiservisi.com/api/c2c/StoreProductServices/UpdateProductStockByProductCode', [
                        "Domain" => $storeDomain,
                        "ApiKey" => $storeApiKey,
                        "ApiPassword" => $storeApiPassword,
                        "UrunKodu" => $kmkBook['urunKodu'],
                        "UrunStok" => 0
                    ]);
                }
            }

            $newBooks = XMLBook::where('book_is_updated', false)->get(); // Bizde yeni giriş yapan kitaplar

            foreach ($newBooks as $newBook) {
                Http::post('https://kmk.apiservisi.com/api/c2c/StoreProductServices/SaveProduct', [
                    "Domain" => $storeDomain,
                    "ApiKey" => $storeApiKey,
                    "ApiPassword" => $storeApiPassword,
                    "UrunOzelKodu" => "",
                    "UrunIzinKodu" => "",
                    "UrunMarka" => $storeBrand,
                    "UrunKategorileri"  => [$storeCategory],
                    "UrunUretimTarihi" => "01.01.2010 00:00",
                    "UrunSonKullanmaTarihi" => "01.01.2050 00:00",
                    "UrunHazirlanmaSuresi" => 0,
                    "UrunKodu" => $newBook->book_barcode_no,
                    "UrunGtinKodu" => $newBook->book_author_name,
                    "UrunMpnKodu" => "",
                    "UrunBaslik" => $newBook->book_name,
                    "UrunAltBaslik" => "",
                    "UrunAciklama" => "",
                    "UrunDetay" => $newBook->book_description,
                    "UrunAlisFiyati" => "0,00",
                    "UrunFiyati" => $newBook->book_price,
                    "UrunIndirimTutari" => "0,0",
                    "UrunParaBirimi" => "TL",
                    "UrunKargoDesi" => 1,
                    "UrunBirimId" =>  1,
                    "UrunStok" => $newBook->book_stock,
                    "UrunVariantlari" => [],
                    "UrunMinimumSatisMiktari" => 0,
                    "UrunMaximumSatisMiktari" => 0,
                    "UrunFotograflari" => [$newBook->book_image],
                    "UrunDurumu" => "Aktif"
                ]);

                $newBook->book_is_updated = true;
                $newBook->save();
            }

            $status = "Success";
        }

        return response()->json([
            "status" => $status
        ]);
    }
}
