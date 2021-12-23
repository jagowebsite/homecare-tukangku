<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = @Auth::user()->id;
        // $user_id = 200;
        $limit = $request->limit ?? 10;
        $user = User::find($user_id);
        $data = [];
        $notifications = $user->notifications()->paginate($limit);
        // dd($notifications);
        return view(
            'pages.setting.notification.index',
            compact('notifications')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function markAsRead()
    {
        foreach (@Auth::user()->notifications as $notification) {
            $notification->markAsRead();
          }
          return json_encode(['success']);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCountUnreadNotification(Request $request)
    {
        $data = @Auth::user()->unreadNotifications->count();
        
        return $data;
    }

    public function getUnreadNotification(Request $request) {
        $data='';
        foreach (@Auth::user()->unreadNotifications as $item) {
         $data .= '<a href="'. route('read_notification', ['id'=>$item->id]).'" class="media-list-link read">
         <div class="media pd-x-20 pd-y-15">
           <img src="'. url('/') .'/assets/img/ic_logo.png" class="wd-40 rounded-circle" alt="">
           <div class="media-body">
             <p class="tx-13 mg-b-0 tx-gray-700"> '. $item->data['msg'] .'</p>
             <span class="tx-12">'.date_format(date_create($item->created_at), 'F d, Y g:ia').'</span>
           </div>
         </div>
       </a>';
        }
        return $data;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = @Auth::user()->notifications->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['action']);
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
