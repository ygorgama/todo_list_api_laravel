<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'completed' => 'boolean|sometimes',
            'title' => 'string|sometimes',
        ]);

        $task = Task::query();

        $task->ownedBy(request()->user()->id);

        if ($request->filled('completed')) {
            $task->searchByStatus($request->completed);
        }

        if ($request->filled('title')) {
            $task->searchByTitle($request->title);
        }

        return $task->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $request->validated();

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            "message" => "Task created successfully.",
            "task" => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json([
            "message" => "Task retrieved successfully.",
            "task" => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $task->update($request->validated());
        return response()->json([
            "message" => "Task updated successfully.",
            "task" => $task
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}
