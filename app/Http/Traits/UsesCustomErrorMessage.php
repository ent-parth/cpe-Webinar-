<?php

namespace App\Http\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Response\APIResponse;
use Request;
use App\Http\ResponseTransformers\ValidationResponseTransformer;

trait UsesCustomErrorMessage
{

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $apiResponse = new APIResponse();
        $message = (method_exists($this, 'message')) ? $this->container->call([
                    $this,
                    'message'
                ]) : 'The given data was invalid.';
        //print_r($this->response($validator->errors()->getMessages()));exit;
        throw new HttpResponseException($apiResponse->respondValidationError($this->response($validator->errors()->getMessages())));
    }

    public function response($errors)
    {
        $transformed = "";
        foreach ($errors as $field => $message) {
            $transformed = $message[0];
            break;
        }

        return $transformed;
        /*$validationResponseTransformer = new ValidationResponseTransformer();

        return $validationResponseTransformer->response($errors);*/
    }
}
