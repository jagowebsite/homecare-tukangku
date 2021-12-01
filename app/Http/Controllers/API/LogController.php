<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 6;
        $logs = Log::with(['user'])
            ->latest()
            ->paginate($limit);
        $data = [];
        foreach ($logs as $log) {
            $user = [
                'id' => $log->user->id,
                'email' => $log->user->email,
                'name' => $log->user->name,
                'date_of_birth' => $log->user->date_of_birth,
                'address' => $log->user->address,
                'number' => $log->user->number,
                'images' => $log->user->images
                    ? asset('storage/' . $log->user->images)
                    : url('/') . '/assets/icon/user_default.png',
                'ktp_image' => $log->user->ktp_image
                    ? asset('storage/' . $log->user->ktp_image)
                    : '',
            ];
            $date = date_format(date_create($log->created_at), 'Y-m-d H:i:s');
            $data[] = [
                'id' => $log->id,
                'user' => @$user,
                'type' => $log->type,
                'description' => $log->description,
                'created_at' => $date,
            ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data logs success.',
                'data' => @$data,
            ],
            200
        );
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
    public function store($data)
    {
        $log = Log::create([
            'user_id' => $data['user_id'],
            'type' => $data['type'],
            'description' => $data['description'],
        ]);
        return $log;
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
