<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettingNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class SettingNumberController extends Controller
{
    public $log;
    public function __construct()
    {
        $this->log = new LogController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $settingnumbers = SettingNumber::query()->latest();
        // dd($AccountPayments);
        if ($request->ajax()) {
            return DataTables::eloquent($settingnumbers)
                ->addIndexColumn()
                ->addColumn('callwhatsapp', function (
                    SettingNumber $settingnumber
                ) {
                    $numawal = str_split($settingnumber->number, 1);
                    if ($numawal[0] == '0') {
                        $numwhatsapp = '62' . substr($settingnumber->number, 1);
                    } else {
                        $numwhatsapp = $settingnumber->number;
                    }
                    $newwhatsapp = str_replace(['-', ' '], '', @$numwhatsapp);
                    $contactagent =
                        ' <a href="https://wa.me/' .
                        $newwhatsapp .
                        '?text=' .
                        $settingnumber->message .
                        '" class="btn btn-outline-success btn-sm rounded-pill px-3">
                        <i class="fab fa-whatsapp"></i>WhatsApp
                        </a>';
                    return $contactagent;
                })
                ->addColumn('action', function (SettingNumber $settingnumber) {
                    $action =
                        '  <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="' .
                        route('setting_number_edit', [$settingnumber->id]) .
                        '"
                            class="btn btn-secondary active"><i class="fa fa-edit"></i></a>
                        <a href="" type="button" class="btn btn-secondary btn-delete-setting_number" data-id="' .
                        $settingnumber->id .
                        '"><i class="fa fa-trash"></i></a>
                    </div>
               ';
                    return $action;
                })
                ->rawColumns(['action', 'callwhatsapp'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.setting.number.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.setting.number.create');
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
                'number' => 'required',
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
            // session()->flash('danger', $error);
            Alert::error('Danger', $error);
            return back()->withInput();
        }
        DB::beginTransaction();

   
        $setting = SettingNumber::create([
            'type' => 'whatsapp',
            'number' => $request->number,
            'message' =>$request->message,
        ]);
        $datalog = [
            'user_id' => Auth::user()->id ?? 0,
            'type' => 'create',
            'description' => "Create number whatsapp [$setting->id] $setting->number",
        ];
        $this->log->store($datalog);
        DB::commit();
        // session()->flash('success', 'Asset Banner has been added');
        Alert::success('Success', 'Number whatsapp has been added');
        return redirect()->route('setting_number');
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
        $account = SettingNumber::find($id);
        return view('pages.setting.number.edit', compact('account'));
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
        $account = SettingNumber::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                'number' => 'required',
                
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
            // session()->flash('danger', $error);
            Alert::error('Danger', $error);
            return back()->withInput();
        }
        DB::beginTransaction();
        
        $account->number = $request->number;
        $account->message = $request->message;
        $account->save();
        $datalog = [
            'user_id' => Auth::user()->id??0,
            'type' => 'put',
            'description' => "Edit Nomor Whatsapp [$account->id] $account->number", 
        ];
        $this->log->store($datalog);
        DB::commit();
        // session()->flash('success', 'Asset Banner has been added');
        Alert::success('Success', 'Whatsapp Number has been updated');
        return redirect()->route('setting_number');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        $account = SettingNumber::find($request->id);
        SettingNumber::destroy($request->id);
        $datalog = [
            'user_id' => Auth::user()->id??0,
            'type' => 'delete',
            'description' => "Delete number whatsapp [$account->id] $account->number", 
        ];
        $this->log->store($datalog);
        DB::commit();
        // session()->flash('danger', 'Asset Banner  has been deleted');
        Alert::warning('Warning','number whatsapp has been deleted');
        return back();
    }
}
