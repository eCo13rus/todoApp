@extends('layouts.base')

@section('content')

@if(Auth::check())

@if (session('success'))
<div class="alert alert-success mb-0" role="alert">
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
  <div class="row" id="tasksContainer">
    @foreach ($tasks as $task)
    <div class="col-md-3 text-center mb-3">
      <div class="card ">
        <h3 class="card-name">{{ $task->name }}</h3>
        <h5 class="card-header">{{ $task->title }}</h5>
        <div class="card-body">
          <p class="card-text">{{ $task->description }}</p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>


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
            <label for="creatorName" class="form-label">Имя создателя</label>
            <input type="text" class="form-control" id="creatorName" name="name" required>
          </div>
          <div class="mb-3">
            <label for="taskName" class="form-label">Название задачи</label>
            <input type="text" class="form-control" id="taskName" name="title" required>
          </div>
          <div class="mb-3">
            <label for="taskDescription" class="form-label">Описание задачи</label>
            <textarea class="form-control" id="taskDescription" name="description" rows="3" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Добавить задачу</button>
        </form>
      </div>
    </div>
  </div>
</div>


@else
<h1>Добро пожаловать в менеджер задач!
  <h4>Пожалуйста зарегистрируйтесь или войдите в свой профиль</h4>
</h1>
@endif

@endsection