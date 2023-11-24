<header>
    <nav class="navbar navbar-expand-lg bg-dark-subtle">
        <div class="container-fluid">
            <a class="navbar-brand ms-4" href="#">Менеджер задач</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Переключатель навигации">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active fs-5" aria-current="page" href="{{ route('home') }}">Главная</a>
                    </li>
                </ul>
            </div>
            <div>
                <a href="{{ route('login') }}" class="btn btn-primary me-3">Вход</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Регистрация</a>
            </div>
        </div>
    </nav>
</header>