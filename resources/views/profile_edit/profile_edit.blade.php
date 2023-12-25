@extends('layouts.base')

@section('content')
<div class="container col-md-3 py-5">
    <h2>Изменение пароля:</h2>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <div class="mb-3 text-start mt-4">
            <label for="current_password" class="form-label">Текущий пароль</label>
            <input type="password" class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}" id="current_password" name="current_password" autocomplete="new-password" required>
            @if ($errors->has('current_password'))
            <div class="invalid-feedback">
                {{ $errors->first('current_password') }}
            </div>
            @endif
        </div>

        <div class="mb-3 text-start">
            <label for="new_password" class="form-label">Новый пароль</label>
            <input type="password" class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" id="new_password" name="new_password">
            @if ($errors->has('new_password'))
            <div class="invalid-feedback">
                {{ $errors->first('new_password') }}
            </div>
            @endif
        </div>

        <div class="mb-3 text-start">
            <label for="new_password_confirmation" class="form-label">Подтвердите новый пароль</label>
            <input type="password" class="form-control {{ $errors->has('new_password_confirmation') ? 'is-invalid' : '' }}" id="new_password_confirmation" name="new_password_confirmation">
            @if ($errors->has('new_password_confirmation'))
            <div class="invalid-feedback">
                {{ $errors->first('new_password_confirmation') }}
            </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Обновить пароль</button>
    </form>
</div>
@endsection