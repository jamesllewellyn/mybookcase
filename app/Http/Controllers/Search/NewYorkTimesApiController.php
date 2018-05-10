<?php

namespace App\Http\Controllers\Search;

use App\Api\NewYorkTimes;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class NewYorkTimesApiController  extends Controller
{
    use ApiResponse;

    protected $newYorkTimes;

    public function __construct() {
        /** define controller middleware */
        $this->middleware('auth:api');

        $this->newYorkTimes = new NewYorkTimes();
    }

    public function index()
    {
        $bestSellers = Cache::remember('bestSellers', 1440, function () {
            return $this->newYorkTimes->getBestSellers();
        });

        return $this->apiSuccess(['bestSellers' => $bestSellers]);
    }
}