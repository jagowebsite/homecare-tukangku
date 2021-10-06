<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CostumerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with(['roles'])->whereHas('roles', function ($query) {
            $query->where('name', 'user');
        });
        if ($request->ajax()) {
            return DataTables::eloquent($users)
                ->addIndexColumn()
                ->addColumn('user_date', function (User $user) {
                    $date = date_create($user->created_at);
                    $created_at = date_format($date, 'd-m-Y ');
                    return $created_at;
                })
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
                        route('consumen_users_edit', ['id' => $user->id]) .
                        '"  class="btn btn-secondary active"><i class="fa fa-edit"></i></a>
                <a href=""  type="button" class="btn btn-secondary btn-delete" data-user_id="' .
                        $user->id .
                        '"><i class="fa fa-trash"></i></a>
              </div>';
                    return $action;
                })
                ->rawColumns(['action', 'user_images', 'user_date'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.consumen.users.index');
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
        $user = User::find($id);
        return view('pages.consumen.users.edit', compact('user'));
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
            $user_image = @$request->file('user_image')->store('user_image');
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
        return redirect()->route('consumen_users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::destroy($request->user_id);
        session()->flash('danger', 'User has been deleted');
        return back();
    }
}
