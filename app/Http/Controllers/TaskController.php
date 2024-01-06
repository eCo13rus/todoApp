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
        $task = new Task();
        $task->name = $request->name;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_id = auth()->id();
        $task->save();

        $totalTasks = Task::count(); // Получаем общее количество задач

        return response()->json([
            'task' => $task,
            'totalTasks' => $totalTasks // Возвращаем общее количество задач
        ]);
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
        $task->name = $request->name;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->save();

        return response()->json($task);
    }

    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json($task);
    }
}
