<?php

namespace App\Utils;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

trait FormaterTrait
{
    private function toJsonResponse($code, $payload, $message = null, $errorMsg = null)
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

    private function toIso8601String(String $ymdhis)
    {
        return Carbon::createFromFormat('YmdHis', $ymdhis)->toIso8601String();
    }
}
