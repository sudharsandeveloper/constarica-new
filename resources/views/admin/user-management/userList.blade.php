@extends('admin.layouts.default')
@section('active-user-list','active')
@section('active-user','active')
@section('page-header','User Management')
@section('current-page','User list')
@section('main-content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">@yield('current-page')</h3>
    </div>
    
    @include('admin.layouts.includes.alerts')

    <!-- /.card-header -->
    <div class="card-body">
        <table id="users" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" name="" id="">Select</th>
                    <th>S. No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- Add this code to your HTML file where you define modals -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- The following line will be updated dynamically with JavaScript -->
                <a id="confirmDeleteButton" class="btn btn-danger" href="#">Delete</a>
            </div>
        </div>
    </div>
  </div>
  
@endsection
@push('scripts')
<script>
    $(function () {
        var table = $("#users").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            ajax: "{{ route('users.index') }}",
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false, render: function (data, type, full, meta) {
                    return '<input type="checkbox" class="select-checkbox" value="' + data + '">';
                }},
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Handle delete icon click and open confirmation modal
        $('#users tbody').on('click', '.delete-icon', function () {
            var userId = $(this).data('user-id');
            // Update the modal's delete button href with the dynamic route
            $('#confirmDeleteButton').attr('href', '{{ route('users.destroy', '') }}/' + userId);
            $('#confirmDeleteModal').modal('show');
        });
    });

  </script>
@endpush