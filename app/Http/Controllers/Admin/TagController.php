<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Str;
use App\Tag;
use Session;

class TagController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        // $tags = Tag::latest()->get();
        $tags = Tag::where('tag_status', 1)->orderBy('tag_id', 'DESC')->get();
        return view('admin.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.tag.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:20',
        ],[
            'name.required' => 'Please enter tag name',
        ]);
        
        $slug = Str::slug($request['name'], '-');
        $insert = Tag::insert([
            'tag_name' => $request->name,
            'tag_slug' => $slug,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

    
        if($insert) {
            Session::flash('success', 'value');
            return redirect()->route('admin.tag.create');
        }else {
            Session::flash('error', 'value');
            return redirect()->route('admin.tag.create');
        }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = Tag::where('tag_status', 1)->where('tag_id', $id)->firstOrFail();
        return view('admin.tag.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|max:20',
        ],[
            'name.required' => 'Please enter tag name',
        ]);
        
        $slug = Str::slug($request['name'], '-');
        $update = Tag::where('tag_status', 1)->where('tag_id', $id)->update([
            'tag_name' => $request->name,
            'tag_slug' => $slug,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

    
        if($update) {
            Session::flash('success', 'value');
            return redirect()->route('admin.tag.index');
            session()->forget('success');
        }else {
            Session::flash('error', 'value');
            return redirect()->route('admin.tag.edit', $id);
            session()->forget('error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $delete = Tag::where('tag_id', $id)->delete();

        if($delete) {
            Session::flash('success', 'value');
            return redirect()->route('admin.tag.index');
            session()->forget('success');
        }else {
            Session::flash('error', 'value');
            return redirect()->route('admin.tag.edit', $id);
            session()->forget('error');
        }

    }
}
