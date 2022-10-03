<?php

namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class LikesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request, Beat $beat, Comment $comment)
    {
        $user = \Auth::user();
        if ($comment->user_id === $user->id) {
            throw new UnauthorizedException('You can\'t like your own comment');
        }

        $like = Like::create([
            'user_id' => $user->id,
            'comment_id' => $comment->id,
        ]);

        return \Redirect::route('beats.show', [
            'beat' => $beat->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Request $request, Beat $beat, Comment $comment)
    {
        $user = \Auth::user();
        $like = Like::where('user_id', '=', $user->id)
            ->where('comment_id', '=', $comment->id)
            ->firstOrFail();

        $like->delete();

        return \Redirect::route('beats.show', [
            'beat' => $beat->id
        ]);
    }
}
