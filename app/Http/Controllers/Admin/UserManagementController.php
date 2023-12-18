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
                    return $row->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($user) {
                    // Edit icon with URL
                    $editIcon = '<a href="' . route('users.edit', $user->id) . '"><i class="fas fa-edit"></i></a>';
                    
                    // Delete icon with URL and confirmation
                    $deleteIcon = '<a href="#" class="delete-icon" data-toggle="modal" data-target="#confirmDeleteModal" data-user-id="' . $user->id . '"><i class="fas fa-trash-alt"></i></a>';
        
                    // Return icons
                    return $editIcon . ' | ' . $deleteIcon;
                })
                ->addIndexColumn() // Add this line to include 'DT_RowIndex'
                ->rawColumns(['status', 'action'])
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
        //
    }
}
