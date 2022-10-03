<?php

namespace App\Http\Controllers;

use App\Http\Resources\BeatResource;
use App\Http\Resources\ProducerResource;
use App\Service\BeatsService;
use App\Service\ProducersService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * @var BeatsService
     */
    protected $beatsService;

    /**
     * @var ProducersService
     */
    protected $producersService;

    /**
     * HomeController constructor.
     * @param BeatsService $beatsService
     * @param ProducersService $producersService
     */
    public function __construct(BeatsService $beatsService, ProducersService $producersService)
    {
        $this->beatsService = $beatsService;
        $this->producersService = $producersService;
    }


    public function index()
    {
        $filters = [
            'genres' => [],
            'minBpm' => 0,
            'maxBpm' => 300,
            'minPrice' => 0,
            'maxPrice' => 999999999,
            'isFree' => false,
            'limit' => 20
        ];

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'trendingBeats' => BeatResource::collection($this->beatsService->getTrendingBeats($filters)),
            'latestBeats' => BeatResource::collection($this->beatsService->getLatestBeats($filters)),
            'popularProducers' => ProducerResource::collection($this->producersService->getPopularProducers($filters)),
        ]);
    }
}
