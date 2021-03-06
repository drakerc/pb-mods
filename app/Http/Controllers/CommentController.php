<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $comment = new Comment(
            [
                'post_id' => $request->post_id,
//                'game_id' => $request->game_id,
                'body' => $request->body,
                'author_id' => $user->id
            ]
        );
        $comment->save();
        return response()->json($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return response()->json(Comment::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $user = $request->user();

        if($comment->author_id != $user->id)
        {
            $is_member = false;
            $game = $comment->post->game()->first();
            Log::info($game);
            foreach ($game->developmentStudio()->get() as $studio)
            {
                if ($studio->users()->get()->contains($user)) {
                    $is_member = true;
                    break;
                }
            }
            if (!$is_member) {
                return response()->json([
                    'message' => 'Not allowed to perform this action'
                ], 401);
            }
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully'
        ], 200);
    }

    public function getForPostId($id)
    {
        $post = Post::findOrFail($id);
        if ($post && $post->comments())
        {
            return response()->json($post->comments()->orderBy('created_at', 'asc')->get());
        }
        return response()->json([]);
    }
}
