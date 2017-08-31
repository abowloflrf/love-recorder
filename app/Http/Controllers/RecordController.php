<?php

namespace App\Http\Controllers;

use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//引入七牛sdk
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

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

        $nextID=DB::select("show table status like 'records'")[0]->Auto_increment;
        $bucket="love-recorder";
        $accessKey = env('QINIU_ACCESSKEY');
        $secretKey = env('QINIU_SECRETKEY');
        $auth = new Auth($accessKey, $secretKey);
            //上传策略
            $policy = array(
                 //指定scope为bucket:key,key为record/id/recorder-img
                 "scope"=>"love-recorder:record/".$nextID."/recorder-img",
                 //指定文件上传文件类型为图片
                 "mimeLimit"=>"image/*",
                 //指定上传文件最大为10m
                 "fsizeLimit"=>10485760
                );
        $upToken = $auth->uploadToken($bucket, 'record/'.$nextID.'/recorder-img', 3600, $policy);
        //上传文件的本地路径
        $filePath = $request->file('file')->getPathname();
        $fileName = $request->file('file')->getClientOriginalName();
        
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($upToken,'record/'.$nextID.'/recorder-img',$filePath);
        if ($err !== null) {
            return json_encode($err->getResponse());
        } else {
            return json_encode($ret);
        }
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
        $bucket="love-recorder";
        $accessKey = env('QINIU_ACCESSKEY');
        $secretKey = env('QINIU_SECRETKEY');
        $auth = new Auth($accessKey, $secretKey);
            //上传策略
            $policy = array(
                 //指定scope为bucket:key,key为record/id/recorder-img
                 "scope"=>"love-recorder:record/".$request->id."/recorder-img",
                 //指定文件上传文件类型为图片
                 "mimeLimit"=>"image/*",
                 //指定上传文件最大为10m
                 "fsizeLimit"=>10485760
                );
        $upToken = $auth->uploadToken($bucket, 'record/'.$request->id.'/recorder-img', 3600, $policy);
        //上传文件的本地路径
        $filePath = $request->file('file')->getPathname();
        $fileName = $request->file('file')->getClientOriginalName();
        
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($upToken,'record/'.$request->id.'/recorder-img',$filePath);
        if ($err !== null) {
            return json_encode($err->getResponse());
        } else {
            return json_encode($ret);
        }
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
        $accessKey = env('QINIU_ACCESSKEY');
        $secretKey = env('QINIU_SECRETKEY');
        $auth = new Auth($accessKey, $secretKey);
        //初始化BucketManager
        $bucketMgr = new BucketManager($auth);
        //你要测试的空间， 并且这个key在你空间中存在
        $bucket="love-recorder";
        $key = 'record/'.$record->id.'/recorder-img';
        $err = $bucketMgr->delete($bucket, $key);
        if ($err !== null) {
            echo json_encode($err->getResponse());
        }
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
