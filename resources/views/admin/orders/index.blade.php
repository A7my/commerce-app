<?php

use App\Models\Cart;
use App\Models\Client;
use App\Models\Product;

?>

@extends('adminDashboard.master')

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    @section('title')
        Orders
    @endsection

    @section('content')


    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h3>Orders</h3>
            </div>
            <table class="table table-light" id="member_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>client</th>
                        <th>client address</th>
                        <th>total price</th>
                        <th>status</th>
                        <th>order details</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td> {{ $order->user->name  }}</td>
                            <td> {{ $order->address  }}</td>
                            <td> {{ $order->total_price  }} LE</td>
                            @if($order->status == 'pending')
                                <td style="color:rgb(83, 82, 4)">{{ $order->status }}</td>
                            @endif
                            @if($order->status == 'deliverd')
                                <td style="color:rgb(40, 185, 21)">Delivered</td>
                            @endif
                            @if($order->status == 'not_delivered')
                                <td style="color:rgb(240, 16, 16)">Not Delivered</td>
                            @endif


                            <td>
                                <span data-toggle="modal" data-target="#orderdetails{{ $order->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-0-circle" viewBox="0 0 16 16">
                                        <path d="M7.988 12.158c-1.851 0-2.941-1.57-2.941-3.99V7.84c0-2.408 1.101-3.996 2.965-3.996 1.857 0 2.935 1.57 2.935 3.996v.328c0 2.408-1.101 3.99-2.959 3.99ZM8 4.951c-1.008 0-1.629 1.09-1.629 2.895v.31c0 1.81.627 2.895 1.629 2.895s1.623-1.09 1.623-2.895v-.31c0-1.8-.621-2.895-1.623-2.895Z"/>
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8Z"/>
                                    </svg>
                                </span>
                            </td>
                            <?php
                                $cart = Cart::where('order_id' , $order->id)->get();
                            ?>
                            <div class="modal fade" id="orderdetails{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="card mb-4">
                                    <h5 class="card-header"> Order Details </h5>
                                    <div class="card-body">
                                        @foreach ($cart as $c)
                                        <div>
                                                <div>
                                                    <label for="defaultFormControlInput" class="form-label">Product</label>
                                                    <p style="color:green"><i>{{ Product::find($c->product_id)->name }}</i></p>
                                                </div>
                                                <div>
                                                    <label for="defaultFormControlInput" class="form-label">Product Price</label>
                                                    <p style="color:green"><i>{{ Product::find($c->product_id)->price }}</i></p>
                                                </div>
                                                <div>
                                                    <label for="defaultFormControlInput" class="form-label">Quantity</label>
                                                    <p style="color:green"><i>{{ $c->quantity }}</i></p>
                                                </div>
                                                <div>
                                                    <label for="defaultFormControlInput" class="form-label">Total Price</label>
                                                    <p style="color:green"><i>{{ $c->total_price }} L.E</i></p>
                                                </div>
                                                <div class="divider">
                                                    <div class="divider-text">order details</div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <br>
                                            <br>
                                            <div>
                                                <label for="defaultFormControlInput" class="form-label">Total Price</label>
                                                <p style="color:green"><i>{{ $order->total_price }} L.E</i></p>
                                            </div>
                                    </div>


                                </div>
                            </div>
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
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7">No data</td>
                            </tr>
                    @endforelse
                </tbody>
            </table>
    </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            @if(Session::has('infoupdated'))
                    toastr.success("{{ session('infoupdated') }}")
            @endif
        </script>

    @endsection
