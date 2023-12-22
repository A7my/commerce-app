<?php

use App\Models\Cart;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


?>

@extends('adminDashboard.master')

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    @section('title')
        Notifications
    @endsection

    @section('content')

    @forelse ($not as $not)

    @php
        $data = json_decode($not->data);
    @endphp
    <li class="notification-box">
    <div class="row">
        <div class="col-lg-3 col-sm-3 col-3 text-center">
            <!-- <img src="/demo/man-profile.jpg" class="w-50 rounded-circle"> -->
    </div>
    <div class="col-lg-8 col-sm-8 col-8">
        <strong class="text-info">{{$data->user_name}} has created order #{{$data->order_id}}</strong>
    <div>
    <small>{{$data->user_name}}</small>
    <small class="text-warning">{{$not->created_at}}</small>
    </div>
    </div>
    </div>
</li>




@empty
<li>
    <strong class="text-info">NO Notification</strong>
</li>
@endforelse




    
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



            {{-- Update Info  --}}
            <div class="modal fade" id="setting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="card mb-4">
                    <h5 class="card-header"> Settings </h5>
                    <div class="card-body">
                        <div>
                            <form action="{{ url('admin/update-profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div>
                                    <input type="text" value="{{ Auth::guard('admin')->user()->name }}" class="form-control" id="defaultFormControlInput" required placeholder="Name" name="name" aria-describedby="defaultFormControlHelp" />
                                    <label for="defaultFormControlInput" class="form-label"> Name </label>

                                <div>
                                    <input type="email" class="form-control" value="{{ Auth::guard('admin')->user()->email }}" id="defaultFormControlInput" required placeholder="Email" name="email" aria-describedby="defaultFormControlHelp" />
                                    <label for="defaultFormControlInput" class="form-label"> Email </label>
                                </div>

                                <div>
                                    <input type="text" class="form-control" id="defaultFormControlInput" value=""  placeholder="Password" name="password" aria-describedby="defaultFormControlHelp" />
                                    <label for="defaultFormControlInput" class="form-label"> Password </label>
                                </div>


                        

                                <button type="submit" class="btn btn-warning"> update info </button>

                            </form>
                                <div>
                            </div>
                    </div>
                </div>
            </div>

            <script>
            @if(Session::has('infoupdated'))
                    toastr.success("{{ session('infoupdated') }}")
            @endif
        </script>
    @endsection
