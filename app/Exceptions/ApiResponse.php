<?php

namespace App\Exceptions;

use Exception;

class ApiResponse extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {

        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, $exception)
    {
        return response()->json([
            'code' => $exception->code,
            'type' => '',
            'message' => $exception->message,
        ], $exception->code);
    }
}
