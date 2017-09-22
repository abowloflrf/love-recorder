<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//引入腾讯云sdk
use QCloud\Cos\Api;
use QCloud\Cos\Auth;

class CosTokenController extends Controller
{
    var $config;
    var $cosApi;
    //构造一个cosApi对象
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

    //单词签名必须要请求参数path
    public function once(Request $request)
    {
        //使用cos sdk生成密钥
        $auth = new Auth($appId = $this->config['app_id'], $secretId = $this->config['secret_id'], $secretKey = $this->config['secret_key']);
        $expiration = time() + 3600;
        $bucket = env('COS_BUCKET');
        $sign = $auth->createNonreusableSignature($bucket, $request->path);//单次签名，文件路径必须
        //以json形式返回
        return response()->json([
            'sign' => $sign,
        ]);
    }

    public function reusable(Request $request)
    {
        //使用cos sdk生成密钥
        $auth = new Auth($appId = $this->config['app_id'], $secretId = $this->config['secret_id'], $secretKey = $this->config['secret_key']);
        $expiration = time() + 3600;
        $bucket = env('COS_BUCKET');
        $sign = $auth->createReusableSignature($expiration, $bucket, null);//多次签名，文件路径参数可为空
        //以json形式返回
        return response()->json([
            'sign' => $sign,
        ]);
    }

}
