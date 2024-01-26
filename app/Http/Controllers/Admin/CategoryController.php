<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('admin.category.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:60|unique:categories,cate_name',
            'pic' => 'required|mimes:png,jpg,jpeg,bmp'
        ],[
            'name.required' => 'Category Name is Required'
        ]);
        
        $slug = Str::slug($request['name'], '-');
        if($request->hasFile('pic')) {
            $image = $request->file('pic');
            $imageName = "category_".$slug."_".time()."_".uniqid().".".$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('category')) {
                Storage::disk('public')->makeDirectory('category');
            }

            $category_image_large = Image::make($image)->resize(1600, 479)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('category/'.$imageName, $category_image_large);


            if(!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }

            $category_image_slider = Image::make($image)->resize(500, 333)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('category/slider/'.$imageName, $category_image_slider);


            $insert = Category::insert([
                'cate_name' => $request['name'],
                'cate_image' => $imageName,
                'cate_slug' => $slug,
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
        }

        
        if($insert) {
            Session::flash('success', 'value');
            return redirect()->route('admin.category.index');
        }else {
            Session::flash('error', 'value');
            return redirect()->route('admin.category.index');
        }

    }

    
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
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
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
            'name' => 'required',
            'pic' => 'mimes:png,jpg,jpeg,bmp'
        ],[
            'name.required' => 'Category Name is Required'
        ]);

        $category = Category::find($id);
        $slug = Str::slug($request['name'], '-');

        if($request->hasFile('pic')) {
            $image = $request->file('pic');
            $imageName = "category_".$slug."_".time()."_".uniqid().".".$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('category')) {
                Storage::disk('public')->makeDirectory('category');
            }
            if(Storage::disk('public')->exists('category/'.$category->cate_image)) {
                Storage::disk('public')->delete('category/'.$category->cate_image);
            }
            $category_image_large = Image::make($image)->resize(1600, 479)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('category/'.$imageName, $category_image_large);


            if(!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }
            if(Storage::disk('public')->exists('category/slider/'.$category->cate_image)) {
                Storage::disk('public')->delete('category/slider/'.$category->cate_image);
            }

            $category_image_slider = Image::make($image)->resize(500, 333)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('category/slider/'.$imageName, $category_image_slider);


            $update = Category::where('cate_id', $id)->update([
                'cate_name' => $request['name'],
                'cate_image' => $imageName,
                'cate_slug' => $slug,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
        }

        
        if($update) {
            Session::flash('success', 'value');
            return redirect()->route('admin.category.index');
        }else {
            Session::flash('error', 'value');
            return redirect()->route('admin.category.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $category = Category::find($id);

        if(Storage::disk('public')->exists('category/'.$category->cate_image)) {
            Storage::disk('public')->delete('category/'.$category->cate_image);
        }
        if(Storage::disk('public')->exists('category/slider/'.$category->cate_image)) {
            Storage::disk('public')->delete('category/slider/'.$category->cate_image);
        }

        $del = Category::where('cate_status', 1)->where('cate_id', $id)->delete();

        if($del) {
            Session::flash('success', 'value');
            return redirect()->back();
        }else {
            Session::flash('error', 'value');
            return redirect()->back();
        }
    }
}
