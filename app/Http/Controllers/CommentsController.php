<?php

namespace App\Http\Controllers;

use App\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller {
    public function insert(Request $request, $post) {
        $this->validate($request, [
            'comment' => 'required',
        ]);

        $user = Auth::id();
        $insert = Comment::insert([
            'post_id' => $post,
            'user_id' => $user,
            'comment' => $request->comment,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        if($insert) {
            return back()->with('success', 'Comment Successfully published');
        }else {
            return back()->with('error', 'Comment was not published');
        }
    }
}
