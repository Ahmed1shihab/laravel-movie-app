<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class SearchViewModel extends ViewModel
{
    public $searchResults;

    public function __construct($searchResults)
    {
        $this->searchResults = collect($searchResults)->take(7);
    }

    public function searchResults()
    {
        $searchResults = $this->searchResults;

        return collect($searchResults)->map(function($result) {

            if (isset($result['title'])) {
                $title = $result['title'];
            } elseif (isset($result['name'])) {
                $title = $result['name'];
            } else {
                $title = 'Untitled';
            }

            return collect($result)->merge([
                'title' => $title,
                "poster_path" => $result["poster_path"] ? "https://image.tmdb.org/t/p/w92/" . $result['poster_path'] : "https://via.placeholder.com/50x75",
                'linkToPage' => $result['media_type'] === 'movie' ? route('movies.show', $result['id']) : route("tv.show", $result["id"]),
            ])->only([
                'title', 'linkToPage', "poster_path"
            ]);

        });
    }
}
