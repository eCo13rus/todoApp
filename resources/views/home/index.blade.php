@extends('layouts.base')

@section('content')

@if(Auth::check())
    <h1>
      {{ Auth::user()->name }}, добро пожаловать в менеджер задач!
    </h1>
@else
    <h1>Добро пожаловать в менеджер задач!</h1>
@endif

@endsection
