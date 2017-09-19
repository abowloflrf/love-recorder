<?php
namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments=Comment::orderby('created_at','desc')->get();
        return view('comment-board',compact('comments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(request(), [
            'comment' => 'required',
            'display_name' => 'required',
            'email' => 'required'
        ]);

        Comment::create([
            'comment'=>$request->comment,
            'display_name'=>$request->display_name,
            'email'=>$request->email
        ]);

        return redirect('/board');
    }
}
