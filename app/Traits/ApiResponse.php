<?php

namespace App\Traits;

trait ApiResponse
{
    public function apiSuccess(Array $responseArray) {
            return response()
                ->json(array_merge(
                    ['success' =>true],
                    $responseArray
                ));
    }

    public function apiFail(Array $responseArray) {
        return response()
            ->json(array_merge(
                ['success' =>false],
                $responseArray
            ));
    }

    public function apiUnauthorised(){
        /** todo: make this response nicer */
        return abort(403, 'Unauthorized action');
    }
}