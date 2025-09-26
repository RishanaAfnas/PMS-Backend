<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
      public function index(Task $task)
    {
        return response()->json($task->comments);
    }

    // Add comment
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'body'=>'required|string'
        ]);

        $comment = Comment::create([
            'body'=>$request->body,
            'task_id'=>$task->id,
            'user_id'=>Auth::id(),
        ]);

        return response()->json($comment, 201);
    }
}
