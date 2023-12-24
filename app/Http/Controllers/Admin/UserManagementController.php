<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\userCreateRequest;
use App\Http\Requests\Admin\userUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::orderby('created_at','desc')->get();
            return DataTables::of($data)
                ->addColumn('status', function ($row) {
                    return $row->status ? '<span class="btn btn-success" id="status" data-user-id="'.$row->id.'" >Active</span>' : '<span class="btn btn-danger" id="status" data-user-id="'.$row->id.'">Inactive</span>';
                })
                ->addColumn('action', function ($user) {
                    // Edit icon with URL
                    $editIcon = '<a href="' . route('users.edit', $user->id) . '"><i class="fas fa-edit"></i></a>';
                    
                    // Delete icon with URL and confirmation
                    $deleteIcon = '<a href="#" class="delete-icon" data-toggle="modal" data-target="#confirmDeleteModal" data-user-id="' . $user->id . '"><i class="fas fa-trash-alt"></i></a>';
        
                    // Return icons
                    return $editIcon . ' | ' . $deleteIcon;
                })
                ->addColumn('bulk_opt', function($row){
           
                    $btn = '<input type="checkbox" id="bulk_opt_'.$row->id.'" name="bulk_opt" value='.$row->id. ' class="bulkOption">';
             
                     return $btn;
                })
                ->addIndexColumn() // Add this line to include 'DT_RowIndex'
                ->rawColumns(['status', 'action','bulk_opt'])
                ->make(true);
        }
        return view('admin.user-management.userList');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user-management.userCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(userCreateRequest $request)
    {
        // return $request->all();
        // return $request->has('status');

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->has('status'),
            'password' => Hash::make('123')
        ]);

        return redirect()->route('users.index')->with('success',"User has been Added Successfully!!!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('admin.user-management.userEdit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(userUpdateRequest $request, string $id)
    {
        $user = User::find($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status
        ]);

        return redirect()->route('users.index')->with('success','User detail has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully.'],200);
    }

    public function statusChange($id){

        $user = User::find($id);
        $currentStatus = $user->status;

        if(!$user){
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->update([
            'status' => $currentStatus ? 0:1
        ]);
        return response()->json(['message' => 'User status modified successfully.'],200);
    }

    public function bulkDelete(){

        if(isset($_POST['checkedVals'])){
            $ids = $_POST['checkedVals'];
        }else{
            $ids = [];
        }

        if(empty($ids)){
            return response()->json(['message' => 'No user selected'], 200);
        }

        foreach($ids as $id){
            $user = User::find($id);
            $user->delete();
        }
        return response()->json(['message' => 'selected users are deleted successfully']);
    }

    public function bulkActive(){

        if(isset($_POST['ids'])){
            $ids = $_POST['ids'];
        }else{
            $ids = [];
        }

        if(empty($ids)){
            return response()->json(['message' => 'No user selected'], 200);
        }

        foreach($ids as $id){
            $user = User::find($id);
            $user->update([
                'status' => 1
            ]);
        }
        return response()->json(['message' => 'selected users status updated successfully'], 200);
    }

    public function bulkInactive(){

        if(isset($_POST['ids'])){
            $ids = $_POST['ids'];
        }else{
            $ids = [];
        }

        if(empty($ids)){
            return response()->json(['message' => 'No user selected'], 200);
        }

        foreach($ids as $id){
            $user = User::find($id);
            $user->update([
                'status' => 0
            ]);
        }
        return response()->json(['message' => 'selected users status updated successfully'], 200);
    }
}
