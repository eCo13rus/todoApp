<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $task->comments()->create([
            'content' => $validatedData['content'],
            'user_id' => auth()->id(),
        ]);

        return response()->json($comment->load('user'));
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
