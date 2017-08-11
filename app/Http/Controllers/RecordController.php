<?php

namespace App\Http\Controllers;

use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//引入七牛sdk
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class RecordController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return view('auth.not-login');
        }elseif (auth()->user()->member<3){
            return view('layouts.create');
        }else{
            return view('auth.permisson-deny');
        }

    }

    public function getRecord(Record $record){
        $data=[
            "title"=>$record->title,
            "user_id"=>$record->user_id,
            "user_name"=>$record->user()->value('name'),
            "cover_img"=>$record->cover_img,
            "body"=>$record->body,
            "created_at"=>$record->created_at->toDayDateTimeString()
        ];
        return $data;

    }

    public function store()
    {
        $this->validate(\request(),[
            'title'=>'required|max:50',
            'body'=>'required',
            'date_and_time'=>'required'
        ]);

        Record::create([
            'title'=>\request('title'),
            'body'=>\request('body'),
            'cover_img'=>request('cover_img'),
            'user_id'=>auth()->user()->id,
            'date_and_time'=>\request('date_and_time')
        ]);
        return redirect('/home');
    }

    public function imgUpload(Request $request)
    {

        $nextID=DB::select("show table status like 'records'")[0]->Auto_increment;
        $bucket="love-recorder";
        $accessKey = "P2Nrd6OvmVr9R62aeFkl5CZpCi73qJRgPFZV4V85";
        $secretKey = "lsZKO7kPKesiq7A-s3TRTXV9k-oHHbartCxN34Im";
        $auth = new Auth($accessKey, $secretKey);
            $policy = array(
                 "scope"=>"love-recorder:record/".$nextID."/recorder-img",
                 "mimeLimit"=>"image/*",
                 "fsizeLimit"=>10485760
                );
        $upToken = $auth->uploadToken($bucket, 'record/'.$nextID.'/recorder-img', 3600, $policy);
        //上传文件的本地路径
        $filePath = $request->file('file')->getPathname();
        $fileName = $request->file('file')->getClientOriginalName();
        // dd($request->file('file')->getSize());
        
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($upToken,'record/'.$nextID.'/recorder-img',$filePath);
        if ($err !== null) {
            return json_encode($err->getResponse());
        } else {
            return json_encode($ret);
        }
    }
}
