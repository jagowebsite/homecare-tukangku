<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::get()->pluck('id');
        $logs = Log::with(['user'])->whereHas('user', function ($query) use ($users){
            $query->whereIn('id', $users); })->latest();
        // dd($logs);
        if ($request->ajax()) {
            return DataTables::eloquent($logs)
                ->addIndexColumn()
                // ->addColumn('serviceCategory', function (Log $service) {
                //     return $service->serviceCategory->name;
                // })
                ->addColumn('action', function (Log $log) {
                    $action =
                        '  <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="" type="button" class="btn btn-secondary btn-delete-log" data-log_id="' .
                        $log->id .
                        '"><i class="fa fa-trash"></i></a>
                    </div>
               ';
                    return $action;
                })
                ->rawColumns(['action'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.user_management.user_logs.index');
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
