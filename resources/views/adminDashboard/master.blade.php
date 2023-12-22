@include('adminDashboard.header')

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->


            @include('adminDashboard.sidebar')
            @include('adminDashboard.navbar')

            @yield('content')

            @include('adminDashboard.footer')
</body>
