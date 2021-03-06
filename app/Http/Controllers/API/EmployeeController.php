<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public $log;
    public function __construct(){
        $this->log = new LogController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 6;
        $employees = Employee::with(['serviceCategory']);
        if ($request->q) {
            $employees->where('name', 'like', '%' . $request->q . '%');
        }
        $employees->latest();
        $employees = $employees->paginate($limit);
        $data = [];
        foreach ($employees as $employee) {
            $image = $employee->images
                ? asset('storage/' . $employee->images)
                : 'https://picsum.photos/64';
            if ($employee->is_ready == 1) {
                $is_ready = true;
            } else {
                $is_ready = false;
            }
            $data[] = [
                'id' => (int) $employee->id,
                'category_service' => [
                    'id' => (int) @$employee->service_category_id,
                    'name' => @$employee->servicecategory->name,
                ],
                'name' => $employee->name,
                'address' => $employee->address,
                'number' => $employee->number,
                'is_ready' => $is_ready,
                'status' => $employee->status_employee,
                'images' => $image,
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
                'category_service_id' => 'required',
                'number' => 'required',
                'address' => 'required',
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
        DB::beginTransaction();
        if ($request->file('images')) {
            $images = @$request->file('images')->store('employees');
        }
        if ($request->is_ready == true) {
            $is_ready = 1;
        } else {
            $is_ready = 0;
        }
        $employee=Employee::create([
            'service_category_id' => $request->category_service_id,
            'name' => $request->name,
            'address' => $request->address,
            'number' => $request->number,
            'is_ready' => @$is_ready,
            'status_employee' => $request->status,
            'images' => @$images,
        ]);
        $user_id = $request->user()->id??0;
        $datalog = [
            'user_id' => $user_id,
            'type' => 'create',
            'description' => "Create New employee [$employee->id] $employee->name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Insert employee succesfully',
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
        $employee = Employee::with(['serviceCategory'])->find($id);
        $image = $employee->images
            ? asset('storage/' . $employee->images)
            : 'https://picsum.photos/64';
        if ($employee->is_ready == 1) {
            $is_ready = true;
        } else {
            $is_ready = false;
        }
        $data = [
            'id' => (int) $employee->id,
            'category_service' => [
                'id' => (int) @$employee->service_category_id,
                'name' => @$employee->servicecategory->name,
            ],
            'name' => $employee->name,
            'address' => $employee->address,
            'number' => $employee->number,
            'is_ready' => $is_ready,
            'status' => $employee->status_employee,
            'images' => $image,
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
                'category_service_id' => 'required',
                'number' => 'required',
                'address' => 'required',
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
        DB::beginTransaction();
        $employee = Employee::find($id);
        if ($request->file('images')) {
            Storage::delete(@$employee->images);
            $images = @$request->file('images')->store('employees');
            $employee->images = $images;
        }
        if ($request->is_ready == true) {
            $is_ready = 1;
        } else {
            $is_ready = 0;
        }
        $employee->service_category_id = $request->category_service_id;
        $employee->name = $request->name;
        $employee->address = $request->address;
        $employee->number = $request->number;
        $employee->is_ready = $is_ready;
        $employee->status_employee = $request->status;
        $employee->save();
        $user_id = $request->user()->id??0;
        $datalog = [
            'user_id' => $user_id,
            'type' => 'put',
            'description' => "Update employee [$id] $employee->name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Updated employee succesfully',
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
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        $employee=  Employee::find($id);
        Employee::destroy($id);
        $user_id = $request->user()->id??0;
        $datalog = [
            'user_id' => $user_id,
            'type' => 'delete',
            'description' => "Delete employee [$employee->id] $employee->name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Delete employee succesfully',
            ],
            201
        );
    }
}
