<header>
    <nav class="navbar navbar-expand-lg text-bg-dark p-2">
        <div class="container-fluid">
            <a class="navbar-brand ms-2 text-white" href="{{ route('home') }}">Менеджер задач</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Переключатель навигации">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active fs-5 text-white" aria-current="page" href="{{ route('home') }}">Главная</a>
                    </li>
                </ul>
            </div>

            @if(Auth::guest())
            <div>
                <a href="{{ route('login') }}" class="btn btn-primary me-3">Вход</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Регистрация</a>
            </div>
            @else
            <div class="d-flex justify-content-end">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle me-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}">Профиль</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Выйти</a></li>
                    </ul>
                </div>
            </div>

            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark" id="staticBackdropLabel">Подтверждение выхода</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                        </div>
                        <div class="modal-body text-dark">
                            Вы уверены, что хотите выйти из системы?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Отмена</button>
                            <a href="{{ route('logout') }}" class="btn btn-primary">Выйти</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </nav>
</header>