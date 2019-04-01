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

class ContactUsController extends Controller
{
    /**
     * Show the contact-us page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('user.contact-us.index');

    }
	
	
	/**
     * store data or send email to admin on contact-us page.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return view('user.contact-us.index');

    }
}
