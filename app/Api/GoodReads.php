<?php

namespace App\Api;

use GuzzleHttp\Client;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use SimpleXMLElement;

class GoodReads
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
            'headers'  => ['Accept' => 'application/xml'],
            'base_uri' => 'https://www.goodreads.com/'
        ]);

        $this->apiKey = env('GOODREADS_API_KEY');
    }

    /**
     * Search Goodreads with query
     *
     * @param $query string to search api with
     * @return \Illuminate\Http\Response
     */
    public function search($query)
    {
        if (!$query) {
            return $this->apiFail(['message' => 'Please provide search parameter']);
        }

        $results = $this->apiRequest("search.xml?key={$this->apiKey}&q={$query}");

        $books = $this->filterApiSearchResults($results);

        return $this->apiSuccess(['searchResults' => $books]);
    }

    public function getBook($id)
    {
        if (!$id) {
            return $this->apiFail(['message' => 'Please provide goodreads book id']);
        }

        $result = $this->apiRequest("book/show/{$id}.JSON?key={$this->apiKey}");

        $book = $this->filterApiBookResults($result);

        return $this->apiSuccess(['book' => $book]);
    }


    public function getBookByIsbn($isbn)
    {
        if (!$isbn) {
            return $this->apiFail(['message' => 'Please provide book isbn']);
        }

        $result = $this->apiRequest("book/isbn/{$isbn}.xml?key={$this->apiKey}");

        $book = $this->filterApiBookResults($result);

        return $this->apiSuccess(['book' => $book]);
    }



    /**
     * Makes requests to the API.
     *
     * @param  String $uri Api endpoint
     * @param  String $query Search qury
     * @param  array $data
     * @return json
     */
    private function apiRequest($uri)
    {
        $response = $this->client->request('GET', $uri);

        $result = $response->getBody()->getContents();

        return $this->convertXMLtoJSON($result);
    }

    private function convertXMLtoJSON($xmlString)
    {

        $xml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);

        $json = json_encode($xml);

        return json_decode($json, TRUE);
    }

    private function filterApiSearchResults($results)
    {
        $books = $results['search']['results']['work'];

        return Collection::make($books)->map(function ($book) {
            return [
                'goodreads_id'    => (int) $book['best_book']['id'],
                'average_rating'  => $book['average_rating'],
                'title'           => $book['best_book']['title'],
                'author'          => $book['best_book']['author']['name'],
                'cover_url'       => $this->getLargerImage($book['best_book']['image_url']),
                'original_url'    => $book['best_book']['image_url'],
                'cover_small_url' => $book['best_book']['small_image_url'],
            ];
        })->all();
    }

    private function filterApiBookResults($result)
    {
        $book = $result['book'];

        return [
            'goodreads_id'    => (int) $book['id'],
            'average_rating'  => $book['average_rating'],
            'title'           => $book['title'],
            'authors'         => $book['authors']['author'],
            'description'     => $book['description'],
            'cover_url'       => $this->getLargerImage($book['image_url']),
            'original_url'    => $book['image_url'],
            'cover_small_url' => $book['small_image_url'],
            'isbn'            => $book['isbn'],
            'isbn13'          => $book['isbn13'],
        ];
    }

    private function getLargerImage($coverURL)
    {
        /** if no cover url return null */
        if (strpos($coverURL, 'nophoto') !== false) {
            return null;
        }

        $pos = strrpos($coverURL, 'm/');

        if (!$pos) {
            return $coverURL;
        }

        return substr_replace($coverURL, 'l/', $pos, strlen('m/'));
    }
}