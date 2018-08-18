<?php

namespace App\Api;

use GuzzleHttp\Client;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Jobs\ProcessBooks;

class NewYorkTimes
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
            'base_uri' => 'https://api.nytimes.com/svc/books/v3/lists/'
        ]);

        $this->apiKey = env('NEW_YORK_TIMES_API_KEY');
    }

    public function getBestSellers()
    {
        $today = Carbon::today()->toDateString();
        $results = $this->apiRequest("overview.json?api-key={$this->apiKey}&published_date={$today}");
        $bestSellers = $this->filterApiResults($results);

        return $bestSellers;
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

    private function filterApiResults($results)
    {
        return Collection::make($results->results->lists)->map(function ($list) {
            $books = $this->getBooks($list->books);
            ProcessBooks::dispatch(json_decode($books));
            return collect([
                'name'  => $list->display_name,
                'books' => $books
            ]);
        })->all();
    }

    private function getBooks($books)
    {
        return Collection::make($books)->map(function ($book) {

            return Collection::make([
                'authors'    => $book->author,
                'title'     => title_case($book->title),
                'isbn'      => $book->primary_isbn10,
                'isbn13'      => $book->primary_isbn13,
                'image' => $book->book_image
            ]);
        });
    }
}