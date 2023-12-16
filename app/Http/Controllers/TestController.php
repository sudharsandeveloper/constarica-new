<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload and store in the database
        foreach ($request->file('image') as $image) {
            // Generate a unique name for the image
            $imageName = md5(uniqid(rand(), true)) . '.' . $image->getClientOriginalExtension();

            // Store the original image
            $originalImagePath = 'testing/multiple-image/' . $imageName;
            $thumbnailImagePath = 'testing/multiple-image/thumbnail/' . $imageName;

            // Save the original image
            $image->storeAs('public/' . $originalImagePath);

            // Create a thumbnail
            $thumbnail = Image::make($image->getRealPath())->resize(150, 100);
            Storage::put('public/' . $thumbnailImagePath, (string) $thumbnail->encode());

            Test::create([
                'name' => $request->input('name'),
                'original_image_path' => $originalImagePath,
                'thumbnail_image_path' => $thumbnailImagePath,
            ]);
        }

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Test $test)
    {
        //
    }
}
