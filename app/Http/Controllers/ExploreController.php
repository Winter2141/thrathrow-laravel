<?php

namespace App\Http\Controllers;

use App\Http\Resources\BeatResource;
use App\Http\Resources\GenreResource;
use App\Http\Resources\ProducerResource;
use App\Models\Beat;
use App\Models\Genre;
use App\Models\User;
use App\Service\BeatsService;
use App\Service\ProducersService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\StripeClient;

class ExploreController extends Controller
{
    /**
     * @var BeatsService
     */
    protected BeatsService $beatsService;

    /**
     * @var ProducersService
     */
    protected ProducersService $producersService;

    /**
     * @param BeatsService $beatsService
     * @param ProducersService $producersService
     * @return void
     */
    public function __construct(BeatsService $beatsService, ProducersService $producersService)
    {
        $this->beatsService = $beatsService;
        $this->producersService = $producersService;
    }

    public function index(Request $request): \Inertia\Response
    {

        $term = $request->get('term');
        if (isset($term)) {
//            $beats = Beat::search($term, function ($meilisearch, $query, $options) {
//                $options['filter'] = 'status=' . Beat::STATUSES['AVAILABLE'];
//                return $meilisearch->search($query, $options);
//            })->paginate(20);
            $beats = Beat::search($term)
                ->paginate(20);
            $producers = User::search($term)->paginate(20);
            foreach ($beats as &$beat) {
                $beat->uploader;
                $beat->genres;
            }
            return Inertia::render('Explore/Index', [
                'search' => true,
                'latestBeats' => BeatResource::collection($beats),
                'popularProducers' => ProducerResource::collection($producers),
                'genres' => [],
                'trendingBeats' => [],
                'filters' => []
            ]);
        }

        $filters = $this->getFilters($request);


        return Inertia::render('Explore/Index', [
            'search' => false,
            'trendingBeats' => BeatResource::collection($this->beatsService->getTrendingBeats($filters)),
            'latestBeats' => BeatResource::collection($this->beatsService->getLatestBeats($filters)),
            'popularProducers' => ProducerResource::collection($this->producersService->getPopularProducers($filters)),
            'genres' => GenreResource::collection(Genre::orderBy('name')->get()),
        ]);
    }

    private function getFilters(Request $request): array
    {
        $defaults = [
            'genres' => [],
            'minBpm' => 0,
            'maxBpm' => 300,
            'minPrice' => 0,
            'maxPrice' => 999999999,
            'isFree' => false,
            'limit' => 20
        ];

        $filters = $request->only(array_keys($defaults));

        foreach ($defaults as $key => $default) {
            if (!isset($filters[$key])) {
                $filters[$key] = $default;
            }
        }

        return $filters;
    }

    public function beats(Request $request): \Inertia\Response
    {
        $term = $request->get('term');
        if (isset($term)) {
            $beats = Beat::search($term)->paginate(20);
            foreach ($beats as &$beat) {
                $beat->uploader;
                $beat->genres;
            }
            return Inertia::render('Explore/Beats', [
                'search' => true,
                'trendingBeats' => BeatResource::collection($beats),
                'filters' => [],
                'genres' => [],
            ]);
        }

        $filters = $this->getFilters($request);

        return Inertia::render('Explore/Beats', [
            'trendingBeats' => BeatResource::collection($this->beatsService->getTrendingBeats($filters)),
            'search' => false,
            'genres' => GenreResource::collection(Genre::orderBy('name')->get()),
        ]);

    }

    public function producers(Request $request): \Inertia\Response
    {
        $term = $request->get('term');
        if (isset($term)) {
            $producers = User::search($term)->paginate(20);
            return Inertia::render('Explore/Producers', [
                'search' => true,
                'trendingProducers' => ProducerResource::collection($producers),
                'filters' => [],
                'genres' => [],
            ]);
        }

        $filters = $this->getFilters($request);

        return Inertia::render('Explore/Producers', [
            'search' => false,
            'trendingProducers' => ProducerResource::collection($this->producersService->getPopularProducers($filters)),
            'genres' => GenreResource::collection(Genre::orderBy('name')->get()),
        ]);
    }
}
