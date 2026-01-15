<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a list of the authenticated user's tasks.
     * Supports search, status filtering, and JSON responses.
     */
    public function index(Request $request)
    {
        // Base query: get tasks belonging to the authenticated user
        // ordered by latest created
        $query = Auth::user()
            ->tasks()
            ->latest();

        // Search by task title (if provided)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter tasks by status (done or todo)
        $status = $request->query('status');

        if ($status === 'done') {
            $query->where('is_done', true);
        } elseif ($status === 'todo') {
            $query->where('is_done', false);
        }

        // Execute query
        $tasks = $query->get();

        // Return JSON for API requests or view for web requests
        return $request->expectsJson()
            ? response()->json($tasks)
            : view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form to create a new task.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in the database.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $data = $request->validate(
            [
                'title' => 'required|min:3|max:200',
                'description' => 'nullable|string|max:3000',
            ],
            [
                'title.required' => 'O título é obrigatório',
                'title.min' => 'O título deve ter pelo menos :min caracteres',
                'title.max' => 'O título deve ter no máximo :max caracteres',
            ]
        );

        // Create task associated with the authenticated user
        $task = Auth::user()->tasks()->create($data);

        // Return JSON response for API requests
        if ($request->expectsJson()) {
            return response()->json($task, 201);
        }

        // Redirect back to task list for web requests
        return redirect()->route('tasks.index');
    }

    /**
     * Show the form to edit an existing task.
     */
    public function edit(Task $task)
    {
        // Ensure the authenticated user owns the task
        $this->abortIfNotOwner($task);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update an existing task.
     */
    public function update(Request $request, Task $task)
    {
        // Prevent unauthorized updates
        $this->abortIfNotOwner($task);

        // Validate updated data (title and description)
        $data = $request->validate(
            [
                'title' => 'required|min:3|max:200',
                'description' => 'nullable|string|max:3000',
            ]
        );

        // Update task data
        $task->update($data);

        // Refresh model instance with latest database values
        $task->refresh();

        // Return JSON or redirect depending on request type
        return $request->expectsJson()
            ? response()->json($task)
            : redirect()->route('tasks.index');
    }

    /**
     * Toggle the task completion status (done / not done).
     */
    public function toggle(Request $request, Task $task)
    {
        // Ensure task ownership
        $this->abortIfNotOwner($task);

        // Invert the current task status
        $task->update([
            'is_done' => !$task->is_done,
        ]);

        // Return updated task
        return $request->expectsJson()
            ? response()->json($task->fresh())
            : redirect()->route('tasks.index');
    }

    /**
     * Delete a task.
     */
    public function destroy(Task $task)
    {
        // Ensure the authenticated user owns the task
        $this->abortIfNotOwner($task);

        // Delete task (soft delete if enabled on model)
        $task->delete();

        // Return proper response based on request type
        if (request()->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('tasks.index');
    }

    /**
     * Abort the request if the authenticated user
     * is not the owner of the task.
     */
    public function abortIfNotOwner(Task $task)
    {
        abort_if($task->user_id !== Auth::id(), 403);
    }
}
