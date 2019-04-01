<?php
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Repositories\Webinar;
use App\Repositories\Courses;
use App\Repositories\Notifications;
use App\Repositories\CourseLevel;
use App\Repositories\PermissionsRole;
use App\Repositories\Tag;
use App\Repositories\UserType;
use App\Repositories\Series;
use Intervention\Image\ImageManagerStatic as Image;

class CommonHelper
{

    /**
     * Replaces the content text with the values
     *
     * @author The Chief
     * @param string $content Content text
     * @param array $valueArr Replacement values array
     * @return string
     */
    public static function replaceEmailContent($content = "", $valueArr = [])
    {
        if ($content != "" && count($valueArr) > 0) {
            foreach ($valueArr as $key => $value) {
                $content = str_replace('{' . $key . '}', $value, $content);
            }

            return $content;
        } else {
            return $content;
        }
    }

    public static function saveImage($path = null, $image = []){
    	$name = Storage::disk(config('constants.IMAGE_PATH.DRIVER'))->put($path, $image);
    	$img = Image::make($image->getRealPath());
    	$destinationPath = storage_path('app/' . $path . 'thumb');
    	if( ! \File::isDirectory($destinationPath) ) {

	        \File::makeDirectory($destinationPath, 755, true);
	    }
        $img->resize(config('constants.IMAGE_THUMB.WIDTH'), config('constants.IMAGE_THUMB.HEIGHT'), function ($constraint) {
		    $constraint->aspectRatio();
		})->save($destinationPath . '/' . $image->hashName());

		return ($name) ? $image->hashName() : false;
    }

    public function deleteImage($fullPath = null)
    {
        $disk = Storage::disk(config('constants.IMAGE_PATH.DRIVER'));

        if ($disk->exists($fullPath)) {
            $disk->delete($fullPath);
        }
        return true;
    }

    /**
     * This function display the status to be set.
     *
     * @param $request
     *
     * @return void
     */
    public static function activeInactiveStatus()
    {
        return $activeInactive = collect([
            '' => 'Select Status',
            config('constants.STATUS.STATUS_ACTIVE') => 'Active',
            config('constants.STATUS.STATUS_INACTIVE') => 'Inactive'
        ]);
    }

    /**
     * This function display the status to be set.
     *
     * @param $request
     *
     * @return void
     */
    public static function activeInactiveStatusChanges()
    {
        return $activeInactive = collect([
            '' => 'Select Status',
            config('constants.STATUS.STATUS_ACTIVE') => 'Active',
            config('constants.STATUS.STATUS_INACTIVE') => 'Inactive'
        ]);
    }

    public static function genderList()
    {
        return $genders = collect([
            '' => 'Select Gender',
            config('constants.GENDER.MALE') => 'Male',
            config('constants.GENDER.FEMALE') => 'Female'
        ]);
    }

    public static function dateFormate($date = null)
    {
        if (!empty($date)) {
            return Carbon::parse($date)->format('d-M-Y | H:i A');
        }
    }
	/**
     * This function display courese name in view file
     *
     * @param $request
     *
     * @return void */
	
	 public static function getCourseLevelName($Course) {  
	
		$CourseName = '';
		if(!empty($Course)){
			$Course = explode(',',$Course);
			$CourseDetails = CourseLevel::select('id','name')->whereIn('id',$Course)->where('status','=','active')->get();
			if(count($CourseDetails)>0){
				foreach($CourseDetails as $CourseDetails){
					$CourseName .= $CourseDetails->name.',';
				}
				$CourseName = trim($CourseName,',');
				
			}
		}	
		return $CourseName;
	}
	
	/**
     * This function display Tag name in view file
     *
     * @param $request
     *
     * @return void */
	
	 public static function getTagName($Tag) {  
	
		$TagName = '';
		if(!empty($Tag)){
			$Tag = explode(',',$Tag);
			$TagDetails = Tag::select('id','tag')->whereIn('id',$Tag)->where('status','=','active')->get();
			if(count($TagDetails)>0){
				foreach($TagDetails as $TagDetails){
					$TagName .= $TagDetails->tag.',';
				}
				$TagName = trim($TagName,',');
			}
		}	
		return $TagName;
	}
	
	
	/**
     * This function display Who should attend name in view file
     *
     * @param $request
     *
     * @return void */
	
	 public static function getWhoShouldAttendName($attendId) {  
		$AttendName = '';
		if(!empty($attendId)){
			$attendId = explode(',',$attendId);
			$attendDatas = UserType::select('id','name')->whereIn('id',$attendId)->where('status','=','active')->get();
			if(count($attendDatas)>0){
				foreach($attendDatas as $attendData){
					$AttendName .= $attendData->name.',';
				}
				$AttendName = trim($AttendName,',');
			}
		}	
		return $AttendName;
	}
	
	
	/**
     * This function display series name in view file
     *
     * @param $seriesId
     *
     * @return void */
	
	 public static function getSeriesName($seriesId) {  
		$seriesName = '';
		if(!empty($seriesId)){
			$seriesId = explode(',',$seriesId);
			$seriesDatas = Series::select('id','name')->whereIn('id',$seriesId)->where('status','=','active')->get();
			if(count($seriesDatas)>0){
				foreach($seriesDatas as $seriesData){
					$seriesName .= $seriesData->name.',';
				}
				$seriesName = trim($seriesName,',');
			}
		}	
		return $seriesName;
	}
	
	
 /**
     * Encript data
     *
     * @param $date
     * @return string
     */
    public static function encrypt($data){
        return encrypt($data);
   }
   
    /**
     * Decrypt data
     *
     * @param $date
     * @return string
     */

    public static function decrypt($data){

       return decrypt($data);    
    }
	
	/**
     * This function display subject area in view file
     *
     * @param $request
     *
     * @return void */
	
	 public static function getSubjectAreaName($SubjectArea) {  
		$SubjectAreaName = '';
		if(!empty($SubjectArea)){
			$SubjectArea = explode(',',$SubjectArea);
			$SubjectAreaDetails = Courses::select('id','name')->whereIn('id',$SubjectArea)->where('status','=','active')->get();
			if(count($SubjectAreaDetails)>0){
				foreach($SubjectAreaDetails as $SubjectAreaDetails){
					$SubjectAreaName .= $SubjectAreaDetails->name.',';
				}
				$SubjectAreaName = trim($SubjectAreaName,',');
			}
		}	
		return $SubjectAreaName;
	}
	
	/**
     * This function display subject area in view file
     *
     * @param $request
     *
     * @return void */
	
	 public static function getUserName($User) {  
		$UserName = '';
		if(!empty($User)){
			$User = explode(',',$User);
			$UserDetails = UserType::select('id','name')->whereIn('id',$User)->where('status','=','active')->get();
			if(count($UserDetails)>0){
				foreach($UserDetails as $UserDetails){
					$UserName .= $UserDetails->name.',';
				}
				$UserName = trim($UserName,',');
			}
		}	
		return $UserName;
	}
	
	
	/**
     * Conver utc time to input time zone
     *
     * @param $request
     *
     * @return void */
	 public static function convertTime($data,$timezone,$format = NULL) { 
	 	if(!empty($data) && !empty($timezone)){ 
			$displayDate = new DateTime($data);
			$displayDate->setTimezone(new DateTimeZone($timezone));
			if($format=='') {
				$finaldisplay = $displayDate->format('Y-m-d H:i:s');
			} else {
				$finaldisplay = $displayDate->format($format);
			}
			return $finaldisplay;
		} else {
			return false;
		}
	}

	
	/**
     * Conver any time to UTC
     *
     * @param $request
     *
     * @return void */
	 public static function convertUTC($data,$timezone,$format = NULL) { 
	 	if(!empty($data) && !empty($timezone)){ 
			date_default_timezone_set($timezone);
			$user_timestamp = strtotime($data);
			date_default_timezone_set('UTC');
			if($format=='') {
				$utc_time = date("Y-m-d H:i:s", $user_timestamp);
			} else {
				$utc_time = date($format, $user_timestamp);
			}
			return $utc_time;
		} else {
			return false;
		}
	}
	
	
	
	/**
     * Check permission for login user
     *
     * @param $request
     *
     * @return void */
	 public static function checkLoginUserPermission($permission, $user_id) { 
		$getrole = PermissionsRole::Select('permissions.name')
									->leftJoin('permissions','permissions.id','=','permission_role.permissions_id')
									->where('permission_role.user_id',$user_id)
									->where('permissions.name',$permission)
									->get();
		//dd($getrole->count());
		if($getrole->count()>0) {
			return true;
		}else{
			return false;
		}
	 }

	 /**
     * This function display speaker notification in view file
     *
     * @param $speaker_id
     *
     * @return void */
	
	 public static function getSpeakerNotification($speaker_id) {  
	
		$Notification = '';
		if(!empty($speaker_id)){
			
			$NotificationDetail = Notifications::where('is_admin','=','0')->where('read_notification','=','0')->where('user_id','=',$speaker_id)->get();
			
		}	
		return $NotificationDetail;
	}
	/**
     * This function display admin notification in view file
     *
     * @param $speaker_id
     *
     * @return void */
	 public static function getAdminNotification($speaker_id) {  
	
		$Notification = '';
		if(!empty($speaker_id)){
			
			$NotificationDetail = Notifications::where('is_admin','=','1')->where('read_notification','=','0')->where('user_id','=',$speaker_id)->get();
			
		}	
		return $NotificationDetail;
	}
		
	/**
     * This function display update course count in view file
     *
     * @param $id
     *
     * @return void */

	 public static function courseCount($id) {  
		$course_data = Webinar::where('id','=',$id)->first();
	 	$view_count = $course_data->view_count + 1;
		$editArray = ['view_count'=>$view_count];
		$updateData = Webinar::where('id',$id)->update($editArray);
	}
	
}
