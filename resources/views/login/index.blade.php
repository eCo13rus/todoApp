@extends('layouts.base')

@section('content')
<div class="container py-5 ">
    <div class="row py-5">
        <div class="col-md-4 mx-auto">
            <div class="p-4 border rounder shadow">
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <form class="text-start" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3 text-start">
                        <label for="exampleInputEmail1" class="form-label">Адрес электронной почты</label>
                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Введите почту" value="{{ old('email') }}" autocomplete="off">
                        @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>

                    <div class="mb-3 text-start">
                        <label for="exampleInputPassword1" class="form-label">Пароль</label>
                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="exampleInputPassword1" name="password" placeholder="Введите пароль" autocomplete="off">
                        @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                        @endif

                        <div class="mb-3 form-check text-start py-2">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
                            <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary text-start">Войти</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection