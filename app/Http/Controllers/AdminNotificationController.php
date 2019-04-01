<?php
namespace App\Http\Controllers;

use App\Repositories\Notifications;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Webinar;
use App\Helpers\StatusHelper;
use Response;
use Redirect;

class AdminNotificationController extends Controller{

  
      public function admin_notification(Request $request){

       
        $id = $request->id;
        $link = $request->link;

              $editArray = [
                        'read_notification'=> '1',
                        'read_at'=>Carbon::now(),
                        // 'modified_by' => Auth::guard('speaker')->user()->id,
                        ];
            $updateData = Notifications::where('id',$id)->update($editArray);

           $notification_count  = Notifications::where('user_id',Auth::guard('administrator')->user()->id)->where('read_notification',0)->count();

          

        
                return Response::json(['link' => $link,'id' => $id,'notification_count'=> $notification_count], 200);
           
    }

    
        
}
