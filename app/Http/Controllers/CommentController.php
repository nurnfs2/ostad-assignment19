<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //

    public function index($postId)
    {
        $post = Post::findOrFail($postId);
        $comments = $post->comments;

        return response()->json($comments);
    }

    public function store(Request $request, $postId)
    {
        try {
            $post = Post::findOrFail($postId);

            $comment = new Comment();
            $comment->name = $request->input('name');
            $comment->content = $request->input('content');

            $post->comments()->save($comment);

            return response()->json($comment);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
