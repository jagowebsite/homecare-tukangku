<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.user_management.roles.index');
    }

    /**
     * get a role of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getrole(Request $request)
    {
        $roles = Role::with('permissions');
        return DataTables::eloquent($roles)
            ->addIndexColumn()
            ->addColumn('user_images', function (Role $role) {
                $image = '<img src="https://picsum.photos/64" class="wd-40 rounded-circle" alt="">';
                return $image;
            })
            ->addColumn('action', function (Role $role) {
                $action = '<div class="btn-group" role="group" aria-label="Basic example">
                <button data-toggle="modal" data-target="#editRole" class="btn btn-secondary active"><i class="fa fa-edit"></i></button>
                <button data-toggle="modal" data-target="#AddPermissionToRole" class="btn btn-secondary active"><i class="fa fa-cog"></i></button>
                <a href=""  class="btn btn-secondary"><i class="fa fa-trash"></i></a>
            </div>';
                return $action;
            })
            ->rawColumns(['action', 'user_image'])
            // ->make(true);
            ->toJson();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
