<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class ServiceCategoryController extends Controller
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
        $categories = ServiceCategory::query()->latest();
        if ($request->ajax()) {
            return DataTables::eloquent($categories)
                ->addIndexColumn()
                ->addColumn('action', function (ServiceCategory $category) {
                    $action =
                        ' <button data-toggle="modal" data-target="#editCategory" data-url="' .
                        route('categories_update', ['id' => $category->id]) .
                        '" data-name="' .
                        $category->name .
                        '"
                    class="btn btn-secondary active btn-edit-category"><i class="fa fa-edit"></i></button>
                <a href="" type="button" class="btn btn-secondary btn-delete-category" data-category_id="' .
                        $category->id .
                        '"><i class="fa fa-trash"></i></a>';
                    return $action;
                })
                ->addColumn('images', function (ServiceCategory $category) {
                    $images = $category->images
                        ? asset('storage/' . $category->images)
                        : 'https://picsum.photos/64';

                    $image =
                        '<img src="' .
                        $images .
                        '" class="wd-50 rounded" alt="">';
                    // $image =
                    //     '<img src="https://picsum.photos/64" class="wd-100 rounded" alt="">';
                    return $image;
                })
                ->rawColumns(['action', 'images'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.master.service_categories.index');
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
            // session()->flash('danger', $error);
            Alert::error('Danger', $error);
            return back()->withInput();
        }
        if ($request->file('images')) {
            $images = @$request->file('images')->store('category');
        }
        DB::beginTransaction();
        $category =ServiceCategory::create([
            'name' => $request->name,
            'images' => @$images,
        ]);
        $datalog = [
            'user_id' => Auth::user()->id??0,
            'type' => 'create',
            'description' => "Create New service category [$category->id] $category->name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        // session()->flash('success', 'Service Category has been added');
        Alert::success('Success', 'Service Category has been added');
        return back();
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
        DB::beginTransaction();
        $category = ServiceCategory::find($id);
        if ($request->file('images')) {
            Storage::delete(@$category->images);
            $images = @$request->file('images')->store('category');
            $category->images = $images;
        }
        $category->name = $request->name;
        $category->save();
        $datalog = [
            'user_id' => Auth::user()->id??0,
            'type' => 'put',
            'description' => "Update service category [$id] $category->name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        Alert::success('Success', 'Service Category has been updated');
        // session()->flash('success', 'Service Category has been updated');
        return back();
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
        $category=ServiceCategory::find($request->category_id);
        ServiceCategory::destroy($request->category_id);
        $datalog = [
            'user_id' => Auth::user()->id??0,
            'type' => 'delete',
            'description' => "Delete service category [$category->id] $category->name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        // session()->flash('danger', 'Service Category has been deleted');
        Alert::warning('Warning','Service Category has been deleted');
        return back();
    }
}
