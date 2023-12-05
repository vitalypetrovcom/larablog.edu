<header class="market-header header">
    <div class="container-fluid">
        <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}"><img src="/assets/front/images/version/market-logo.png" alt=""></a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.single', ['slug' => 'marketing']) }}">Marketing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.single', ['slug' => 'make-money']) }}">Make Money</a>
                    </li>
                    {{--<li class="nav-item">
                        <a class="nav-link" href="marketing-blog.html">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="marketing-contact.html">Contact Us</a>
                    </li>--}}
                </ul>

                <form class="form-inline" method="get" action="{{ route('search') }}"> {{-- Задаем метод отправки формы "get" (хотя он и по умолчанию "get"), задаем action="" (он будет вести к SearchController экшн index: для этого у нас уже есть маршрут route('search')). Так как форма передается методом "get" (стандартная практика) нам здесь csrf токен не нужен. Если бы мы передавали форму методом post - нужно использовать csrf токен. Даем полю название name="s" (search). Чтобы показывать ошибки когда пользователь работает с формой поиска, мы добавляем в поле class @error('s') is-invalid  @enderror. Можно еще добавить html-валидацию с помощью аттрибута required --}}
                    <input name="s" class="form-control mr-sm-2 @error('s') is-invalid  @enderror" type="text" placeholder="How may I help?" required>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>

                {{--/* Нужно перенести в файл стилей */--}}
                <style>
                    .market-header .form-inline .form-control.is-invalid{
                        border: 2px solid red;
                    }
                </style>


            </div>
        </nav>
    </div><!-- end container-fluid -->
</header><!-- end market-header -->
