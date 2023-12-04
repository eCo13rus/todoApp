<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('home.index', compact('tasks'));
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

        return response()->json(['message' => 'Задача обновлена']);
    }

    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Задача удалена']);
    }
}
