@extends('admin.layouts.layout')

@section('content')

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Статьи</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Blank Page</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Список статей</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Добавить статью</a>
                                @if (count($posts))
                                    <div class="table-responsive"> {{-- Чтобы таблица была адаптивной добавляем класс "table-responsive" --}}
                                        <table class="table table-bordered table-hover text-nowrap">
                                            <thead>
                                            <tr>
                                                <th style="width: 30px">#</th>
                                                <th>Наименование</th>
                                                <th>Категория</th>
                                                <th>Теги</th>
                                                <th>Дата</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($posts as $post) {{-- В цикле заполняем поля таблицы категорий свойствами --}}
                                                <tr>
                                                    <td>{{ $post->id }}</td>
                                                    <td>{{ $post->title }}</td>
                                                    <td>{{ $post->category->title }}</td>
                                                    <td>{{ $post->tags->pluck('title')->join (', ') }}</td> {{-- Теги здесь выводятся в виде коллекции (не читаемый вид). В Ларавель есть методы для работы с коллекциями (приводят данные в читаемый вид). Используем для этого метод pluck (https://laravel.com/docs/8.x/collections#method-pluck)  и выводим только 'title'. Чтобы полученный результат был читаемым, нам поможет метод join (https://laravel.com/docs/8.x/collections#method-join) --}}
                                                    <td>{{ $post->created_at }}</td>
                                                    <td>
                                                        <a href="{{ route('posts.edit', ['post' => $post->id]) }}" {{-- Указываем ссылку на редактирование категории - маршрут категории 'categories.edit' и дополнительный параметр ['category' => $category->id] --}} class="btn btn-info btn-sm float-left mr-1">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>

                                                        <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" {{-- Указываем ссылку на удаление категории - маршрут категории 'categories.destroy' и дополнительный параметр ['category' => $category->id] --}} method="post" class="float-left">
                                                            @csrf {{-- Токен шифрования данных --}}
                                                            @method('DELETE') {{-- Делаем подмену метода "post" на 'DELETE' --}}
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Подтвердите удаление')">
                                                                <i
                                                                    class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>Статей пока нет...</p>
                                @endif
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                {{ $posts->links('vendor.pagination.bootstrap-4') }}

                            </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

@endsection

