<?php

namespace App\Utils;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

trait FormaterTrait
{
    protected function toJsonResponse($code, $payload, $message = null, $errorMsg = null)
    {
        $data = [
            'code' => $code,
            'payload' => $payload
        ];

        if ($message) {
            $data['message'] = $message;
        }

        if ($errorMsg) {
            $data['error'] = [ 'message' => $errorMsg ];
        }

        return response()->json($data, $code);
    }
}
