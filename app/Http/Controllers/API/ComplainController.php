<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $complains = Complain::with(['user', 'order'])->get();
        $data = [];
        foreach ($complains as $complain) {
            $user = [
                'id' => $complain->user->id,
                'email' => $complain->user->email,
                'name' => $complain->user->name,
                'date_of_birth' => $complain->user->date_of_birth,
                'address' => $complain->user->address,
                'number' => $complain->user->number,
                'images' => $complain->user->images
                    ? asset('storage/' . $complain->user->images)
                    : url('/') . '/assets/icon/user_default.png',
                'ktp_image' => $complain->user->ktp_image
                    ? asset('storage/' . $complain->user->ktp_image)
                    : '',
            ];
            $data = [
                'id' => $complain->id,
                'user' => $user,
                'order_id' => $complain->order_id,
                'description' => $complain->description,
                'status' => $complain->status,
            ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data complain success.',
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
        $validator = Validator::make(
            $request->all(),
            [
                'order_id' => 'required',
                'description' => 'required',
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
        $user_id = @$request->user()->id;
        // $user = User::find($user_id);
        Complain::create([
            'user_id' => $user_id,
            'order_id' => $request->order_id,
            'description' => $request->description,
            'status_complain' => 'pending',
        ]);
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Insert complain succesfully',
            ],
            200
        );
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $complain = Complain::find($id);
        $complain->status_complain = $request->status;
        $complain->verified_at = now();
        $complain->save();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Update status complain succesfully',
            ],
            200
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
        //
    }
}
