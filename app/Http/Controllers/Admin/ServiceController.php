<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Service::with(['serviceCategory']);
        // dd($services);
        if ($request->ajax()) {
            return DataTables::eloquent($services)
                ->addIndexColumn()
                ->addColumn('serviceCategory', function (Service $service) {
                    return $service->serviceCategory->name;
                })
                ->addColumn('images', function (Service $service) {
                    $images = json_decode($service->images, true);
                    if (count($images)) {
                        $img_url = asset('storage/' . $images[0]);
                    } else {
                        $img_url = 'https://picsum.photos/64';
                    }
                    $image =
                        '<img src="' .
                        $img_url .
                        '" class="wd-50 rounded" alt="">';
                    // $image =
                    //     '<img src="https://picsum.photos/64" class="wd-100 rounded" alt="">';
                    return $image;
                })
                ->addColumn('action', function (Service $service) {
                    $action =
                        '  <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="' .
                        route('services_edit', [$service->id]) .
                        '"
                            class="btn btn-secondary active"><i class="fa fa-edit"></i></a>
                        <a href="" type="button" class="btn btn-secondary btn-delete-service" data-service_id="' .
                        $service->id .
                        '"><i class="fa fa-trash"></i></a>
                    </div>
               ';
                    return $action;
                })
                ->rawColumns(['action', 'serviceCategory', 'images'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.master.services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ServiceCategory::all();
        return view('pages.master.services.create', compact('categories'));
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
                'service_category_id' => 'required',
                'price' => 'required|digits_between:3,10',
                'type_quantity' => 'required',
                'description' => 'required',
                'images.*' => 'image|file|max:8192',
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
        $pathimage = [];
        if ($request->hasFile('images')) {
            $fileimages = $request->file('images');
            foreach ($fileimages as $image) {
                $pathimage[] = $image->store('services');
            }
        }
        $images = json_encode($pathimage, true);
        $status = @$request->status ?? '0';
        Service::create([
            'service_category_id' => $request->service_category_id,
            'name' => $request->name,
            'price' => $request->price,
            'type_quantity' => $request->type_quantity,
            'description' => $request->description,
            'status' => $status,
            'images' => $images,
        ]);
        session()->flash('success', 'Services has been added');
        return redirect()->route('services');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::find($id);
        $categories = ServiceCategory::all();
        return view(
            'pages.master.services.edit',
            compact('service', 'categories')
        );
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getImages($id)
    {
        $service = Service::find($id);
        $data = [];
        foreach (json_decode($service->images, true) as $item) {
            $data[] = [
                'id' => $item,
                'src' => asset('storage/' . $item),
            ];
        }
        return $data;
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
        // dd($request);
        $service = Service::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'service_category_id' => 'required',
                'price' => 'required|digits_between:3,10',
                'type_quantity' => 'required',
                'description' => 'required',
                'images.*' => 'image|file|max:8192',
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

        $pathimage = @$request->imagesold ?? [];
        if (!count($pathimage)) {
            foreach (json_decode($service->images, true) as $item) {
                Storage::delete(@$item);
            }
        }
        foreach (json_decode($service->images, true) as $item) {
            if (!in_array($item, $pathimage)) {
                Storage::delete(@$item);
            }
        }
        if ($request->hasFile('images')) {
            $fileimages = $request->file('images');
            foreach ($fileimages as $image) {
                array_push($pathimage, $image->store('services'));
            }
        }
        $images = json_encode($pathimage, true);

        $status = @$request->status ?? '0';
        $service->name = $request->name;
        $service->service_category_id = $request->service_category_id;
        $service->price = $request->price;
        $service->type_quantity = $request->type_quantity;
        $service->description = $request->description;
        $service->status = $status;
        $service->images = $images;
        $service->save();
        session()->flash('success', 'Services has been updated');
        return redirect()->route('services');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // dd($request);
        Service::destroy($request->service_id);
        session()->flash('danger', 'Service  has been deleted');
        return back();
    }
}
