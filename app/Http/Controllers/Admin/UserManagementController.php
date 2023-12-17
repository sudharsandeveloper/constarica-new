<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\userCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::get();
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

        return redirect()->back()->with('success',"User has been Added Successfully!!!");
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
