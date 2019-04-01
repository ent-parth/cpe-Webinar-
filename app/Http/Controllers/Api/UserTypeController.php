<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\APIResponse;
use App\Models\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{

    /**
     * Define the API response
     */
    public function __construct()
    {
        $this->APIResponse = new APIResponse();
    }

    /**
     * Tag List
     * 
     * @param Request $request
     * @return type
     */
    public function index()
    {
        try {
            $userTypeData = UserType::getUserTypeArray();
            // foreach($userTypeData as $key => $value) {
            //     $userType['id'] = $key;
            //     $userType['value'] = $value;
            //     $userTypeList[] = $userType;
            // }
            return $this->APIResponse->respondWithMessageAndPayload([
                            'user_type' => $userTypeData]);
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }
}
