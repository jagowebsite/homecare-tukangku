<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public $log;
    public function __construct(){
        $this->log = new LogController();
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::with(['serviceCategory'])->latest();
        // dd($employees);
        if ($request->ajax()) {
            return DataTables::eloquent($employees)
                ->addIndexColumn()
                ->addColumn('serviceCategory', function (Employee $employee) {
                    return $employee->serviceCategory->name;
                })
                ->addColumn('images', function (Employee $employee) {
                    $img_url = $employee->images
                        ? asset('storage/' . $employee->images)
                        : 'https://picsum.photos/64';

                    $image =
                        '<img src="' .
                        $img_url .
                        '" class="wd-50 rounded" alt="">';
                    // $image =
                    //     '<img src="https://picsum.photos/64" class="wd-100 rounded" alt="">';
                    return $image;
                })
                ->addColumn('action', function (Employee $employee) {
                    $action =
                        '  <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="' .
                        route('employees_edit', [$employee->id]) .
                        '"
                            class="btn btn-secondary active"><i class="fa fa-edit"></i></a>
                        <a href="" type="button" class="btn btn-secondary btn-delete-employee" data-employee_id="' .
                        $employee->id .
                        '"><i class="fa fa-trash"></i></a>
                    </div>
               ';
                    return $action;
                })
                ->rawColumns(['action', 'serviceCategory', 'images'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.master.employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ServiceCategory::all();
        return view('pages.master.employees.create', compact('categories'));
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
                'service_category_id' => 'required',
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
            // session()->flash('danger', $error);
            Alert::error('Danger', $error);
            return back()->withInput();
        }
        DB::beginTransaction();
        if ($request->file('images')) {
            $images = @$request->file('images')->store('employees');
        }
        $is_ready = @$request->is_ready ?? '0';
        
        $employee=Employee::create([
            'service_category_id' => $request->service_category_id,
            'name' => $request->name,
            'number' => $request->number,
            'address' => $request->address,
            'images' => @$images,
            'is_ready' => @$is_ready,
        ]);
        $datalog = [
            'user_id' => Auth::user()->id??0,
            'type' => 'create',
            'description' => "Create New employee [$employee->id] $employee->name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        // session()->flash('success', 'Employee has been added');
        Alert::success('Success', 'Employee has been added');
        return redirect()->route('employees');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        $categories = ServiceCategory::all();
        return view(
            'pages.master.employees.edit',
            compact('employee', 'categories')
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
        // dd($request);
        $employee = Employee::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'service_category_id' => 'required',
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
            // session()->flash('danger', $error);
            Alert::error('Danger', $error);
            return back()->withInput();
        }
        DB::beginTransaction();
        if ($request->file('images')) {
            Storage::delete(@$employee->images);
            $images = @$request->file('images')->store('employees');
            $employee->images = $images;
        }
        $is_ready = @$request->is_ready ?? '0';
        $employee->service_category_id = $request->service_category_id;
        $employee->name = $request->name;
        $employee->address = $request->address;
        $employee->number = $request->number;
        $employee->is_ready = $is_ready;
        $employee->save();
        $datalog = [
            'user_id' => Auth::user()->id??0,
            'type' => 'put',
            'description' => "Update employee [$id] $employee->name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        // session()->flash('success', 'Employee has been updated');
        Alert::success('Success', 'Employee has been updated');
        return redirect()->route('employees');
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
        DB::beginTransaction();
        $employee=  Employee::find($request->employee_id);
        Employee::destroy($request->employee_id);
        $datalog = [
            'user_id' => Auth::user()->id??0,
            'type' => 'delete',
            'description' => "Delete employee [$employee->id] $employee->name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        // session()->flash('danger', 'Employee  has been deleted');
        Alert::warning('Warning','Employee has been deleted');
        return back();
    }
}
