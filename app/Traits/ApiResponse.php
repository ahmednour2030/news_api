<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Response;

/**
 * @author Ahmed Mohamed
 */
trait ApiResponse{

    /**
     * [
     *  data =>
     *  status =>
     *  code => 200
     * ]
     * @param null $message
     * @param null $data
     * @param null $errors
     * @param int $status
     * @return Application|ResponseFactory|Response
     */
    public function apiResponse(
        $message = null,
        $data = null,
        $errors = null,
        int $status = 200,
    ): Response|Application|ResponseFactory
    {
        $array = [
            'message' => $message,
            'errors' => $errors,
            'data' => $data
        ];

        return response($array, $status);
    }

    /**
     * This function apiResponseValidation for Validation Request
     * @param $validator
     */
    public function apiResponseValidation($validator)
    {
        $errors = $validator->errors();
        $response = $this->apiResponse('Invalid data send', null, $errors->first(), 422);
        throw new HttpResponseException($response);
    }
}

