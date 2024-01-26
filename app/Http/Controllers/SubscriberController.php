<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubscriberController extends Controller {
    public function insert(Request $request) {
        $this->validate($request, [
            'email' => 'required|email|unique:subscribers,subscriber_email',
        ], [
            'email.unique' => 'This email has already been taken',
        ]);

        $subscriber = Subscriber::insertGetId([
            'subscriber_email' => $request['email'],
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        if($subscriber) {
            Session::flash('success', 'value');
            return redirect()->back();
        }else {
            Session::flash('error', 'value');
            return redirect()->back();
        }
    }
}
