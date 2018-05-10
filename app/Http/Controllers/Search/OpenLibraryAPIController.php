<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Books;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use GuzzleHttp\Client;

class OpenLibraryAPIController extends Controller
{
    use ApiResponse;

    public function __construct() {
        /** define controller middleware */
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!request()->query('search')){
            return false;
        }

        $client = new Client(['headers'=>[
            'Accept' => 'application/json',
        ]]);

        $query = str_replace(' ', '+', request()->query('search'));

        $response = $client->request('GET', "https://openlibrary.org/search.json?q={$query}&limit=10&mode=ebooks");

        $results = json_decode($response->getBody()->getContents());

        $books = $this->filterApiResults($results->docs);

        return $this->apiSuccess(['searchResults' => $books]);
    }

    private function filterApiResults($books)
    {
        return collect($books)->map(function ($book) {
//            dd($book);
            return [
                'title' => isset($book->title_suggest) ? $book->title_suggest : null,
                'authors' => isset($book->author_name) ? $book->author_name : null,
                'coverId' => isset($book->cover_edition_key) ? $book->cover_edition_key : null,
                'key' => isset($book->key) ? $book->key : null
            ];
        })->all();
    }
}
