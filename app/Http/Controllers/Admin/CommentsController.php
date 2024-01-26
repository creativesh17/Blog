<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CommentsController extends Controller {
    public function index() {
        $comments = Comment::latest()->get();
        return view('admin.comments', compact('comments'));
    }

    public function delete($id) {
        // Comment::findOrFail($id);
        $comment = Comment::findOrFail($id)->delete();
        if($comment) {
            Session::flash('success', 'value');
            return redirect()->back();
        }else {
            Session::flash('error', 'value');
            return redirect()->back();
        }
    }
}
