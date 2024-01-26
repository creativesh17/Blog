<?php

namespace App\Http\Controllers\Admin;


use App\Tag;
use App\Post;
use App\Category;
use Carbon\Carbon;
use App\Subscriber;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewPostNotify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Notifications\AuthorPostApproved;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $posts = Post::latest()->get();
        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = Category::where('cate_status', 1)->get();
        $tags = Tag::where('tag_status', 1)->get();
        return view('admin.post.add', compact('categories', 'tags'));
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
                'post_approved' => 1,
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
        } else {
            $insert = Post::insertGetId([
                'user_id' => $creator,
                'post_title' => $request['title'],
                'post_body' => $request['body'],
                'post_slug' => $slug,
                'post_status' => $status,
                'post_approved' => 1,
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

        $subscribers = Subscriber::where('subscriber_status', 1)->get();
        foreach($subscribers as $subscriber) {
            Notification::route('mail', $subscriber->subscriber_email)
                            ->notify(new NewPostNotify($post));

        }

        if($insert) {
            Session::flash('success', 'value');
            return redirect()->route('admin.post.index');
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
        return view('admin.post.view', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post) {
        $categories = Category::where('cate_status', 1)->get();
        $tags = Tag::where('tag_status', 1)->get();
        return view('admin.post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post) {
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
                'post_approved' => 1,
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
        } else {
            $update = Post::where('post_id', $post->post_id)->update([
                'user_id' => $creator,
                'post_title' => $request['title'],
                'post_body' => $request['body'],
                'post_slug' => $slug,
                'post_status' => $status,
                'post_approved' => 1,
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
            return redirect()->route('admin.post.index');
        }else {
            Session::flash('error', 'value');
            return redirect()->back();
        }
    }

    public function pending() {
        $posts = Post::where('post_approved', 0)->get();
        return view('admin.post.pending', compact('posts'));
    }

    public function approval($id) {
        $post = Post::find($id);
        if($post->post_approved == 0) {
            Post::where('post_id', $id)->where('post_approved', 0)->update([
                'post_approved' => 1,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            
            $post->author->notify(new AuthorPostApproved($post));

            $subscribers = Subscriber::where('subscriber_status', 1)->get();
            foreach($subscribers as $subscriber) {
            Notification::route('mail', $subscriber->subscriber_email)
                            ->notify(new NewPostNotify($post));
            }
        }
        

        
        if($post) {
            Session::flash('success', 'Post has been approved');
            return redirect()->back();
        }else {
            Session::flash('error', 'Post remains unapproved');
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
            return redirect()->route('admin.post.index');
        }else {
            Session::flash('error', 'value');
            return redirect()->back();
        }
    }

}
