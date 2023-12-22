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
                <a id="confirmDeleteButton" class="btn btn-danger" href="javascript:void(0)">Delete</a>
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
    //     $('#users tbody').on('click', '.delete-icon', function () {
    //         var userId = $(this).data('user-id');
    //         $('#confirmDeleteModal').on('click', '#confirmDeleteButton',function(){
    //             $.ajax({
    //                 type: 'DELETE', // Use 'DELETE' instead of 'delete'
    //                 data: { "_token": "{{ csrf_token() }}" },
    //                 url: '{{ route('users.destroy', '') }}/' + userId,
    //                 success: function (data) {
    //                     // Assuming you are using DataTables, redraw the table after successful deletion
    //                     $('#users').DataTable().draw();
    //                 },
    //                 error: function (data) {
    //                     console.log(data);
    //                 }
    //             });
    //         });
    //         console.log(userId);
    //         // The following line is commented out, as it seems unnecessary in the context of an Ajax request
    //         // $('#confirmDeleteButton').attr('href', '{{ route('users.destroy', '') }}/' + userId).attr('method', 'delete');
    //         $('#confirmDeleteModal').modal('show');
    //     });
    // });

    $(document).ready(function () {
        // Show confirmation modal when delete button is clicked
        $('.delete-btn').click(function () {
            var userId = $(this).data('user-id');
            console.log("userId");
            $('#confirmDeleteModal').modal('show');

            // Set data-id attribute of the delete button in the modal
            $('#confirmDeleteButton').data('user-id', userId);
        });

        // Handle delete confirmation
        $('#confirmDeleteButton').click(function () {
            var userId = $(this).data('user-id');

            // Send Ajax request to delete the item
            $.ajax({
                type: 'DELETE',
                url: '{{ route('users.destroy', '') }}/' + userId,
                data: { "_token": "{{ csrf_token() }}" },
                success: function (data) {
                    // Close the modal
                    $('#confirmDeleteModal').modal('hide');
                    
                    // Update the UI or perform any additional actions
                    // (e.g., remove the item from the list)
                },
                error: function (data) {
                    // Handle errors (e.g., display an error message)
                    console.error('Error:', data.responseJSON.message);
                }
            });
        });
    });
});
  </script>
@endpush