<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     *List of tasks
     */
    public function index()
    {
        $tasks = Auth::user()
        ->tasks()
        ->latest()
        ->get();

        return view('index', compact('tasks'));
    }

    /**
     * Create of tasks
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Save new tasks
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'title' => 'required|min:3|max:200',
                'description' => 'nullable|max:3000',
            ],
            [
                'title.required' => 'O título é obrigatório',
                'title.min' => 'O título deve ter pelo menos :min caracteres',
                'title.max' => 'O título deve ter pelo menos :max caracteres',
            ],
        );

        Auth::user()->tasks()->create($data);

        return redirect()
        ->route('tasks.index')
        ->with('success', 'Tarefa criada com sucesso');
    }

    /**
     * Edit of tasks
     */
    public function edit(Task $task)
    {
        abort_if($task->user_id !== Auth::id(), 403);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Updade of tasks
     */
    public function update(Request $request, Task $task)
    {
        abort_if($task->user_id !== Auth::id(), 403);

        $data = $request->validate(
            [
                'title' => 'required|min:3|max:200',
                'description' => 'nullable|max:3000',
            ],
        );

        $task->update($data);

        return redirect()
        ->route('tasks.index')
        ->with('success', 'Tarefa atualizada com sucesso');
    }

    public function destroy(Task $task)
    {
        abort_if($task->user_id !== Auth::id(), 403);

        $task->delete();

        return redirect()
        ->route('tasks.index')
        ->with('success', 'Tarefa removida');
    }
}
