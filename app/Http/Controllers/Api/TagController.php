<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\APIResponse;
use App\Helpers\UserTypeHelper;

class TagController extends Controller
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
            $tags = \App\Models\Tag::select('id', 'tag')->active()->get()->toArray();
            return $this->APIResponse->respondWithMessageAndPayload([
                            'tags' => $tags,
                                ]);
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }
}
