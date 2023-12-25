@extends('layouts.base')

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="container col-md-3 mx-auto py-5">
    <h2>Профиль Пользователя</h2>
    <p><strong>Имя:</strong> {{ $user->name }}</p>
    <p><strong>Почта:</strong> {{ $user->email }}</p>
    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Смена пароля</a>
</div>
@endsection
