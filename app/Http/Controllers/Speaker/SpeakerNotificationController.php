<?php

namespace App\Http\Controllers\Speaker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Speaker;
use App\Models\Company;
use App\Repositories\Notifications;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Response;
use Redirect;

class SpeakerNotificationController extends Controller{

  
      public function speaker_notification(Request $request){

        $id = $request->id;
        $link = $request->link;

              $editArray = [
                        'read_notification'=> '1',
                        'read_at'=>Carbon::now(),
                        // 'modified_by' => Auth::guard('speaker')->user()->id,
                        ];
            $updateData = Notifications::where('id',$id)->update($editArray);

           $notification_count  = Notifications::where('user_id',Auth::guard('speaker')->user()->id)->where('read_notification',0)->count();

          

        
                return Response::json(['link' => $link,'id' => $id,'notification_count'=> $notification_count], 200);
           
    }

    
        
}
