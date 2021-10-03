<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = Permission::query();
        return DataTables::eloquent($permissions)
            ->addIndexColumn()
            ->addColumn('action', function (Permission $permission) {
                $action =
                    ' <div class="btn-group" role="group" aria-label="Basic example">
                    <button data-toggle="modal" data-target="#EditPermission"
                        class="btn btn-secondary active btn-edit-permission" data-url="' .
                    route('permissions_update', ['id' => $permission->id]) .
                    '" data-name="' .
                    $permission->name .
                    '" data-guard_name="' .
                    $permission->guard_name .
                    '"><i class="fa fa-edit"></i></button>
                    <a href="" class="btn btn-secondary btn-delete-permission" data-permission_id="' .
                    $permission->id .
                    '" ><i class="fa fa-trash"></i></a>
                </div>';
                return $action;
            })
            ->rawColumns(['action'])
            // ->make(true);
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Permission::findOrCreate($request->name, $request->guard_name);
        session()->flash('success', 'Permission has been created');
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
        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->guard_name = $request->guard_name;
        $permission->save();

        session()->flash('success', 'Permission has been updated');
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
        Permission::destroy($request->permission_id);
        session()->flash('danger', 'Permission has been deleted');
        return back();
    }
}
