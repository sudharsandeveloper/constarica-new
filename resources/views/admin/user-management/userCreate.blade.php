@extends('admin.layouts.default')
@section('active-user-create','active')
@section('active-user','active')
@section('page-header','User Management')
@section('main-content')
<section class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Create user</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('user.store')}}" method="POST">
                @csrf
                @method("POST")
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email<span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        <label for="username">Username<span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" id="exampleInputPassword1" placeholder="Login username">
                    </div> --}}
                    <div class="form-check">
                        <input type="checkbox" name="status" class="form-check-input" id="status" checked>
                        <label class="form-check-label" for="status">Status</label>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>
    
@endsection