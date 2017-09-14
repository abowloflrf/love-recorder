<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        //获得即将要创建的record的id即数据库中将要插入的下一条记录的id
        $nextID=DB::select("show table status like 'records'")[0]->Auto_increment;
        //只获取id
        if($request->has('onlyid')&&$request->onlyid==1){
            return response()->json(['next_id'=>$nextID]);
        }

        //使用cos sdk生成密钥
        $auth = new Auth($appId = $this->config['app_id'], $secretId =$this->config['secret_id'], $secretKey = $this->config['secret_key'].'');
        $expiration = time() + 3600;
        $bucket = env('COS_BUCKET');
        $filepath = '/record/'.$nextID.'/'.$request->file;
        $sign_a = $auth->createReusableSignature($expiration, $bucket, null);//多次签名，文件路径参数可为空
        $sign_b = $auth->createNonreusableSignature($bucket, $filepath);//单词签名，文件路径必须
        //以json形式返回
        return response()->json([
            'sign_a'=>$sign_a,
            'sign_b'=>$sign_b,
            'next_key'=>$nextID
        ]);
    }
}
