<?php

namespace App\Api;

use App\Jobs\ProcessBooks;
use GuzzleHttp\Client;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class ISBNdb
{
    use ApiResponse;
    /**
     * @var $client GuzzelHttp client
     */
    protected $client;

    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'headers'  => ['Accept' => 'application/xml', 'x-api-key' => env('ISBNDB_API_KEY')],
            'base_uri' => 'https://api.isbndb.com/',

        ]);
    }

    /**
     * Search Book with query
     *
     * @param $query string to search api with
     * @param $page number
     * @return \Illuminate\Http\Response
     */
    public function searchBooks($query, $page)
    {
        if (!$query) {
            return $this->apiFail(['message' => 'Please provide search parameter']);
        }

        $results = $this->apiRequest("books/{$query}?page={$page}");

        if(! isset($results->books)){
            return $this->apiSuccess(['searchResults' => [], 'totalResults' => 0]);
        }

        ProcessBooks::dispatch($results->books)->onQueue('high');

        return $this->apiSuccess(['data' => $results->books, 'totalResults' => $results->total, 'currentPage' => $page, 'query' => $query]);
    }

//    public function getBook($isbn)
//    {
//        if (!$isbn) {
//            return $this->apiFail(['message' => 'Please provide books isbn']);
//        }
//
//        $result = $this->apiRequest("book/{$isbn}");
////        dd();
////        $book = $this->filterApiBookResults($result);
//        if(! isset($result->book)){
//            return false;
//        }
//
//        return $result->book;
//    }
//
//
//    public function getBookByIsbn($isbn)
//    {
//        if (!$isbn) {
//            return $this->apiFail(['message' => 'Please provide book isbn']);
//        }
//
//        $result = $this->apiRequest("book/isbn/{$isbn}.xml?key={$this->apiKey}");
//
//        $book = $this->filterApiBookResults($result);
//
//        return $this->apiSuccess(['book' => $book]);
//    }
//
//
//
    /**
     * Makes requests to the API.
     *
     * @param  String $uri Api endpoint
     * @return JsonResponse
     */
    private function apiRequest($uri)
    {
        $response = $this->client->request('GET', $uri);

        $result = $response->getBody()->getContents();

        return json_decode($result);
    }
//
//    private function convertXMLtoJSON($xmlString)
//    {
//
//        $xml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);
//
//        $json = json_encode($xml);
//
//        return json_decode($json, TRUE);
//    }
//
//    private function filterApiSearchResults($results)
//    {
//        if(! isset($results['search']['results']['work'])){
//            return false;
//        }
//
//        $books = $results['search']['results']['work'];
//
//        return Collection::make($books)->map(function ($book) {
//            return [
//                'goodreads_id'    => (int) $book['best_book']['id'],
//                'average_rating'  => $book['average_rating'],
//                'title'           => $book['best_book']['title'],
//                'author'          => $book['best_book']['author']['name'],
//                'cover_url'       => $this->getLargerImage($book['best_book']['image_url']),
//                'original_url'    => $book['best_book']['image_url'],
//                'cover_small_url' => $book['best_book']['small_image_url'],
//            ];
//        })->all();
//    }
//
//    private function filterApiBookResults($result)
//    {
//        $book = $result['book'];
//
//        return [
//            'goodreads_id'    => (int) $book['id'],
//            'average_rating'  => $book['average_rating'],
//            'title'           => $book['title'],
//            'authors'         => $book['authors']['author'],
//            'description'     => $book['description'],
//            'cover_url'       => $this->getLargerImage($book['image_url']),
//            'original_url'    => $book['image_url'],
//            'cover_small_url' => $book['small_image_url'],
//            'isbn'            => $book['isbn'],
//            'isbn13'          => $book['isbn13'],
//        ];
//    }
//
//    private function getLargerImage($coverURL)
//    {
//        /** if no cover url return null */
//        if (strpos($coverURL, 'nophoto') !== false) {
//            return null;
//        }
//
//        $pos = strrpos($coverURL, 'm/');
//
//        if (!$pos) {
//            return $coverURL;
//        }
//
//        return substr_replace($coverURL, 'l/', $pos, strlen('m/'));
//    }
}