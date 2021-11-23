<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AssetBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 6;
        $banners = AssetBanner::latest()->paginate($limit);
        $data = [];
        foreach ($banners as $banner) {
            $image = $banner->images
                ? asset('storage/' . $banner->images)
                : 'https://picsum.photos/64';
            if ($banner->is_active == 1) {
                $is_active = true;
            } else {
                $is_active = false;
            }
            $data[] = [
                'id' => $banner->id,
                'name' => $banner->name,
                'images' => $image,
                'url_asset' => $banner->url_asset,
                'is_active' => $is_active,
            ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data asset banners success.',
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
                'images' => 'required|image|file|max:8192',
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
                200
            );
        }
        if ($request->file('images')) {
            $images = @$request->file('images')->store('asset_banners');
        }
        if ($request->is_active == true) {
            $is_active = 1;
        } else {
            $is_active = 0;
        }
        AssetBanner::create([
            'name' => $request->name,
            'url_asset' => $request->url_asset,
            'is_active' => $is_active,
            'images' => $images,
        ]);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Insert banner succesfully',
            ],
            200
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
        $banner = AssetBanner::find($id);
        $image = $banner->images
            ? asset('storage/' . $banner->images)
            : 'https://picsum.photos/64';
        if ($banner->is_active == 1) {
            $is_active = true;
        } else {
            $is_active = false;
        }
        $data = [
            'id' => $banner->id,
            'name' => $banner->name,
            'images' => $image,
            'url_asset' => $banner->url_asset,
            'is_active' => $is_active,
        ];
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data asset banners success.',
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
        $banner = AssetBanner::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'images' => 'required|image|file|max:8192',
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
                200
            );
        }
        if ($request->file('images')) {
            Storage::delete(@$banner->images);
            $images = @$request->file('images')->store('asset_banners');
            $banner->images = $images;
        }
        if ($request->is_active == true) {
            $is_active = 1;
        } else {
            $is_active = 0;
        }
        $banner->name = $request->name;
        $banner->url_asset = $request->url_asset;
        $banner->is_active = $is_active;
        $banner->save();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Updated banner succesfully',
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
        AssetBanner::destroy($id);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Delete asset banner succesfully',
            ],
            201
        );
    }
}
