<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;

class ApiController extends Controller
{
    use ApiResponses;
    public function include(string $relationship): bool
    {
        // include query parameter from the URL
        $param = request()->get('include');

        // if not set
        if(!isset($param)) {
            return false;
        }

        // include values in params
        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includeValues);
    }
}
