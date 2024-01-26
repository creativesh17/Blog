<?php

namespace App\Http\Controllers\Author;

use App\User;
use App\Tag;
use App\Post;
use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewAuthorPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $posts = Auth::user()->posts()->latest()->get();
        return view('author.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = Category::where('cate_status', 1)->get();
        $tags = Tag::where('tag_status', 1)->get();
        return view('author.post.add', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'category' => 'required',
            'tag' => 'required',
            'pic' => 'required|mimes:jpg,jpeg,png,svg,gif',
        ],[
            'title.required' => 'Please enter post title'
        ]);

        $creator = Auth::user()->id;
        $slug = Str::slug($request['title'], '-');

        $status = isset($request['status']) ? $request['status'] : 0;
        
        if($status != 1) {
            $insert = Post::insertGetId([
                'user_id' => $creator,
                'post_title' => $request['title'],
                'post_body' => $request['body'],
                'post_slug' => $slug,
                'post_status' => 0,
                'post_approved' => 0,
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
        } else {
            $insert = Post::insertGetId([
                'user_id' => $creator,
                'post_title' => $request['title'],
                'post_body' => $request['body'],
                'post_slug' => $slug,
                'post_status' => $status,
                'post_approved' => 0,
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
        }
        

        if($request->hasFile('pic')) {
            $image = $request->file('pic');
            $imageName = "Post_".$insert."_".time()."_".uniqid().".".$image->getClientOriginalExtension();
            

            if(!Storage::disk('public')->exists('posts')) {
                Storage::disk('public')->makeDirectory('posts');
            }

            $postImage = Image::make($image)->resize(1600, 1066)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('posts/'.$imageName,$postImage);
        } else {
            $imageName = 'avatar.png';
        }


        Post::where('post_id', $insert)->update([
            'post_image' => $imageName,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        $post = Post::find($insert);
        $post->categories()->attach($request['category']);
        $post->tags()->attach($request['tag']);
        
        $users = User::where('role_id', 1)->get();
        Notification::send($users, new NewAuthorPost($post));
        
        if($insert) {
            Session::flash('success', 'value');
            return redirect()->route('author.post.index');
        }else {
            Session::flash('error', 'value');
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post) {
        if($post->user_id != Auth::user()->id) {
            Session::flash('warning', 'value');
            return redirect()->back();
        }
        return view('author.post.view', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post) {
        if($post->user_id != Auth::user()->id) {
            Session::flash('warning', 'value');
            return redirect()->route('author.post.index');
        }
        $categories = Category::where('cate_status', 1)->get();
        $tags = Tag::where('tag_status', 1)->get();
        return view('author.post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post) {
        if($post->user_id != Auth::user()->id) {
            Session::flash('warning', 'value');
            return redirect()->route('author.post.index');
        }
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'category' => 'required',
            'tag' => 'required',
            'pic' => 'image',
        ],[
            'title.required' => 'Please enter post title'
        ]);

        $creator = Auth::user()->id;
        $slug = Str::slug($request['title'], '-');
        $status = isset($request['status']) ? $request['status'] : 0; 

        if($status != 1) {
            $update = Post::where('post_id', $post->post_id)->update([
                'user_id' => $creator,
                'post_title' => $request['title'],
                'post_body' => $request['body'],
                'post_slug' => $slug,
                'post_status' => 0,
                'post_approved' => 0,
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
        } else {
            $update = Post::where('post_id', $post->post_id)->update([
                'user_id' => $creator,
                'post_title' => $request['title'],
                'post_body' => $request['body'], 
                'post_slug' => $slug,
                'post_status' => $status,
                'post_approved' => 0,
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
        }

        if($request->hasFile('pic')) {
            $image = $request->file('pic');
            $imageName = "Post_".$post->post_id."_".time()."_".uniqid().".".$image->getClientOriginalExtension();
            

            if(!Storage::disk('public')->exists('posts')) {
                Storage::disk('public')->makeDirectory('posts');
            }

            if(Storage::disk('public')->exists('posts/'.$post->post_image)) {
                Storage::disk('public')->delete('posts/'.$post->post_image);
            }

            $postImage = Image::make($image)->resize(1600, 1066)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('posts/'.$imageName,$postImage);

        } else {
            $imageName = $post->post_image;
        }


        Post::where('post_id', $post->post_id)->update([
            'post_image' => $imageName,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        
        $post->categories()->sync($request['category']);
        $post->tags()->sync($request['tag']);

        if($update) {
            Session::flash('success', 'value');
            return redirect()->route('author.post.index');
        }else {
            Session::flash('error', 'value');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post) {
        if($post->user_id != Auth::user()->id) {
            Session::flash('warning', 'value');
            return redirect()->route('author.post.index');
        }
        // if(File::exists(public_path('storage/posts/'.$post->post_image))) {
        //     File::delete(public_path('storage/posts/'.$post->post_image));
        // }

        if(file_exists('storage/posts/'.$post->post_image)) {
            unlink(public_path('storage/posts/'.$post->post_image));
        }

        $post->categories()->detach();
        $post->tags()->detach();
        $del = Post::where('post_id', $post->post_id)->delete();

        if($del) {
            Session::flash('success', 'value');
            return redirect()->route('author.post.index');
        }else {
            Session::flash('error', 'value');
            return redirect()->back();
        }

    }
}
