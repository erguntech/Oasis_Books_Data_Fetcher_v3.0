<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiSettingsRequest;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use QCod\Settings\Setting\Setting;
use Illuminate\Support\Facades\Http;

class ApiSettingsController extends Controller
{
    public function index(){
        return view('pages.api_settings.api_settings_index');
    }

    public function update(ApiSettingsRequest $request){
        settings()->group('api_settings')->set('xml_address', $request->input('input-xml_address'));
        settings()->group('api_settings')->set('store_name', $request->input('input-store_name'));
        settings()->group('api_settings')->set('store_code', $request->input('input-store_code'));
        settings()->group('api_settings')->set('category_name', $request->input('input-category_name'));
        settings()->group('api_settings')->set('brand_name', $request->input('input-brand_name'));
        settings()->group('api_settings')->set('store_api_key', $request->input('input-store_api_key'));
        settings()->group('api_settings')->set('store_api_password', $request->input('input-store_api_password'));
        settings()->group('api_settings')->set('api_key', $request->input('input-api_key'));
        settings()->group('api_settings')->set('api_password', $request->input('input-api_password'));

        return redirect()->route('ApiSettings.Index')
            ->with('result', 'success')
            ->with('title', 'İşlem Başarılı')
            ->with('content', 'Kayıtlar başarı ile güncellendi.');
    }

    public function apiTest(Request $request){
        $apiKey = $request->apiKey;
        $apiPassword = $request->apiPassword;

        $response = Http::post('https://kmk.apiservisi.com/api/c2c/UserServices/GetAll', [
            "ApiKey" => $apiKey,
            "ApiPassword" => $apiPassword
        ]);

        $arrayKeyExists = array_key_exists('hata', json_decode($response->body(), true)) ? true : false;

        if($arrayKeyExists == true) {
            $status = "Failed";
        } else {
            $status = "Success";
        }

        return response()->json([
            "status" => $status
        ]);
    }
}
