<?php


namespace App\Service;


use App\Models\Beat;

class BeatsService
{
    public function getTrendingBeats(array $filters)
    {
        $beats = Beat::with(['uploader'])
            ->withCount('purchases')
            ->orderBy('purchases_count', 'desc')
            ->where('status', '=', Beat::STATUSES['AVAILABLE'])
            ->where('bpm', '>=', $filters['minBpm'])
            ->where('bpm', '<=', $filters['maxBpm']);

        if (!$filters['isFree']) {
            $beats = $beats->where('price', '<=', $filters['maxPrice'])
                ->where('price', '>=', $filters['minPrice']);
        } else {
            $beats = $beats->where(function ($query) {
                $query->where('is_free', '=', 1)
                    ->orWhere('price', '=', 0);
            });
        }

        if (count($filters['genres']) > 0) {
            $beats = $beats
                ->join('beat_genre', 'beats.id', '=', 'beat_genre.beat_id')
                ->whereIn('beat_genre.genre_id', $filters['genres']);
        }

        return $beats->paginate($filters['limit']);
    }

    public function getLatestBeats(array $filters)
    {
        $beats = Beat::with(['uploader'])
            ->orderBy('beats.created_at', 'desc')
            ->where('status', '=', Beat::STATUSES['AVAILABLE']);

        if (!$filters['isFree']) {
            $beats = $beats->where('price', '<=', $filters['maxPrice'])
                ->where('price', '>=', $filters['minPrice']);
        } else {
            $beats = $beats->where(function ($query) {
                $query->where('is_free', '=', 1)
                    ->orWhere('price', '=', 0);
            });
        }

        if (count($filters['genres']) > 0) {
            $beats
                ->join('beat_genre', 'beats.id', '=', 'beat_genre.beat_id')
                ->whereIn('beat_genre.genre_id', $filters['genres']);
        }
        return $beats->paginate($filters['limit']);
    }
}
