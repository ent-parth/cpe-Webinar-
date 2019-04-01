<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\APIResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseHTTP;

class LocationController extends Controller
{

    /**
     * Define the API response
     */
    public function __construct()
    {
        $this->APIResponse = new APIResponse();
    }

    public function country(Request $request)
    {
        try {
            $country = \App\Models\Country::getCountryArray();

           return $this->APIResponse->respondWithMessageAndPayload([
                        "country" => $country
                    ]);
        } catch (\Exception $e) {
            // echo $e->getMessage();
            // exit;
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Register the customer
     * 
     * @param Request $request
     * @return type
     */
    public function state(Request $request)
    {
        try {
            $state = \App\Models\State::getStateArray($request->country_id);

           return $this->APIResponse->respondWithMessageAndPayload([
               "state" => $state
            ]);
        } catch (\Exception $e) {
            // echo $e->getMessage();
            // exit;
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * Register the customer
     * 
     * @param Request $request
     * @return type
     */
    public function city(Request $request)
    {
        try {
            $city = \App\Models\City::getCityArray($request->state_id);

           return $this->APIResponse->respondWithMessageAndPayload([
                "city" => $city
            ]);
        } catch (\Exception $e) {
            // echo $e->getMessage();
            // exit;
            return $this->APIResponse->handleAndResponseException($e);
        }
    }
}
