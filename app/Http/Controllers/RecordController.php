<?php

namespace App\Http\Controllers;

use App\Record;
use Illuminate\Http\Request;

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
            'user_id'=>auth()->user()->id,
            'date_and_time'=>\request('date_and_time')
        ]);
        return redirect('/home');
    }
}
