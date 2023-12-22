<?php

namespace App\Http\Controllers\Web\Admin;

use App\Events\MyEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard(){

        return view('admin.dashboard.dashboard');

    }
}
