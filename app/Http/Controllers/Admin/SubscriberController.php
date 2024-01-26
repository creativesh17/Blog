<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SubscriberController extends Controller {
    public function index() {
        $subscribers = Subscriber::where('subscriber_status', 1)->orderBy('subscriber_id', 'DESC')->get();
        return view('admin.subscriber', compact('subscribers'));
    }

    public function unpublish($id) {
        $subscriber = Subscriber::findOrFail($id);

        $del = Subscriber::where('subscriber_status', 1)->where('subscriber_id', $id)->update([
            'subscriber_status' => 0,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        if($del) {
            Session::flash('success', 'value');
            return redirect()->back();
        }else {
            Session::flash('error', 'value');
            return redirect()->back();
        }
    }
}
