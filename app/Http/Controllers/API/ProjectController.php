<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
public function index(Request $request)
{
    // Generate a unique cache key based on query parameters
    $cacheKey = 'projects.index.' . md5(json_encode($request->all()));

    // Cache the filtered projects for 30 minutes
    $projects = Cache::remember($cacheKey, 30*60, function () use ($request) {
        $query = Project::query();

        // Apply filters using your trait methods
        if ($request->has('title')) {
            $query->searchByTitle($request->title);
        }

        if ($request->has('status')) {
            $query->filterByStatus($request->status);
        }

        return $query->get();
    });

    return response()->json($projects);
}

    // Show single project
    public function show(Project $project)
    {
        return response()->json($project);
    }

    // Create project (Admin only)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => Auth::id(),
        ]);

        return response()->json($project, 201);
    }

    // Update project (Admin only)
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $project->update($request->only('title','description','start_date','end_date'));

        return response()->json($project);
    }

    // Delete project (Admin only)
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(['message'=>'Project deleted']);
    }
}
