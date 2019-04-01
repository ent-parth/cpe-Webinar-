<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\APIResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Api\ProfileRequest;
use Symfony\Component\HttpFoundation\Response as ResponseHTTP;
use App\Models\User;

class ProfileController extends Controller
{

    /**
     * Define the API response
     */
    public function __construct()
    {
        $this->APIResponse = new APIResponse();
    }

    /**
     * Edit the profile
     * 
     * @param ProfileRequest $request
     * @return type
     */
    public function editProfile(ProfileRequest $request)
    {
        try {
            if (isset($request->email)) {
                unset($request->email);
            }
            $userProfile = auth('api')->user()->update($request->all());
            $user = auth('api')->user();
            $tags = $request->tags;
            if (empty($tags)) {
                $tags = [];
            }
            $user->tags()->sync($tags);
            if ($userProfile) {
                return $this->APIResponse->respondWithMessage(__('Profile has been updated successfully.'));
            }

            return $this->APIResponse->respondBadRequest(__('Profile has been not updated successfully.'));
        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }

    /**
     * View the login user profile
     * 
     * @return type
     */
    public function viewProfile()
    {
        try {
            if (auth('api')->check()) {
                $user = User::notDeleted()->select('users.id', 'first_name', 'last_name', 'email', 'contact_no', 'firm_name', 'country_id', 'state_id', 'city_id', 'zipcode', 'user_type_id', 'designation', 'ptin_number', 'credit')
                            ->with('tags:tags.id,tag', 'country:id,name', 'state:id,name', 'city:id,name', 'userType:id,name')
                            ->where('id', '=', auth('api')->user()->id)
                            ->first()->toArray();
                /*$user['country'] = \App\Models\Country::getCountryArray();
                if (!empty($user['country_id']) && !empty($user['country'])) {
                    $user['state'] = \App\Models\State::getStateArray($user['country_id']);
                }
                if (!empty($user['state_id']) && !empty($user['state'])) {
                    $user['city'] = \App\Models\City::getCityArray($user['state_id']);
                }*/
                if (!empty($user)) {
                    foreach($user as $key => $row) {
                        $user[$key] = !empty($row) ? $row : "";
                    }
                }
                $user['country'] = !empty($user['country']['name']) ? $user['country']['name'] : "";
                $user['state'] = !empty($user['state']['name']) ? $user['state']['name'] : "";
                $user['city'] = !empty($user['city']['name']) ? $user['city']['name'] : "";
                $user['user_type'] = !empty($user['user_type']['name']) ? $user['user_type']['name'] : "";
                if (!empty($user['tags'])) {
                    foreach ($user['tags'] as $key => $tag) {
                        unset($user['tags'][$key]['pivot']);
                    }
                }
                $user['tags'] = !empty($user['tags']) ? $user['tags'] : [];
                return $this->APIResponse->respondWithMessageAndPayload([
                            'data' => $user,
                                ]);
            }

        } catch (\Exception $e) {
            return $this->APIResponse->handleAndResponseException($e);
        }
    }
}
