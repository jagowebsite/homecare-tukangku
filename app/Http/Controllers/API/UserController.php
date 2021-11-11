<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 6;
        $notation = $request->is_consumen ? '<>' : '=';
        $users = User::with(['roles'])
            ->whereHas('roles', function ($query) use ($notation) {
                $query->where('name', $notation, 'user');
            })
            ->paginate($limit);
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'date_of_birth' => $user->date_of_birth,
                'address' => $user->address,
                'number' => $user->number,
                'images' => $user->images
                    ? asset('storage/' . $user->images)
                    : url('/') . '/assets/icon/user_default.png',
                'ktp_image' => $user->ktp_image
                    ? asset('storage/' . $user->ktp_image)
                    : '',
            ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get user data success.',
                'data' => @$data,
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
                'email' => 'required|email|unique:users',
                'name' => 'required',
                'images' => 'image|file|max:8192',
                'ktp_image' => 'image|file|max:8192',
                'date_of_birth' => 'required',
                'number' => 'required',
                'password' => 'required|confirmed',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
                'image' =>
                    'File upload must be an image (jpg, jpeg, png, bmp, gif, svg, or webp).',
                'max' =>
                    'Maximum file size to upload is 8MB (8192 KB). If you are uploading a photo, try to reduce its resolution to make it under 8MB',
                'confirmed' => 'The password confirmation does not match',
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
        DB::beginTransaction();
        if ($request->file('images')) {
            $images = @$request->file('images')->store('user_image');
        }
        if ($request->file('ktp_image')) {
            $ktp_image = @$request->file('ktp_image')->store('user_image');
        }
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'number' => $request->number,
            'address' => $request->address,
            'images' => @$images,
            'ktp_image' => @$ktp_image,
        ]);
        $role = Role::find($request->user_role_id);
        $user->assignRole($role->name);
        DB::commit();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Create user data success.',
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
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|unique:users',
                'name' => 'required',
                'images' => 'image|file|max:8192',
                'ktp_image' => 'image|file|max:8192',
                'date_of_birth' => 'required',
                'number' => 'required',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
                'image' =>
                    'File upload must be an image (jpg, jpeg, png, bmp, gif, svg, or webp).',
                'max' =>
                    'Maximum file size to upload is 8MB (8192 KB). If you are uploading a photo, try to reduce its resolution to make it under 8MB',
                'confirmed' => 'The password confirmation does not match',
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
        DB::beginTransaction();
        $user = User::find($id);
        if ($request->file('images')) {
            Storage::delete(@$user->images);
            $user_image = @$request->file('images')->store('user_image');
            $user->images = $user_image;
        }
        if ($request->file('ktp_image')) {
            Storage::delete(@$user->ktp_image);
            $user_ktp = @$request->file('ktp_image')->store('user_image');
            $user->ktp_image = $user_ktp;
        }
        $user->email = $request->email;
        $user->name = $request->user_name;
        $user->date_of_birth = $request->date_of_birth;
        $user->number = $request->number;
        $user->address = $request->address;
        $user->save();
        $role = Role::find($request->user_role_id);
        if ($user && $role) {
            $user->syncRoles($role);
        }
        DB::commit();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Update user data success.',
            ],
            201
        );
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required|string|confirmed',
                'password_confirmation' => 'required',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'confirmed' => 'The password confirmation does not match',
                'email' => 'Email is not valid.',
                'unique' => 'Email has been registered.',
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
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Change password user data success.',
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
        User::destroy($id);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Delete user data success.',
            ],
            201
        );
    }
}
