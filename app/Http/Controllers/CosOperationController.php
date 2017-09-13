<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//引入腾讯云sdk
use QCloud\Cos\Api;
use QCloud\Cos\Auth;

class CosOperationController extends Controller
{
    var $config;
    var $cosApi;

    public function __construct()
    {
        $this->config = array(
            'app_id' => env('COS_APPID'),
            'secret_id' => env('COS_SECRETID'),
            'secret_key' => env('COS_SECRETKEY'),
            'region' => 'sh',
            'timeout' => 60
        );
        
        $this->cosApi = new Api($this->config);
    }

    public function index(Request $request)
    {
        $auth = new Auth($appId = $this->config['app_id'], $secretId =$this->config['secret_id'], $secretKey = $this->config['secret_key']);
        $expiration = time() + 60;    
        $bucket = env('COS_BUCKET');
        $filepath = $request->file;
        $sign = $auth->createReusableSignature($expiration, $bucket, $filepath);
        dd($sign);
    }
}
