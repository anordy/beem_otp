<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function request(Request $request) {
        $validator = Validator::make($request->all(),[
              "msisdn" => "required"
        ]);

        if ($validator->fails()) {
            return array('error' => $validator->errors()->first());
        }
        $api_key = "0e1c52071eb0f8fd";
        $secret_key = "OGZjNTBjN2U0OWQxZjEzNjlhNGZhNTM1NGUyZjEwMTVkNTZjNDhhODkwYmVkNGUwYTQ1OTEwMGY1NWYwMGNjMw==";
        $header =  array(
            'Authorization:Basic ' . base64_encode("$api_key:$secret_key"),
            "Content-Type:application/json"
        );

        $myData = (Object) array();
        $myData->msisdn = $request->msisdn;
        $myData->appId = 204;
        $myData = json_encode($myData);

        $url = "https://apiotp.beem.africa/v1/request";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $myData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $response = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($response);
        return response()->json(['results' => $results]);

    }
}
