<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\User;
use App\Notifications\CommissionRequestedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class CommissionsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, User $producer)
    {
        $data = $request->validate([
            'description' => ['required', 'string', 'min:50'],
            'genres' => ['required', 'array', 'min:1'],
            'genres.*' => ['required', 'uuid', 'exists:genres,id'],
            'reference_url' => ['required', 'url'],
            'budget' => ['required', 'numeric', 'min:0']
        ]);

        $user = \Auth::user();

//        $currentCommissions = Commission::where('requested_by', $user->id)
//            ->where('requested_to', $producer->id)
//            ->where('status', 'pending')
//            ->count();


        $commission = $user->requestedCommissions()->create([
            'description' => $data['description'],
            'reference_url' => $data['reference_url'],
            'budget' => $data['budget'] * 100,
            'requested_to' => $producer->id
        ]);

        /** @var Commission $commission */
        $commission->genres()->attach($data['genres'], [
            'created_at' => Carbon::now(),
        ]);

        $producer->notify(new CommissionRequestedNotification($commission));

        return Redirect::route('producers.hire', [
            'producer' => $producer->id
        ]);
    }

    public function show(Commission $commission)
    {
        //
    }

    public function edit(Commission $commission)
    {
        //
    }

    public function update(Request $request, Commission $commission)
    {
        //
    }

    public function destroy(Commission $commission)
    {
        //
    }
}
