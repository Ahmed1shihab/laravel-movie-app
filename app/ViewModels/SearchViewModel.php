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

            if (isset($result['poster_path'])) {
                $posterPath = "https://image.tmdb.org/t/p/w92/" . $result['poster_path'];
            } elseif (isset($result['profile_path'])) {
                $posterPath = 'https://image.tmdb.org/t/p/w235_and_h235_face/' . $result['profile_path'];
            } else {
                $posterPath = 'https://via.placeholder.com/50x75';
            }

            if ($result['media_type'] === 'movie') {
                $linkToPage = route('movies.show', $result['id']);
            } elseif ($result['media_type'] === 'tv') {
                $linkToPage = route("tv.show", $result["id"]);
            } else {
                $linkToPage = route('actors.show', $result['id']);
            }

            return collect($result)->merge([
                'title' => $title,
                "poster_path" => $posterPath,
                'linkToPage' => $linkToPage,
            ])->only([
                'title', 'linkToPage', "poster_path"
            ]);

        });
    }
}
