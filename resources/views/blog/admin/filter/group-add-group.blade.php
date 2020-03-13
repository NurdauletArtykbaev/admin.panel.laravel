@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('blog.admin.components.breadcrumb')
            @slot('title') Добавить фильтров @endslot
            @slot('parent') Главная @endslot
            @slot('group_filter') Список группы @endslot
            @slot('active') Новая фильтров @endslot
        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{url('/admin/filter/group-add-group')}}" method="post" data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование группы</label>
                                <input type="text" name="title" class="form-control" id="title"
                                       placeholder="Наименование группы" value="{{ old('title') }}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-success" type="submit">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection
