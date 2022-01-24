<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SettingNumber;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 6;
        $accounts = SettingNumber::latest()->paginate($limit);
        $data = [];
        foreach ($accounts as $account) {
            $numawal = str_split($account->number, 1);
            if ($numawal[0] == '0') {
                $numwhatsapp = '62' . substr($account->number, 1);
            } else {
                $numwhatsapp = $account->number;
            }
            $newwhatsapp = str_replace(['-', ' '], '', @$numwhatsapp);
            $link = 'https://wa.me/' .$newwhatsapp .'?text=' .$account->message;
            $data[] = [
                'id' => $account->id,
                'number' => $newwhatsapp,
                'message' => $account->message,
                'link' => $link,
            ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data whatsapp number success.',
                'data' => $data,
            ],
            200
        );
    }
    public function getWhatsapp(Request $request)
    {
        $account = SettingNumber::latest()->first();
        $data = '';
      
            $numawal = str_split($account->number, 1);
            if ($numawal[0] == '0') {
                $numwhatsapp = '62' . substr($account->number, 1);
            } else {
                $numwhatsapp = $account->number;
            }
            $newwhatsapp = str_replace(['-', ' '], '', @$numwhatsapp);
            $link = 'https://wa.me/' .$newwhatsapp .'?text=' .$account->message;
            $data= [
                'id' => $account->id,
                'number' => $newwhatsapp,
                'message' => $account->message,
                'link' => $link,
            ];
   
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data whatsapp number success.',
                'data' => $data,
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
