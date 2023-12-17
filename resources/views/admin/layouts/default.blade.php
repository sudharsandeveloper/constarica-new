<!DOCTYPE html>
<html lang="en">
    @include('admin.layouts.includes.header')
    @stack('style')
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

        <!-- Preloader -->

        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('assets/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div> --}}

        @include('admin.layouts.includes.top-nav')

        @include('admin.layouts.includes.side-nav')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @include('admin.layouts.includes.content-header')

                <!-- Main content -->
                @section('main-content')
                    <h1>Default</h1>
                @show
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            
        @include('admin.layouts.includes.footer')
        @stack('scripts')
    </body>
</html>