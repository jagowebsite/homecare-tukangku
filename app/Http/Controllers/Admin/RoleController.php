<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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
        $permissions = Permission::all();
        return view(
            'pages.user_management.roles.index',
            compact('permissions')
        );
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
            ->addColumn('role_permission', function (Role $role) {
                $permission = '<p>';
                foreach ($role->permissions as $value) {
                    $permission .=
                        ' <span class="badge badge-permission">
                    ' .
                        $value->name .
                        '
                    <a class="revoke-permission" href="" data-role_id="' .
                        $role->id .
                        '" data-permission_id="' .
                        $value->id .
                        '"><i class="fa fa-times-circle text-white"></i></a>
                </span>';
                }
                $permission .= '</p>';
                return $permission;
            })
            ->addColumn('action', function (Role $role) {
                $action =
                    '<div class="btn-group" role="group" aria-label="Basic example">
                <button data-toggle="modal" data-target="#editRole" class="btn btn-secondary active btn-edit-role" data-url="' .
                    route('roles_update', ['id' => $role->id]) .
                    '" data-name="' .
                    $role->name .
                    '" data-guard_name="' .
                    $role->guard_name .
                    '"><i class="fa fa-edit"></i></button>
                <button data-toggle="modal" data-target="#AddPermissionToRole" class="btn btn-secondary active btn-roles-permissions" data-url="' .
                    route('roles_permissions', ['id' => $role->id]) .
                    '" data-name="' .
                    $role->name .
                    '"><i class="fa fa-cog"></i></button>
                <a href=""  class="btn btn-secondary btn-delete-role" data-role_id="' .
                    $role->id .
                    '" ><i class="fa fa-trash"></i></a>
            </div>';
                return $action;
            })
            ->rawColumns(['action', 'role_permission'])
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
        Role::findOrCreate($request->name, $request->guard_name);
        session()->flash('success', 'Role Has been created');
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
        // dd($role);
        $role = Role::find($id);
        $role->name = $request->name;
        $role->guard_name = $request->guard_name;
        $role->save();

        session()->flash('success', 'Role Has been updated');
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
        Role::destroy($request->role_id);
        session()->flash('danger', 'Role has been deleted');
        return back();
    }

    /**
     * remove relation permission with role
     *
     * @param  Request $request
     * @return void
     */
    public function revokepermission(Request $request)
    {
        $permission = Permission::find($request->permission_id);
        $role = Role::find($request->role_id);
        if ($permission && $role) {
            $role->revokePermissionTo($permission);
        }
        session()->flash('success', 'Permission has been removed from a role ');
        return back();
    }
    /**
     * give permission to role
     *
     * @param  Request $request
     * @return void
     */
    public function rolepermission(Request $request, $id)
    {
        $permission = Permission::find($request->permission);
        $role = Role::find($id);
        if ($permission && $role) {
            $role->givePermissionTo($permission);
        }
        session()->flash('success', 'Permission has been added to a role');
        return back();
    }
}
