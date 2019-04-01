<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests;
use Illuminate\html;
use Carbon\Carbon;
use Response;
use Mail;
use File;

class FaqController extends Controller{
    /**
     * Show the FAQ page.
     *
     * @return \Illuminate\Http\Response
     */
    
	public function index(Request $request){
        return view('user.faq.index');
    }
}
