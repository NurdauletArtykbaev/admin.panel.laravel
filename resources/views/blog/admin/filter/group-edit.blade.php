@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('blog.admin.components.breadcrumb')
            @slot('title') Добавить фильтров @endslot
            @slot('parent') Главная @endslot
            @slot('group_filter') Группа фильтров @endslot
            @slot('active') Новая группа @endslot
        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{route('blog.admin.filter.group-edit', $group->id)}}" method="post" data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование группы</label>
                                <input type="text" name="title" class="form-control" id="title"
                                       placeholder="Наименование группы" value="{{ $group->title }}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-success" type="submit">Изменить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection
