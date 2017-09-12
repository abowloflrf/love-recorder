<?php

namespace App\Http\Controllers;

use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

//引入腾讯云sdk
use QCloud\Cos\Api;
//引入Faker
use Faker\Factory;

class RecordController extends Controller
{
    public function create()
    {
        if (!auth()->check()) {
            return view('auth.not-login');
        }elseif (auth()->user()->member<3){
            $faker = Factory::create();
            return view('layouts.create',compact('faker'));
        }else{
            return view('auth.permission-deny');
        }
    }

    public function store(Request $request)
    {
        $this->validate(request(),[
            'title'=>'required|max:30',
            'body'=>'required|max:140',
            'cover_img'=>'required',
            'date_and_time'=>'required'
        ]);

        if($request->has('private')&&$request->private=='on'){
            $isPrivate=1;
        }else{
            $isPrivate=0;
        }

        Record::create([
            'title'=>request('title'),
            'body'=>request('body'),
            'cover_img'=>request('cover_img'),
            'user_id'=>auth()->user()->id,
            'date_and_time'=>request('date_and_time'),
            'private'=>$isPrivate
        ]);

        return redirect('/home');
    }

    public function imgUpload(Request $request)
    {
        //TODO: 验证上传文件类型，大小，否则返回错误
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
        //TODO: 验证上传文件类型，大小，否则返回错误
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
        $saveKey='/record/'.$request->id.'/'.$fileName;
        // 上传文件
        $ret = $cosApi->upload(env('COS_BUCKET'), $filePath, $saveKey);
        $ret['saveKey']=$saveKey;      
        return $ret;
    }

    public function update(Request $request)
    {
        $this->validate(request(),[
            'title'=>'required|max:30',
            'body'=>'required|max:140',
            'cover_img'=>'required',
            'date_and_time'=>'required'
        ]);
        
        if($request->has('private')&&$request->private=='on'){
            $isPrivate=1;
        }else{
            $isPrivate=0;
        }
        
        $record=Record::find(request('record_id'));
        $record->title=request('title');
        $record->body=request('body');
        $record->date_and_time=request('date_and_time');
        $record->cover_img=request('cover_img');
        $record->private=$isPrivate;
        $record->save();

        return redirect('/home');
    }

    public function delete(Record $record)
    {   
        $config = array(
            'app_id' => env('COS_APPID'),
            'secret_id' => env('COS_SECRETID'),
            'secret_key' => env('COS_SECRETKEY'),
            'region' => 'sh',
            'timeout' => 200
        );

        //获取当前record所在目录
        $fileDir='/record/'.$record->id.'/';
        //列出当前目录所有文件
        $result = $cosApi->listFolder(env('COS_BUCKET'), $fileDir,null,null,'eListFileOnly');
        //逐个删除目录中的文件
        $files=$result['data']['infos'];
        foreach($files as $file)
        {
            $fileKey=substr($file['access_url'],48);
            $delResult = $cosApi->delFile(env('COS_BUCKET'), $fileKey);
            //TODO:删除报错时提供相应的相应
            // if($delResult['code']!=0){
            //     dd($delResult['message']);
            // }
        }
        $record->delete();
        return redirect('/home');
    }

//apis
    public function getRecord(Record $record){
        //TODO:改进为不论提供什么参数都有json返回，而不是错误则返回404页面
        if($record->private&&(!Auth::check()||auth()->user()->member==3)){
            abort(404);
        };
        $data=[
            "title"=>$record->title,
            "user_id"=>$record->user_id,
            "user_name"=>$record->user()->value('name'),
            "cover_img"=>$record->cover_img,
            "body"=>$record->body,
            "date_and_time"=>$record->date_and_time,
            "private"=>$record->private
        ];
        return $data;
    }
}
