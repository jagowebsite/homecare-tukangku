<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a user management of a resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::query();
        if ($request->ajax()) {
            return DataTables::eloquent($users)
                ->addIndexColumn()
                ->addColumn('user_images', function (User $user) {
                    $img_url = $user->images
                        ? asset('storage/' . $user->images)
                        : 'https://picsum.photos/64';
                    $image =
                        '<img src="' .
                        $img_url .
                        '" class="wd-40 rounded-circle" alt="">';
                    return $image;
                })
                ->addColumn('action', function (User $user) {
                    $action =
                        '<div class="btn-group" role="group" aria-label="Basic example">
                <a href="' .
                        route('users_edit', ['id' => $user->id]) .
                        '"  class="btn btn-secondary active"><i class="fa fa-edit"></i></a>
                <a href=""  type="button" class="btn btn-secondary" data-id="' .
                        $user->id .
                        '"><i class="fa fa-trash"></i></a>
              </div>';
                    return $action;
                })
                ->rawColumns(['action', 'user_images'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.user_management.user_data.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.user_management.user_data.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = Auth::user();
        if ($admin->can('user_management_access')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'user_name' => 'required',
                    'user_image' => 'image|file|max:8192',
                    'user_ktp' => 'image|file|max:8192',
                    'date_of_birth' => 'required',
                    'user_number' => 'required',
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
                session()->flash('danger', $error);
                return back()->withInput();
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('pages.user_management.user_data.edit', compact('user'));
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
        $admin = Auth::user();
        if ($admin->can('user_management_access')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'user_name' => 'required',
                    'user_image' => 'image|file|max:8192',
                    'user_ktp' => 'image|file|max:8192',
                    'date_of_birth' => 'required',
                    'user_number' => 'required',
                ],
                $messages = [
                    'required' => 'The :attribute field is required.',
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
                session()->flash('danger', $error);
                return back()->withInput();
            }

            $user = User::find($id);
            if ($request->file('user_image')) {
                Storage::delete(@$user->images);
                $user_image = @$request
                    ->file('user_image')
                    ->store('user_image');
                $user->images = $user_image;
            }
            if ($request->file('user_ktp')) {
                Storage::delete(@$user->ktp_image);
                $user_ktp = @$request->file('user_ktp')->store('user_image');
                $user->ktp_image = $user_ktp;
            }
            $user->email = $request->email;
            $user->name = $request->user_name;
            $user->date_of_birth = $request->date_of_birth;
            $user->number = $request->user_number;
            $user->save();

            session()->flash('success', 'Data berhasil diupdate');
            return redirect()->route('users');
        }
        // return view('pages.index');
        abort(403);
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
