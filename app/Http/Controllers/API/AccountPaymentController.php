<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AccountPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccountPaymentController extends Controller
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
        $limit = $request->limit ?? 6;
        $accountpayments = AccountPayment::latest()->paginate($limit);
        $data = [];
        foreach ($accountpayments as $account) {
          
            if ($account->is_active == 1) {
                $is_active = 'active';
            } else {
                $is_active = 'nonactive';
            }
            $data[] = [
                'id' => $account->id,
                'account_name' => $account->account_name,
                'account_number' => $account->account_number,
                'bank_name' => $account->bank_name,
                'is_active' => $is_active,
            ];
        }
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Get data account payment success.',
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
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                201
            );
        }
        DB::beginTransaction();
        if (strtolower($request->is_active) == 'active') {
            $is_active = 1;
        } else {
            $is_active = 0;
        }
        // $is_active = @$request->is_active ?? '0';
        $payment_account = AccountPayment::create([
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'bank_name' => strtoupper($request->bank_name),
            'is_active' => $is_active,
            
        ]);
        $user_id = $request->user()->id??0;
        $datalog = [
            'user_id' => $user_id,
            'type' => 'create',
            'description' => "Create New Payment Account [$payment_account->id] $payment_account->account_name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Account Payment has been added',
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
        $account = AccountPayment::find($id);
        if ($account->is_active == 1) {
            $is_active = 'active';
        } else {
            $is_active = 'nonactive';
        }
        $data = [
            'id' => $account->id,
            'account_name' => $account->account_name,
            'account_number' => $account->account_number,
            'bank_name' => $account->bank_name,
            'is_active' => $is_active,
        ];
    
    return response()->json(
        [
            'status' => 'success',
            'message' => 'Get data account payment success.',
            'data' => @$data,
        ],
        200
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
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => $error,
                ],
                201
            );
        }
        DB::beginTransaction();
        if (strtolower($request->is_active) == 'active') {
            $is_active = 1;
        } else {
            $is_active = 0;
        }
        // $is_active = @$request->is_active ?? '0';
        $account->account_name = $request->account_name;
        $account->account_number = $request->account_number;
        $account->bank_name = strtoupper($request->bank_name);
        $account->is_active = $is_active;
        $account->save();
        $user_id = $request->user()->id??0;
        $datalog = [
            'user_id' => $user_id,
            'type' => 'put',
            'description' => "Create New Payment Account [$account->id] $account->account_name", 
        ];
        $this->log->store($datalog);
        DB::commit();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        $account = AccountPayment::find($id);
        AccountPayment::destroy($id);
        $datalog = [
            'user_id' => $request->user()->id??0,
            'type' => 'delete',
            'description' => "Delete account payment [$account->id] $account->account_name", 
        ];
        $this->log->store($datalog);
        DB::commit();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Delete Account Payment succesfully',
            ],
            201
        );
    }
}
