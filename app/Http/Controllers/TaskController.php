<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Построение запроса с учетом поиска
        $query = Task::query();

        if ($request->query('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Добавляем фильтрацию по приоритету
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        /** @var \Illuminate\Pagination\LengthAwarePaginator $tasks */
        $tasks = $query->paginate(8);

        if ($request->ajax()) {
            return response()->json([
                'tasks' => $tasks->items(),
                'pagination' => $tasks->links()->toHtml(), // Возвращаем HTML для пагинации
            ]);
        } else {
            return view('home.index', compact('tasks'));
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task = new Task($validatedData);
        $task->user_id = auth()->id();
        $task->save();

        $totalTasks = Task::count(); // Получаем общее количество задач

        return response()->json([
            'task' => $task,
            'totalTasks' => $totalTasks // Возвращаем общее количество задач
        ], 201);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Request $request, string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task->update($validatedData);

        return response()->json($task);
    }

    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
