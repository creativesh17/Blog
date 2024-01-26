<?php

namespace App\Http\Controllers\Author;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller {
    public function index() {
        return view('author.settings');
    }

    public function updateProfile(Request $request) {
        $user = User::findOrFail(Auth::id());
        $slug = Str::slug($request['name']);

        if($user->email == $request['email']) {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'photo' => 'required|image',
            ], [
                'email.required' => 'Please enter your email!',
                'photo.required' => 'Please enter profile image!',
            ]);
        }else {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'photo' => 'required|image',
            ], [
                'email.required' => 'Please enter your email!',
                'photo.required' => 'Please enter profile image!',
            ]);
        }

        $profile = User::where('id', $user->id)->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'about' => $request['about'],
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        if($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = 'profile-'.time()."-".uniqid().".".$image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('profile')) {
                Storage::disk('public')->makeDirectory('profile');
            }

            if(Storage::disk('public')->exists('profile/'.$user->photo)) {
                Storage::disk('public')->delete('profile/'.$user->photo);
            }

            $profileImage = Image::make($image)->fit(500, 500)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('profile/'.$imageName, $profileImage);
        }else {
            $imageName = $user->photo;
        }

        User::where('id', $user->id)->update([
            'photo' => $imageName,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        if($profile) {
            Session::flash('success', 'Profile Updated successfully');
            return redirect()->back();
        }else {
            Session::flash('error', 'value');
            return redirect()->back();
        }
    }

    public function updatePassword(Request $request) {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ], [

        ]);

        $hashedPass = Auth::user()->password;
        if(Hash::check($request->old_password, $hashedPass)) {
            if(!Hash::check($request->password, $hashedPass)) {
                $user = User::find(Auth::id());
                $pass = User::where('id', $user->id)->update([
                    'password' => Hash::make($request['password']),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
                if($pass) {
                    Session::flash('success', 'value');
                }
                Auth::logout();
                return redirect()->back();
            }else {
                Session::flash('error', 'New password can not be the same as old one!');
                return redirect()->back();
            }
        }else {
            Session::flash('error', 'An Error Occurred!');
            return redirect()->back();
        }
    }
}
