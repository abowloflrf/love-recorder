<?php
namespace App\Http\Controllers;

use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//引入腾讯云sdk
use QCloud\Cos\Api;
use QCloud\Cos\Auth;
//引入Faker
use Faker\Factory;

class RecordController extends Controller
{
    var $config;
    var $cosApi;
    //因为涉及到record的操作大多需要调用cos来操作其中的图片，因此创建一个构造函数，构造一个cosApi对象
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

    //返回create页视图
    public function createView()
    {
        if (!auth()->check()) {
            return view('auth.not-login');
        }
        elseif (auth()->user()->member < 3) {
            $nextID = DB::select("show table status like 'records'")[0]->Auto_increment;
            return view('create', compact('nextID'));
        }
        else {
            return view('auth.permission-deny');
        }
    }

    //将新建的record信息储存到数据库
    public function store(Request $request)
    {
        $this->validate(request(), [
            'title' => 'required|max:30',
            'body' => 'required|max:140',
            'cover_img' => 'required',
            'date_and_time' => 'required'
        ]);

        if ($request->has('private') && $request->private == 'on') {
            $isPrivate = 1;
        }
        else {
            $isPrivate = 0;
        }

        Record::create([
            'title' => request('title'),
            'body' => request('body'),
            'cover_img' => request('cover_img'),
            'user_id' => auth()->user()->id,
            'date_and_time' => request('date_and_time'),
            'private' => $isPrivate
        ]);

        return redirect('/home');
    }

    //返回修改record视图
    public function editView($id)
    {
        if (!auth()->check()) {
            return view('auth.not-login');
        }
        elseif (auth()->user()->member < 3) {
            $record = Record::find($id);
            return view('edit', compact('record'));
        }
        else {
            return view('auth.permission-deny');
        }
    }

    //更新record数据到数据库
    public function update(Request $request)
    {
        $this->validate(request(), [
            'title' => 'required|max:30',
            'body' => 'required|max:140',
            'cover_img' => 'required',
            'date_and_time' => 'required'
        ]);

        if ($request->has('private') && $request->private == 'on') {
            $isPrivate = 1;
        }
        else {
            $isPrivate = 0;
        }

        DB::table('records')->where('id', $request->record_id)->update([
            'title' => $request->title,
            'body' => $request->body,
            'date_and_time' => $request->date_and_time,
            'cover_img' => $request->cover_img,
            'private' => $isPrivate
        ]);

        return redirect('/home');
    }

    //删除record信息且同时删除腾讯云中相应的图片
    public function delete(Record $record)
    {   
        //获取当前record所在目录
        $fileDir = '/record/' . $record->id . '/';
        //列出当前目录所有文件
        $result = $this->cosApi->listFolder(env('COS_BUCKET'), $fileDir, null, null, 'eListFileOnly');
        //逐个删除目录中的文件
        $files = $result['data']['infos'];
        foreach ($files as $file)
            {
            $fileKey = substr($file['access_url'], 48);
            $delResult = $this->cosApi->delFile(env('COS_BUCKET'), $fileKey);
            //TODO:删除报错时提供错误信息
            // if($delResult['code']!=0){
            //     dd($delResult['message']);
            // }

        }
        //删除数据库中的记录
        $record->delete();
        return redirect('/home');
    }

    public function loveUp(Record $record)
    {
        $record->loves++;
        if ($record->save())
            return ['status' => 1];
        else
            return ['status' => 0];
    }


//apis
    //获取指定的记录
    public function getRecord(Record $record)
    {
        //TODO:改进为不论提供什么参数都有json返回，而不是错误则返回404页面
        if ($record->private && (!auth()->check() || auth()->user()->member == 3)) {
            abort(404);
        };
        $data = [
            "title" => $record->title,
            "user_id" => $record->user_id,
            "user_name" => $record->user()->value('name'),
            "user_avatar"=> $record->user()->value('avatar'),
            "cover_img" => $record->cover_img,
            "body" => $record->body,
            "date_and_time" => $record->date_and_time,
            "private" => $record->private,
            "loves"=>$record->loves
        ];
        return response()->json($data);
    }
}
