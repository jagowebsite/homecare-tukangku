<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ComplainController extends Controller
{
    public $log;
    public function __construct(){
        $this->log = new LogController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::get()->pluck('id');
        $complains = Complain::with(['user', 'order'])->whereHas('user', function ($query) use ($users){
            $query->whereIn('id', $users); })->latest()->get();
        $data = [];
        foreach ($complains as $complain) {
            $user = [
                'id' => (int) $complain->user->id,
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
            $data[] = [
                'id' => (int) $complain->id,
                'user' => $user,
                'order_id' => (int) $complain->order_id,
                'description' => $complain->description,
                'status' => $complain->status_complain,
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexMyComplain(Request $request)
    {
        $user_id = @$request->user()->id;
        $complains = Complain::with(['user', 'order'])->where('user_id', $user_id)->latest()->get();
        $data = [];
        foreach ($complains as $complain) {
            $user = [
                'id' => (int) $complain->user->id,
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
            $data[] = [
                'id' => (int) $complain->id,
                'user' => $user,
                'order_id' => (int) $complain->order_id,
                'description' => $complain->description,
                'status' => $complain->status_complain,
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
                201
            );
        }
        DB::beginTransaction();
        $user_id = @$request->user()->id;
        // $user = User::find($user_id);
        $complain = Complain::create([
            'user_id' => $user_id,
            'order_id' => $request->order_id,
            'description' => $request->description,
            'status_complain' => 'pending',
        ]);
        $datalog = [
            'user_id' => $user_id,
            'type' => 'create',
            'description' => "Create New complain [$complain->id] $complain->description", 
        ];
        $this->log->store($datalog);
        DB::commit();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Insert complain succesfully',
            ],
            201
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
        DB::beginTransaction();
        $user_id = @$request->user()->id;
        $complain = Complain::find($id);
        $complain->status_complain = $request->status;
        $complain->verified_at = now();
        $complain->save();
        $datalog = [
            'user_id' => $user_id,
            'type' => 'create',
            'description' => "verify complain [$complain->id] $complain->description", 
        ];
        $this->log->store($datalog);
        DB::commit();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Update status complain succesfully',
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
        //
    }
}
