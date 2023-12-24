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
                    <th><input type="checkbox" class="mr-3" name="checkAll" id="checkAll"><span>Select</span></th>
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
        <section>
            <button class="btn btn-danger" id="bulk-delete"><i class="fas fa-trash-alt mr-2"></i>Delete</button>
            <button class="btn btn-success" id="bulk-active"><i class="fa fa-toggle-on mr-2"></i>Active</button>
            <button class="btn btn-secondary" id="bulk-inactive"><i class="fa fa-toggle-off mr-2"></i>In-active</button>
        </section>
    </div>
    <!-- /.card-body -->
</div>

<!-- Confirm Delete Modal -->
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
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
                { data: 'bulk_opt', name: 'bulk_opt', orderable: false, searchable: false },
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        
        $(document).ready(function () {

            // delete function

                // Store the user ID in a variable when the delete button is clicked
                
                $('#users tbody').on('click', '.delete-icon', function () {
                    userId = $(this).data('user-id');
                    // console.log(userId)
                })

                // Handle delete confirmation
                $('#confirmDeleteButton').click(function () {
                    $('#confirmDeleteModal').modal('hide');
                    // Send Ajax request to delete the user
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('users.destroy', '') }}/' + userId,
                        data: { "_token": "{{ csrf_token() }}" },
                        success: function (data) {
                            
                            // $('#users').DataTable().draw();

                            // Reload the DataTable
                            $('#users').DataTable().ajax.reload();
                        },
                        error: function (data) {
                            console.error('Error:', data);
                        }
                    });
                });

            // status update

                $('#users tbody').on('click', '#status', function () {
                    let userId = $(this).data('user-id');
                    // console.log(userId);

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('users.change-status', '') }}/' +userId,
                        data: { "_token": "{{ csrf_token() }}" },
                        success: function(data){
                            $('#users').DataTable().ajax.reload();
                        },
                        error: function(data){
                            console.log('Erroe:', data);
                        }
                    })
                })

            // select all

                $('#checkAll').click(function(){

                    if($(this).prop("checked")) {
                        $(".bulkOption").prop("checked", true);
                    } else {
                        $(".bulkOption").prop("checked", false);
                    }       

                })

            // bulk delete

                $('#bulk-delete').click(function(){
                    var checkedVals = $('.bulkOption:checked').map(function () {
                        return this.value
                    }).get();
                    // console.log(checkedVals);

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('users.bulk-delete') }}',
                        data: { 
                            '_token': '{{ csrf_token() }}', 
                            'checkedVals': checkedVals
                        },
                        success: function(data){
                            $('#users').DataTable().ajax.reload();
                            $('#checkAll').prop('checked',false);
                        },
                        error: function(data){
                            console.log('Error:', data);
                        }
                    })
                })

            // bulk active
                $('#bulk-active').click(function(){
                    var ids = [];
                    $('.bulkOption:checkbox:checked').each(function(i){
                        ids[i] = $(this).val();
                    });
                    // console.log(ids)

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('users.bulk-active') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'ids': ids
                        },
                        success: function(data){
                            $('#users').DataTable().ajax.reload();
                            $('#checkAll').prop('checked',false);
                        },
                        error: function(data){ 
                            console.log('Error:' , data);
                        }
                    })
                })

            // bulk in-active
                
                $('#bulk-inactive').click(function(){
                    let ids = [];
                    $('.bulkOption:checked').each(function(i){
                        ids[i] = $(this).val();
                    })
                    // console.log(ids);

                    $.ajax({
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'ids': ids
                        },
                        url: '{{ route('users.bulk-inactive') }}',
                        success: function(data){
                            $('#users').DataTable().ajax.reload();
                            $('#checkAll').prop('checked',false);
                        },
                        error: function(data){
                            console.log('Error:', data);
                        }
                    })
                })

        });
    });
  </script>
@endpush