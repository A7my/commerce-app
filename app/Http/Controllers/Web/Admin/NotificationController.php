<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){
        DB::table('notifications')
        ->whereNull('read_at')  // Select only rows where read_at is null
        ->update(['read_at' => now()]);

        $not = DB::table('notifications')->get();

        return view('admin.notifications.index' , compact('not'));
    }
}
