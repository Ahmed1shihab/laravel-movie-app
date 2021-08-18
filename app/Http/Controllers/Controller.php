<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected const BASE_URL = "https://api.themoviedb.org/3/";

    public function getRequest(string $url)
    {
        return Http::withToken(config("services.tmdb.token"))->get($this::BASE_URL . $url)->json();
    }
}
