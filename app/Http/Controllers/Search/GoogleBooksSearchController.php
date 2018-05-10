<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Books;
use Illuminate\Support\Collection;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;

class GoogleBooksSearchController extends Controller
{
    use ApiResponse;
    protected $service, $optParams;

    public function __construct() {
        /** define controller middleware */
        $this->middleware('auth:api');

        $client = new Google_Client();
        $client->setApplicationName("MyBookcase");
        $client->setDeveloperKey(env('GOOGLE_API_KEY'));
        $this->service = new Google_Service_Books($client);
        $this->optParams = array('printType' => 'books', 'filter'=> 'paid-ebooks', 'maxResults' => 10, 'orderBy' => 'relevance');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!request()->query('search')){
            return $this->apiFail(['message' => "Please provide search param query string e.g. ?search=harry+potter"]);
        }
        $results = $this->service->volumes->listVolumes(str_replace(' ', '+', request()->query('search')), $this->optParams);

        $books = $this->filterApiSearchResults($results);

        return $this->apiSuccess(['searchResults' => $books]);
    }

    public function show($isbn)
    {
        if(!$isbn){
            return $this->apiFail(['message' => 'Please provide books ISBN number']);
        }

        $result = $this->service->volumes->listVolumes("isbn:{$isbn}", $this->optParams);

        $book = $this->filterApiBookResults($result);

        return $this->apiSuccess(['book' => $book]);
    }

    private function filterApiSearchResults($books)
    {
        return Collection::make($books)->reject(function ($book) {
            return !$book->volumeInfo->industryIdentifiers;
        })->map(function ($book) {
            if(isset($book->volumeInfo->imageLinks->thumbnail)){
                $coverURL = str_replace('zoom=1', 'zoom=0', $book->volumeInfo->imageLinks->thumbnail);
                $coverURL = str_replace('&edge=curl', '', $coverURL);
            }
            return [
                'title' => $book->volumeInfo->title,
                'authors' => $book->volumeInfo->authors,
                'coverUrl' => isset($coverURL) ? $coverURL : null,
                'identifiers' => $book->volumeInfo->industryIdentifiers,
            ];
        })->all();
    }

    private function filterApiBookResults($book)
    {
        $book = Collection::make($book)->first();
        if(isset($book->volumeInfo->imageLinks->thumbnail)){
            $coverURL = str_replace('zoom=1', 'zoom=0', $book->volumeInfo->imageLinks->thumbnail);
            $coverURL = str_replace('&edge=curl', '', $coverURL);
        }
        return [
            'title' => $book->volumeInfo->title,
            'authors' => $book->volumeInfo->authors,
            'coverUrl' => isset($coverURL) ? $coverURL : null,
            'identifiers' => $book->volumeInfo->industryIdentifiers,
            'description' => $book->volumeInfo->description
//            'description' => $book->volumeInfo->description,
        ];
    }
}
