@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('blog.admin.components.breadcrumb')
            @slot('title') Добавление пользователя @endslot
            @slot('parent') Главная @endslot
            @slot('active') Добавление пользователя @endslot
        @endcomponent
    {{-- Main content --}}
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    {{-- Для валидации data-toggle="validator--}}
                    <form action="{{ route('blog.admin.users.store', $user->id) }}" method="post">

                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="login">Логин <small style="">меняется автоматически</small></label>
                                <input type="text" class="form-control" placeholder="" disabled value="{{ old('login') }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Пароль</label>
                                <input type="text" class="form-control" name="password"
                                       placeholder="Введите пароль, если хотите его изменить" value="{{ old('password') }}">
                            </div>
                            <div class="form-group">
                                <label for="">Подтверждение пароя</label>
                                <input type="text" class="form-control" name="password_confirmation"
                                       placeholder="Подтверждение пароля" value="{{ old('password_confirmation') }}">
                            </div>
                            <div class="form-group has-feedback">
                                <label for="name">Имя</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       value="" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" value="{{ old('name') }}"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="name">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       value="" required value="{{ old('email') }}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="role">Роль</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="2">Пользователь</option>
                                    <option value="3">Администратор</option>
                                    <option value="1">Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="box-footer">
                            <input type="hidden" name="id" value="">
                            <button class="btn btn-primary" type="submit">Создать</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
    {{-- /.content--}}
@endsection
