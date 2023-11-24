@extends('layouts.base')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="p-4 border rounder shadow">
                <form class="text-start" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3 text-start">
                        <label for="inputName" class="form-label">Имя</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="inputName" name="name" placeholder="Введите имя" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                        @endif
                    </div>

                    <div class="mb-3 text-start">
                        <label for="exampleInputEmail1" class="form-label">Адрес электронной почты</label>
                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Введите почту" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>

                    <div class="mb-3 text-start">
                        <label for="exampleInputPassword1" class="form-label">Пароль</label>
                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="exampleInputPassword1" name="password" placeholder="Введите пароль">
                        @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                        @endif
                    </div>

                    <div class="mb-3 text-start">
                        <label for="exampleInputPassword2" class="form-label">Подтверждение пароля</label>
                        <input type="password" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" id="exampleInputPassword2" name="password_confirmation" placeholder="Введите пароль еще раз">
                        @if ($errors->has('password_confirmation'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection