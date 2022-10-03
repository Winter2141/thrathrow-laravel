<?php


namespace App\Service;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ProducersService
{
    public function getPopularProducers(array $filters)
    {
        $producers = User::
            join('beats', 'users.id', '=', 'beats.user_id')
            ->leftJoin('beat_purchase', 'beats.id', '=', 'beat_purchase.beat_id')
            ->groupBy('users.id');

        if (!$filters['isFree']) {
            $producers->whereHas('beats', function (Builder $query) use ($filters) {
                $query->where('price', '<=', $filters['maxPrice'])
                    ->where('price', '>=', $filters['minPrice']);
            });
        } else {
            $producers->whereHas('beats', function (Builder $query) use ($filters) {
                $query->where('is_free', '=', 1)
                    ->orWhere('price', '=', 0);
            });
        }


        if (count($filters['genres']) > 0) {
            $producers
                ->leftJoin('genre_user', 'users.id', '=', 'genre_user.user_id')
                ->whereIn('genre_user.genre_id', $filters['genres']);
        }
        return $producers->having('pCount', '>', 0)
            ->selectRaw('users.*, count(beat_purchase.beat_id) pCount')
            ->orderBy('pCount', 'desc')
            ->limit($filters['limit'])
            ->get();
    }
}
