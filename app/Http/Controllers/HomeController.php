<?php

namespace App\Http\Controllers;

use App\Record;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=Record::orderby('date_and_time','desc')->paginate(10);
        return view('home',compact('records'));
    }
}
