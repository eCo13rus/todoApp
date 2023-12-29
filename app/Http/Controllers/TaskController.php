<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::paginate(8);

        if ($request->ajax()) {
            return response()->json([
                'tasks' => $tasks->items(),
                'pagination' => $tasks->links()->toHtml(), // Отправляем HTML пагинации
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
