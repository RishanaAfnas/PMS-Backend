<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Services\TaskAssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
      public function index(Project $project)
    {
        return response()->json($project->tasks);
    }

    // Show single task
    public function show(Task $task)
    {
        return response()->json($task);
    }

    // Create task (Manager only)
    public function store(Request $request, Project $project , TaskAssignmentService $service)
    {
        $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'status'=>'nullable|in:pending,in-progress,done',
            'due_date'=>'nullable|date',
            'assigned_to'=>'required|exists:users,id'
        ]);

        $task = Task::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'status'=>$request->status ?? 'pending',
            'due_date'=>$request->due_date,
            'project_id'=>$project->id,
            'assigned_to'=>$request->assigned_to,
            'created_by'=>Auth::id(),
        ]);
         $service->assignTask($task, $request->user());
        return response()->json($task, 201);
    }

    // Update task (Manager or Assigned User)
    public function update(Request $request, Task $task , TaskAssignmentService $service)
    {  


        
        $user = Auth::user();

        if($user->role !== 'manager' && $user->id !== $task->assigned_to){
            return response()->json(['message'=>'Forbidden'],403);
        }

        $request->validate([
            'title'=>'sometimes|required|string|max:255',
            'description'=>'nullable|string',
            'status'=>'nullable|in:pending,in-progress,done',
            'due_date'=>'nullable|date',
            'assigned_to'=>'nullable|exists:users,id'
        ]);

        $task->update($request->only('title','description','status','due_date','assigned_to'));
        $service->assignTask($task, $request->user());
        return response()->json($task);
    }

    // Delete task (Manager only)
    public function destroy(Task $task)
    {
        if(Auth::user()->role !== 'manager'){
            return response()->json(['message'=>'Forbidden'],403);
        }

        $task->delete();
        return response()->json(['message'=>'Task deleted']);
    }
}
