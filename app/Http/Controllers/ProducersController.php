<?php

namespace App\Http\Controllers;

use App\Http\Resources\BeatResource;
use App\Http\Resources\GenreResource;
use App\Http\Resources\ProducerResource;
use App\Models\Beat;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProducersController extends Controller
{
    public function trending(Request $request)
    {
        $genres = array_filter(explode(',', $request->get('genres')), function ($genre) {
            return strlen($genre) > 0;
        });

        $producers = \DB::table('users')
            ->join('beats', 'users.id', '=', 'beats.user_id')
            ->leftJoin('beat_purchase', 'beats.id', '=', 'beat_purchase.beat_id')
            ->groupBy('users.id');
        if (count($genres) > 0) {
            $producers
                ->leftJoin('genre_user', 'users.id', '=', 'genre_user.user_id')
                ->whereIn('genre_user.genre_id', $genres);
        }
        $producers = $producers->having('pCount', '>', 0)
            ->selectRaw('users.*, count(beat_purchase.beat_id) pCount')
            ->orderBy('pCount', 'desc')
            ->limit(10)
            ->get();

        return ProducerResource::collection($producers);
    }

    public function show(User $producer)
    {
        $beats = Beat::where('user_id', $producer->id)->paginate(20);
        $producer = User::withCount(['beats'])->find($producer->id);

        return Inertia::render('Producers/Show', [
            'user' => (new ProducerResource($producer)),
            'beats' => BeatResource::collection($beats),
        ]);
    }

    public function hire(User $producer)
    {
        $user = \Auth::user();

        if ($user && $user->id === $producer->id) {
            return Redirect::route('home');
        }

        $producer = User::withCount(['beats'])->find($producer->id);
        $genres = Genre::all();

        return Inertia::render('Producers/Hire', [
            'user' => (new ProducerResource($producer)),
            'genres' => GenreResource::collection($genres),
        ]);
    }
}
