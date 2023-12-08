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
  <h1>Задачи:</h1>
</div>

<div class="container-fluid">
  <div class="row ms-5 m-1" id="tasksContainer" data-tasks='@json($tasks)'>
    <!-- Задачи будут добавлены здесь через JavaScript -->
  </div>
</div>


<!-- Модальное окно для добавления задачи -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createTaskModalLabel">Новая задача</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="createTaskForm">
          <div class="mb-3">
            <label for="creatorName" class="form-label">Создал:</label>
            <input type="text" class="form-control" id="creatorName" name="name" required>
          </div>
          <div class="mb-3">
            <label for="taskName" class="form-label">Кому:</label>
            <input type="text" class="form-control" id="taskName" name="title" required>
          </div>
          <div class="mb-3">
            <label for="taskDescription" class="form-label">Описание задачи:</label>
            <textarea class="form-control" id="taskDescription" name="description" rows="3" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Добавить задачу</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Модальное окно для задачи -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="taskModalLabel">Редактирование задачи</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Форма редактирования задачи -->
        <form id="editTaskForm">
          <input type="hidden" id="editTaskId">
          <div class="mb-3">
            <label for="editTaskName" class="form-label">Создал:</label>
            <input type="text" class="form-control" id="editTaskName">
          </div>
          <div class="mb-3">
            <label for="editTaskTitle" class="form-label">Кому:</label>
            <input type="text" class="form-control" id="editTaskTitle">
          </div>
          <div class="mb-3">
            <label for="editTaskDescription" class="form-label">Описание:</label>
            <textarea class="form-control" id="editTaskDescription"></textarea>
          </div>
          <div class="d-flex justify-content-start">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <button type="button" class="btn btn-danger ms-4" id="deleteTaskButton">Удалить задачу</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


@else
<div class="mt-2">
  <h1>Добро пожаловать в менеджер задач!
    <h4>Пожалуйста зарегистрируйтесь или войдите в свой профиль.</h4>
  </h1>
</div>

<div class="col-span-full d-flex justify-content-start ms-4">
  <h1>Задачи:</h1>
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