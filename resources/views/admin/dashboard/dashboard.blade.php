@extends('adminDashboard.master')


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


@section('title')
Home Page
@endsection
{{-- @inject('Clients', 'App\Models\Client')
@inject('Supporters', 'App\Models\Supporter') --}}
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper container">

        <!-- Content -->
        @include('adminDashboard.alerts.alerts')
        <div class="container-xxl  container-p-y">

            <div class="row m-auto">

                <div class="d-flex">
                    <div class="col-lg-8 mb-4 ">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-7">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Congratulations {{ Auth::guard('admin')->user()->name }} ! 🎉</h5>
                                        <p class="mb-4">
                                            <span class="fw-bold"></span> welcome to your yellowish system .

                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-5 text-center text-sm-left">
                                    <div class="card-body pb-0 px-0 px-md-4">
                                        <img src="{{ asset('backend/img/illustrations/man-with-laptop-light.png') }}"
                                            height="140" alt="View Badge User"
                                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                            data-app-light-img="illustrations/man-with-laptop-light.png" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                <div class="col-lg-4 col-md-4  ms-4">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="card-title d-flex align-items-start justify-content-center">
                                        <div class="avatar flex-shrink-0 avatarCart">
                                            <i class="menu-icon tf-icons bx bxs-award"></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Orders</span>
                                    <h3 class="card-title mb-2"></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="card-title d-flex align-items-start justify-content-center">
                                        <div class="avatar flex-shrink-0 avatarCart">
                                            <i class="menu-icon tf-icons bx bx-id-card"></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Users</span>
                                    <h3 class="card-title text-nowrap mb-1"></h3>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                </div>

                <script>
                    @if(Session::has('registerd'))
                    toastr.success("{{ session('registerd') }}")
                    @endif
                </script>
    {{-- setting --}}
    <div class="modal fade" id="setting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="card mb-4">
            <h5 class="card-header"> Settings </h5>
            <div class="card-body">
                <div>
                    <form action="{{ url('admin/update-profile') }}" method="POST" >
                        @csrf

                        <div>
                            <input type="text" value="{{ Auth::guard('admin')->user()->name }}" class="form-control" id="defaultFormControlInput" required placeholder="Name" name="name" aria-describedby="defaultFormControlHelp" />
                            <label for="defaultFormControlInput" class="form-label"> Name </label>
                        </div>
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

            </div>
        </div>

<script>
    @if(Session::has('infoupdated'))
            toastr.success("{{ session('infoupdated') }}")
    @endif
</script>





        <!-- / Content -->
@endsection
