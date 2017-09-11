<?php

namespace App\Http\Controllers;

use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//引入七牛sdk
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;
//引入又拍云sdk
use Upyun\Upyun;
use Upyun\Config;
//引入腾讯云sdk
use QCloud\Cos\Api;

class RecordController extends Controller
{
    public function create()
    {
        if (!auth()->check()) {
            return view('auth.not-login');
        }elseif (auth()->user()->member<3){
            return view('layouts.create');
        }else{
            return view('auth.permission-deny');
        }
    }

    public function store()
    {
        $this->validate(request(),[
            'title'=>'required|max:30',
            'body'=>'required|max:140',
            'cover_img'=>'required',
            'date_and_time'=>'required'
        ]);

        Record::create([
            'title'=>request('title'),
            'body'=>request('body'),
            'cover_img'=>request('cover_img'),
            'user_id'=>auth()->user()->id,
            'date_and_time'=>request('date_and_time')
        ]);

        return redirect('/home');
    }

    public function imgUpload(Request $request)
    {
        // $bucketConfig = new Config('ruofeng-img', env('UPYUN_OPERATOR'), env('UPYUN_PASSWORD'));
        // $client = new Upyun($bucketConfig);

        // $filePath = $request->file('file')->getPathname();
        // $fileName = $request->file('file')->getClientOriginalName();
        // $nextID=DB::select("show table status like 'records'")[0]->Auto_increment;

        // $file = fopen($filePath, 'r');
        // //上传文件
        // $saveKey="record/".$nextID."/".$fileName;
        // $res = $client->write($saveKey, $file);
        // $res['file']=$saveKey;
        // return json_encode($res);
        $config = array(
            'app_id' => env('COS_APPID'),
            'secret_id' => env('COS_SECRETID'),
            'secret_key' => env('COS_SECRETKEY'),
            'region' => 'sh',
            'timeout' => 200
        );
        $cosApi = new Api($config);

        $filePath = $request->file('file')->getPathname();
        $fileName = $request->file('file')->getClientOriginalName();
        $nextID=DB::select("show table status like 'records'")[0]->Auto_increment;
        $saveKey='/record/'.$nextID.'/'.$fileName;
        // 上传文件
        $ret = $cosApi->upload(env('COS_BUCKET'), $filePath, $saveKey);
        $ret['saveKey']=$saveKey;      
        return $ret;
    }

    public function editView($id)
    {
        if (!auth()->check()) {
            return view('auth.not-login');
        }elseif (auth()->user()->member<3){
            $record=Record::find($id);
            return view('edit',compact('record'));
        }else{
            return view('auth.permission-deny');
        }
    }

    public function changeImg(Request $request)
    {
        $bucketConfig = new Config('ruofeng-img', env('UPYUN_OPERATOR'), env('UPYUN_PASSWORD'));
        $client = new Upyun($bucketConfig);

        $filePath = $request->file('file')->getPathname();
        $fileName = $request->file('file')->getClientOriginalName();

        $file = fopen($filePath, 'r');
        //上传文件
        $saveKey="record/".$request->id."/".$fileName;
        $res = $client->write($saveKey, $file);
        $res['file']=$saveKey;
        return json_encode($res);
    }

    public function update()
    {
        $this->validate(request(),[
            'title'=>'required|max:30',
            'body'=>'required|max:140',
            'cover_img'=>'required',
            'date_and_time'=>'required'
        ]);

        $record=Record::find(request('record_id'));
        $record->title=request('title');
        $record->body=request('body');
        $record->date_and_time=request('date_and_time');
        $record->cover_img=request('cover_img');
        $record->save();

        return redirect('/home');
    }

    public function delete(Record $record)
    {   
        $bucketConfig = new Config('ruofeng-img', env('UPYUN_OPERATOR'), env('UPYUN_PASSWORD'));
        $client = new Upyun($bucketConfig);
        //截取图片的url前面部分，获得在又拍云储存空间中图片相应的位置
        $fileKey=substr($record->cover_img,34);
        //删除相应图片
        //$resFile=$client->delete($fileKey);
        //获取record图片所在目录并删除相应目录
        $fileDir="/record/".$record->id;
        //$resDir=$client->deleteDir($fileDir);
        //删除数据库中的记录
        $record->delete();
        return redirect('/home');
    }

//apis
    public function getRecord(Record $record){
        $data=[
            "title"=>$record->title,
            "user_id"=>$record->user_id,
            "user_name"=>$record->user()->value('name'),
            "cover_img"=>$record->cover_img,
            "body"=>$record->body,
            "date_and_time"=>$record->date_and_time
        ];
        return $data;
    }
}
