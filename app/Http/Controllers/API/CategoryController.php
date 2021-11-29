<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = ServiceCategory::latest()->get();
        $data = [];
        foreach ($categories as $category) {
            $image = $category->images
                ? asset('storage/' . $category->images)
                : 'https://picsum.photos/64';
            $data[] = [
                'id' => $category->id,
                'name' => $category->name,
                'images' => $image,
            ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data category services success.',
                'data' => $data,
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'images' => 'image|file|max:8192',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
                'digits' => 'your :attribute is to long',
                'image' =>
                    'File upload must be an image (jpg, jpeg, png, bmp, gif, svg, or webp).',
                'max' =>
                    'Maximum file size to upload is 8MB (8192 KB). If you are uploading a photo, try to reduce its resolution to make it under 8MB',
            ]
        );
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                201
            );
        }
        if ($request->file('images')) {
            $images = @$request->file('images')->store('category');
        }

        ServiceCategory::create([
            'name' => $request->name,
            'images' => $images,
        ]);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Insert category service succesfully',
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = ServiceCategory::find($id);
        $image = $category->images
            ? asset('storage/' . $category->images)
            : 'https://picsum.photos/64';

        $data = [
            'id' => $category->id,
            'name' => $category->name,
            'images' => $image,
        ];
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data category service success.',
                'data' => @$data,
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = ServiceCategory::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'images' => 'image|file|max:8192',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
                'digits' => 'your :attribute is to long',
                'image' =>
                    'File upload must be an image (jpg, jpeg, png, bmp, gif, svg, or webp).',
                'max' =>
                    'Maximum file size to upload is 8MB (8192 KB). If you are uploading a photo, try to reduce its resolution to make it under 8MB',
            ]
        );
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                201
            );
        }
        if ($request->file('images')) {
            Storage::delete(@$category->images);
            $images = @$request->file('images')->store('category');
            $category->images = $images;
        }
        $category->name = $request->name;
        $category->save();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Updated category service succesfully',
            ],
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ServiceCategory::destroy($id);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Delete category service succesfully',
            ],
            201
        );
    }
}
