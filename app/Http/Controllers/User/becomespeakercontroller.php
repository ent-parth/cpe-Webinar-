<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use App\Repositories\Tag;
use App\Repositories\Users;
use App\Repositories\UserType;
use App\Repositories\TagUser;
use App\Repositories\UserPasswordReset;
use App\Repositories\Cities;
use App\Repositories\Countries;
use App\Repositories\States;
use App\Models\User;
use App\Http\Requests;
use Illuminate\html;
use Carbon\Carbon;
use Response;
use Mail;
use DateTime;
use DateTimeZone;
use File;
use CommonHelper;
use Redirect;
use Hash;
use Illuminate\Support\Facades\URL;

class BecomeSpeakerController extends Controller
{    
        
}
