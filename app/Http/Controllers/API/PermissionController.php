<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 6;
        $permissions = Permission::paginate($limit);
        $data = [];
        foreach ($permissions as $permission) {
            $data[] = [
                'id' => $permission->id,
                'name' => $permission->name,
                'guard_name' => $permission->guard_name,
            ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data role permissions success.',
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
        Permission::findOrCreate($request->name, $request->guard_name);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Create role permission success.',
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
        if (!$id) {
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'please input id permission',
                ],
                201
            );
        }
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'guard_name' => 'required',
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
        $permission = Permission::find($id);
        if (!$permission) {
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'please check your id',
                ],
                200
            );
        }
        $permission->name = $request->name;
        $permission->guard_name = $request->guard_name;
        $permission->save();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Update role permission success.',
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
        Permission::destroy($id);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Delete role permission success.',
            ],
            201
        );
    }
}
