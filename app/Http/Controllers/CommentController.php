<?php
namespace App\Http\Controllers;

use App\Comment;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'email' => 'required',
            'captcha' => 'required|captcha'
        ]);

        Comment::create([
            'comment'=>$request->comment,
            'display_name'=>$request->display_name,
            'email'=>$request->email
        ]);

        return redirect('/board');
    }

    public function reply(Request $request)
    {
        //若已经被回复则直接跳转
        if(DB::table('comments')->where('id', $request->reply_to_id)->value('is_replied'))
        {
            return redirect('/board');
        }
        //回复
        $this->validate(request(), [
            'reply_to_id'=>'required'
        ]);

        Reply::create([
            'reply_to_id'=>$request->reply_to_id,
            'reply_user_id'=>auth()->user()->id,
            'reply_body'=>$request->reply_body
        ]);

        DB::table('comments')->where('id', $request->reply_to_id)->update([
            'is_replied'=>TRUE
        ]);

        return redirect('/board');
    }
}
