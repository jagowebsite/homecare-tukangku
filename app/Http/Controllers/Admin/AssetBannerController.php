<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AssetBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $assets = AssetBanner::query()->latest();
        // dd($assets);
        if ($request->ajax()) {
            return DataTables::eloquent($assets)
                ->addIndexColumn()
                ->addColumn('images', function (AssetBanner $asset) {
                    $img_url = $asset->images
                        ? asset('storage/' . $asset->images)
                        : 'https://picsum.photos/64';

                    $image =
                        '<img src="' .
                        $img_url .
                        '" class="wd-50 rounded" alt="">';
                    // $image =
                    //     '<img src="https://picsum.photos/64" class="wd-100 rounded" alt="">';
                    return $image;
                })
                ->addColumn('action', function (AssetBanner $asset) {
                    $action =
                        '  <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="' .
                        route('banners_edit', [$asset->id]) .
                        '"
                            class="btn btn-secondary active"><i class="fa fa-edit"></i></a>
                        <a href="" type="button" class="btn btn-secondary btn-delete-asset" data-asset_id="' .
                        $asset->id .
                        '"><i class="fa fa-trash"></i></a>
                    </div>
               ';
                    return $action;
                })
                ->rawColumns(['action', 'images'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.master.banners.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.master.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
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
            session()->flash('danger', $error);
            return back()->withInput();
        }
        if ($request->file('images')) {
            $images = @$request->file('images')->store('asset_banners');
        }
        $is_active = @$request->is_active ?? '0';
        AssetBanner::create([
            'name' => $request->name,
            'url_asset' => $request->url_asset,
            'is_active' => $is_active,
            'images' => $images,
        ]);
        session()->flash('success', 'Asset Banner has been added');
        return redirect()->route('banners');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = AssetBanner::find($id);
        return view('pages.master.banners.edit', compact('asset'));
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
        $asset = AssetBanner::find($id);
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
            session()->flash('danger', $error);
            return back()->withInput();
        }
        if ($request->file('images')) {
            Storage::delete(@$asset->images);
            $images = @$request->file('images')->store('asset_banners');
            $asset->images = $images;
        }
        $is_active = @$request->is_active ?? '0';
        $asset->name = $request->name;
        $asset->url_asset = $request->url_asset;
        $asset->is_active = $is_active;
        $asset->save();
        session()->flash('success', 'Asset Banners has been updated');
        return redirect()->route('banners');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        AssetBanner::destroy($request->asset_id);
        session()->flash('danger', 'Asset Banner  has been deleted');
        return back();
    }
}
