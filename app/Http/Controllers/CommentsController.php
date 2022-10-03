<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Beat;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\UnauthorizedException;
use Inertia\Inertia;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(string $beatId)
    {
        $comments = Comment::with(['user', 'likes'])
            ->where('beat_id', '=', $beatId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return CommentResource::collection($comments);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request

     */
    public function store(Request $request, Beat $beat)
    {
        $user = \Auth::user();
        $data = $request->validate([
            'content' => ['required', 'string', 'min: 50']
        ]);

        $comment = $beat->comments()->create([
            'content' => $data['content'],
            'user_id' => $user->id,
        ]);

        return Redirect::route('beats.show', [
            'beat' => $beat
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return CommentResource
     */
    public function update(Request $request, Comment $comment)
    {
        $user = \Auth::user();

        if ($user->id !== $comment->user_id) {
            throw new UnauthorizedException();
        }

        $data = $request->validate([
            'content' => ['required', 'text', 'min: 50']
        ]);

        $comment->content = $data['content'];
        $comment->save();

        return new CommentResource($comment->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
