<?php

namespace App\Api;

use GuzzleHttp\Client;
use App\Traits\ApiResponse;
use Google_Client;
use Google_Service_Books;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use SimpleXMLElement;

class GoogleBooks
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
            'base_uri' => 'https://www.googleapis.com/books/v1/'
        ]);

        $this->apiKey = env('GOOGLE_API_KEY');
    }

    public function getBook($isbn)
    {
        if (!$isbn) {
            return $this->apiFail(['message' => 'Please provide a book isbn number']);
        }

        $result = $this->apiRequest("volumes?q=isbn:{$isbn}");

        $book = $this->filterApiBookResults($result, $isbn);

        return $book;
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

        return json_decode($result);
    }

    private function filterApiBookResults($result, $isbn)
    {
        if (! isset($result->items)) {
            return false;
        }

        $result = Collection::make($result->items);

        if (!$result) {
            return false;
        }

        $book = $result->first();

        return [
            'title'           => isset($book->volumeInfo->subtitle) ? "{$book->volumeInfo->title} {$book->volumeInfo->subtitle}" : $book->volumeInfo->title,
            'authors'         => isset($book->volumeInfo->authors) ? $book->volumeInfo->authors : '',
            'description'     => isset($book->volumeInfo->description) ? $book->volumeInfo->description : '',
            'original_url'    => str_replace('&edge=curl', '', $book->volumeInfo->imageLinks->thumbnail),
            'isbn'            => $isbn,
            'identifiers'     => isset($book->volumeInfo->industryIdentifiers) ? $book->volumeInfo->industryIdentifiers : '',
            'cover_url'       => isset($book->volumeInfo->imageLinks->thumbnail) ? str_replace('&edge=curl', '', $book->volumeInfo->imageLinks->thumbnail) : '',
            'small_cover_url' => isset($book->volumeInfo->imageLinks->smallThumbnail) ? $book->volumeInfo->imageLinks->smallThumbnail : '',
        ];
    }

    private function getLargerImage($coverURL)
    {
        $pos = strrpos($coverURL, 'm/');

        if (!$pos) {
            return $coverURL;
        }
        return substr_replace($coverURL, 'l/', $pos, strlen('m/'));
    }
}