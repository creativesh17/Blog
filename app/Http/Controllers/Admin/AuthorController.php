<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AuthorController extends Controller {
    public function index() {
        $authors = User::authors()
                        ->withCount('favorite_posts')
                        ->withCount('comments')
                        ->withCount('posts')->get();
        return view('admin.authors', compact('authors'));
    }

    public function destroy($id) {
        $del = User::findOrFail($id)->delete();
        if($del) {
            Session::flash('success', 'Author Deleted Successfully!');
            return redirect()->back();
        }else {
            Session::flash('error', 'An error occurred!');
            return redirect()->back();
        }
    }
}
