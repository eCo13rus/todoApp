@extends('layouts.base')

@section('content')

@if(Auth::check())

@if (session('success'))
<div class="alert alert-primary mb-0" role="alert">
  {{ session('success') }}
</div>
@endif

<div class="d-flex justify-content-start ms-4">
  <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#createTaskModal">
    Создать задачу
  </button>
</div>

<div class="col-span-full d-flex justify-content-start ms-4 mt-2">
  <h2>Задачи:</h2>
</div>

<div class="container-fluid">
  <div class="row ms-5 m-3" id="tasksContainer" data-tasks='@json($tasks)'>
    <!-- Задачи будут добавлены здесь через JavaScript -->
  </div>
</div>

<div class="pagination py-5" id="pagination">
  {{ $tasks->links() }}
</div>

@include('modals.create')

@include('modals.edit_task')


@else
<div class="mt-2">
  <h1>Добро пожаловать в менеджер задач!
    <h4>Пожалуйста зарегистрируйтесь или войдите в свой профиль.</h4>
  </h1>
</div>

<div class="col-span-full d-flex justify-content-start ms-4">
  <h2>Задачи:</h2>
</div>

<div class="container-fluid">
  <div class="row" id="tasksContainer">
    @foreach ($tasks as $task)
    <div class="col-md-3 text-start">
      <div class="card ms-5 m-3" style="width: 15rem; height: 200px" data-task-id="{{ $task->id }}">
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><strong>Создал:</strong> {{ $task->name }}</li>
          <li class="list-group-item"><strong>Кому:</strong> {{ $task->title }}</li>
          <li class="list-group-item" data-full-description="{{ $task->description }}">
            <strong>Описание:</strong> {{ $task->short_description }}
          </li>
        </ul>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endif

@endsection