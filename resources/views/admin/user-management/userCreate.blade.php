@extends('admin.layouts.default')
@section('active-user-create','active')
@section('active-user','active')
@section('page-header','User Management')
@section('current-page','Creat user')
@push('style')
    <style>
        .error{
            color: red;
        }
    </style>
@endpush
@section('main-content')
<section class="content">
    <div class="container-fluid">
        @include('admin.layouts.includes.alerts')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@yield('current-page')</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="myForm" action="{{route('users.store')}}" method="POST">
                @csrf
                @method("POST")
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="Name">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email<span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" value="{{ old('email') }}" placeholder="Enter email">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        <label for="username">Username<span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" id="exampleInputPassword1" placeholder="Login username">
                    </div> --}}
                    <div class="form-check">
                        {{-- for old value --}}
                            {{-- <input type="checkbox" name="status" class="form-check-input" id="status" value="1" @checked(old('status')) > --}}
                        {{-- for defalult checked --}}
                            <input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ old('status') || !old('status') ? 'checked' : '' }}>
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
@push('scripts')
<script>
    $(document).ready(function () {
        $('#myForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                },
                email: {
                    required: true,
                    email: true,
                },
            },
            messages: {
                name: {
                    required: 'Please enter name',
                    minlength: 'Name must be at least 3 characters',
                },
                email: {
                    required: 'Please enter email address',
                    email: 'Please enter a valid email address',
                },
            },
            submitHandler: function (form) {
                // If the form is valid, you can submit it here
                console.log('Submit handler executed');
                form.submit();
            }
        });
    });
</script>

@endpush