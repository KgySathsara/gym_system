<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function success($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error($message = 'Error', $code = 400, $errors = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

    protected function notFound($message = 'Resource not found')
    {
        return $this->error($message, 404);
    }

    protected function unauthorized($message = 'Unauthorized')
    {
        return $this->error($message, 401);
    }
}
