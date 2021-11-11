<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 6;
        $roles = Role::with('permissions')->paginate($limit);
        foreach ($roles as $role) {
            $role_permission = [];
            foreach ($role->permissions as $permission) {
                $role_permission[] = $permission->name;
            }
            $data[] = [
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $role->guard_name,
                'permission' => $role_permission,
            ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data role success.',
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
        Role::findOrCreate($request->name, $request->guard_name);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Create role access success.',
            ],
            201
        );
    }
    /**
     * give permission to role
     *
     * @param  Request $request
     * @return void
     */
    public function rolePermission(Request $request, $id)
    {
        $permission = Permission::find($request->role_permission_id);
        $role = Role::find($id);
        if ($permission && $role) {
            $role->givePermissionTo($permission);
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Permission has been added to a role.',
            ],
            201
        );
    }
    /**
     * remove relation permission with role
     *
     * @param  Request $request
     * @return void
     */
    public function revokePermission(Request $request, $id)
    {
        $permission = Permission::find($request->role_permission_id);
        $role = Role::find($id);
        if ($permission && $role) {
            $role->revokePermissionTo($permission);
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Permission has been removed to a role.',
            ],
            201
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
        $role = Role::find($id);
        $role->name = $request->name;
        $role->guard_name = $request->guard_name;
        $role->save();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Update role access success.',
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
    public function destroy($id)
    {
        Role::destroy($id);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Delete role access success.',
            ],
            201
        );
    }
}
