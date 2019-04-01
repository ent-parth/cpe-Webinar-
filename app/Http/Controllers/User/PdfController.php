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
use DateTime;
use DateTimeZone;
use File;
use PDF;

class PdfController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function generatePDF(){
        $data = ['title' => 'Welcome to mycpa'];
        $pdf = PDF::loadView('user.pdf.myPDF', $data);
        return $pdf->download('mycpa.pdf');
    }
}