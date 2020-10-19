<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Prepare and return the error response.
     *
     * @param string $message
     * @param int $status_code
     *
     * @return JsonResponse
     */
    protected function errorResponse( $message = '', $status_code = 500 ) {

        return response()->json([
            'status'    => 'error',
            'payload'   => [
                'message'   => $message
            ]
        ], $status_code );
    }
}
