<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProfileController extends Controller
{
    public function viewProfile(\App\User $user)
    {
        return view('profile',compact('user'));
    }

    public function viewSettings()
    {
        $user=auth()->user();
        return view('settings',compact('user'));
    }

    public function update(Request $request)
    {
        $this->validate(request(), [
            'avatar' => 'required'
        ]);

        DB::table('users')->where('id', $request->user()->id)->update([
            'avatar' => $request->avatar,
            'intro' => $request->intro
        ]);

        return redirect('/settings');
    }
}
