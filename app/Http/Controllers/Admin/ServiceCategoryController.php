<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = ServiceCategory::query();
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
                ->rawColumns(['action'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.master.service_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        ServiceCategory::destroy($request->category_id);
        session()->flash('danger', 'Service Category has been deleted');
        return back();
    }
}