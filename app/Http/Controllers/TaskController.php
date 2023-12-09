<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tasks = Task::paginate(8); // Или любое другое количество, которое ты предпочитаешь
            return response()->json([
                'tasks' => $tasks->items(),
                'pagination' => $tasks->links()->toHtml(), // Отправляем HTML пагинации
            ]);
        } else {
            $tasks = Task::paginate(8);
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

        return response()->json($task);
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
