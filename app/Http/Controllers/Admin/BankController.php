<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BankController extends Controller
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
        $accountpayments = AccountPayment::query()->latest();
        // dd($AccountPayments);
        if ($request->ajax()) {
            return DataTables::eloquent($accountpayments)
                ->addIndexColumn()
                ->addColumn('active_account', function (AccountPayment $accountpayment) {
                if ($accountpayment->is_active) {
                   $active = 'Active';
                }else{
                    $active = 'NonActive';
                }
                    return $active;
                })
                ->filterColumn('filter_active', function($query, $keyword) {
                    if (strtolower($keyword) == 'active') {
                        $active = 1;
                    }else{
                        $active = 0;
                    }
                    $sql = "is_active";
                    $query->where($sql,$active);
                })
                ->addColumn('action', function (AccountPayment $accountpayment) {
                    $action =
                        '  <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="' .
                        route('account_edit', [$accountpayment->id]) .
                        '"
                            class="btn btn-secondary active"><i class="fa fa-edit"></i></a>
                        <a href="" type="button" class="btn btn-secondary btn-delete-accountpayment" data-rekening_id="' .
                        $accountpayment->id .
                        '"><i class="fa fa-trash"></i></a>
                    </div>
               ';
                    return $action;
                })
                ->rawColumns(['action', 'active_account'])
                // ->make(true);
                ->toJson();
        }
        return view('pages.setting.bank_account.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.setting.bank_account.create');
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
                'account_name' => 'required',
                'account_number' => 'required',
                'bank_name' => 'required',
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
        
        $is_active = @$request->is_active ?? '0';
        $payment_account = AccountPayment::create([
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'bank_name' => strtoupper($request->bank_name),
            'is_active' => $is_active,
            
        ]);
        $datalog = [
            'user_id' => Auth::user()->id??0,
            'type' => 'create',
            'description' => "Create New Payment Account [$payment_account->id] $payment_account->account_name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        // session()->flash('success', 'Asset Banner has been added');
        Alert::success('Success', 'Payment Account has been added');
        return redirect()->route('bank_account');
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
        $account = AccountPayment::find($id);
        return view('pages.setting.bank_account.edit', compact('account'));
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
        $account = AccountPayment::find($id);
        $validator = Validator::make(
            $request->all(),
            [
                'account_name' => 'required',
                'account_number' => 'required',
                'bank_name' => 'required',
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
        
        $is_active = @$request->is_active ?? '0';
        $account->account_name = $request->account_name;
        $account->account_number = $request->account_number;
        $account->bank_name = strtoupper($request->bank_name);
        $account->is_active = $is_active;
        $account->save();
        $datalog = [
            'user_id' => Auth::user()->id??0,
            'type' => 'put',
            'description' => "Create New Payment Account [$account->id] $account->account_name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        // session()->flash('success', 'Asset Banner has been added');
        Alert::success('Success', 'Payment Account has been updated');
        return redirect()->route('bank_account');
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
        $account = AccountPayment::find($request->rekening_id);
        AccountPayment::destroy($request->rekening_id);
        $datalog = [
            'user_id' => Auth::user()->id??0,
            'type' => 'delete',
            'description' => "Delete account payment [$account->id] $account->account_name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        // session()->flash('danger', 'Asset Banner  has been deleted');
        Alert::warning('Warning','Payment Account has been deleted');
        return back();
    }
}
