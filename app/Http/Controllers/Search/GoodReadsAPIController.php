<?php


namespace App\Http\Controllers\Search;

use App\Api\GoodReads;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class GoodReadsAPIController  extends Controller
{
    use ApiResponse;

    protected $goodreads;

    public function __construct() {
        /** define controller middleware */
        $this->middleware('auth:api');

        $this->goodreads = new GoodReads();
    }

    /**
     * Display a listing of book from Goodreads api matching query.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!request()->query('search')){
            return $this->apiFail(['message' => "Please provide search param query string e.g. ?search=harry+potter"]);
        }

        $search = $this->urlFormatSearchParam(request()->query('search'));

        return Cache::remember("good-reads.search.{$search}", 1440, function () use($search) {
            return $this->goodreads->search($search);
        });
    }

    public function show($id)
    {
        if(! $id){
            return $this->apiFail(['message' => "Please provide goodread book id"]);
        }

        if(request()->query('isbn') === 'true'){
            return Cache::remember("good-reads.isbn.{$id}", 1440, function () use($id) {
                return $this->goodreads->getBookByIsbn($id);
            });
        }

        return Cache::remember("good-reads.id.{$id}", 1440, function () use($id) {
            return $this->goodreads->getBook($id);
        });
    }


    private function urlFormatSearchParam($search)
    {
        if(!$search){
            return false;
        }
        return str_replace(' ', '+', $search);
    }
}