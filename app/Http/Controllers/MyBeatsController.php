<?php

namespace App\Http\Controllers;

use App\Http\Resources\BeatResource;
use Inertia\Inertia;

class MyBeatsController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        return Inertia::render('MyBeats', [
            'beats' => BeatResource::collection($user->beats()->with(['uploader', 'genres'])->paginate(20))
        ]);
    }
}
