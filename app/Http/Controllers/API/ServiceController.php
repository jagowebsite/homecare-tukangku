<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $user_id = $request->user()->id ?? '';
        $limit = $request->limit ?? 6;
        $services = Service::with(['serviceCategory']);
        if ($request->q) {
            $services->where('name', 'like', '%' . $request->q . '%');
        }
        $services->latest();
        $services = $services->paginate($limit);
        $data = [];
        foreach ($services as $service) {
            $images = [];
            if ($service->status_service == '1') {
                $status = 'active';
            } else {
                $status = 'nonactive';
            }
            if (@count(@json_decode($service->images, true))) {
                foreach (@json_decode($service->images, true) as $image) {
                    $images[] = asset('storage/' . $image);
                }
            } else {
                $images[] = 'https://picsum.photos/64';
            }
            $data[] = [
                'id' => $service->id,
                'name' => $service->name,
                'category' => [
                    'id' => @$service->service_category_id,
                    'name' => @$service->servicecategory->name,
                ],
                'type_quantity' => $service->type_quantity,
                'price' => $service->price,
                'images' => $images,
                'description' => $service->description,
                'status' => $status,
            ];
        }

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data services success.',
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
                'category_id' => 'required',
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
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                200
            );
        }
        $pathimage = [];
        if ($request->hasFile('images')) {
            $fileimages = $request->file('images');
            foreach ($fileimages as $image) {
                $pathimage[] = $image->store('services');
            }
        }
        $images = json_encode($pathimage, true);
        if (strtolower($request->status) == 'active') {
            $status = '1';
        } else {
            $status = '0';
        }
        Service::create([
            'service_category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'type_quantity' => $request->type_quantity,
            'description' => $request->description,
            'status_service' => $status,
            'images' => $images,
        ]);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Insert service succesfully',
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
        $service = Service::with(['serviceCategory'])->find($id);
        $images = [];
        if ($service->status_service == '1') {
            $status = 'active';
        } else {
            $status = 'nonactive';
        }
        if (@count(@json_decode($service->images, true))) {
            foreach (@json_decode($service->images, true) as $image) {
                $images[] = asset('storage/' . $image);
            }
        } else {
            $images[] = ' https://picsum.photos/64';
        }
        $data = [
            'id' => $service->id,
            'name' => $service->name,
            'category' => [
                'id' => @$service->service_category_id,
                'name' => @$service->servicecategory->name,
            ],
            'type_quantity' => $service->type_quantity,
            'price' => $service->price,
            'images' => $images,
            'description' => $service->description,
            'status' => $status,
        ];

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data service success.',
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
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'category_id' => 'required',
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
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                200
            );
        }
        $service = Service::find($id);
        foreach (json_decode($service->images, true) as $item) {
            Storage::delete(@$item);
        }
        $pathimage = [];
        if ($request->hasFile('images')) {
            $fileimages = $request->file('images');
            foreach ($fileimages as $image) {
                array_push($pathimage, $image->store('services'));
            }
        }
        $images = json_encode($pathimage, true);
        if (strtolower($request->status) == 'active') {
            $status = '1';
        } else {
            $status = '0';
        }
        $service->name = $request->name;
        $service->service_category_id = $request->category_id;
        $service->price = $request->price;
        $service->type_quantity = $request->type_quantity;
        $service->description = $request->description;
        $service->status_service = $status;
        $service->images = $images;
        $service->save();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Updated service succesfully',
            ],
            200
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
        Service::destroy($id);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Delete service succesfully',
            ],
            201
        );
    }
}
