<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests;
use Illuminate\html;
use Carbon\Carbon;
use App\Repositories\Companies;
use App\Repositories\Users;
use App\Repositories\SpeakerFollow;
use Response;
use Redirect;
use Mail;
use DateTime;
use DateTimeZone;
use File;


class SpeakerController extends Controller{
	
    /**
     * store follow user wise 
     *
     * @param $request
     * @return response
     */
	public function speakerFollow(Request $request) {
		$user_id = Session::get('mycpa_client_id');
		$speaker_id   = $request->input('speaker_id');
		$checkFollow = SpeakerFollow::select('id')->where('speaker_id','=',$speaker_id)->where('user_id','=',$user_id)->count();
		if($checkFollow == '0') {
			$created_at = Carbon::now();
			$speakerInsert = ['speaker_id'=>$speaker_id,
							'user_id'=>$user_id,
							'created_at'=>$created_at
						  ];
			$followInser = SpeakerFollow::create($speakerInsert);
			return Response::json(['msg' => 'follow'], 200);
		} else {
			SpeakerFollow::where('speaker_id','=',$speaker_id)->where('user_id','=',$user_id)->delete();
			return Response::json(['msg' => 'unfollow'], 200);
		}
    }
}
