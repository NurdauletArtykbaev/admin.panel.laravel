@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('blog.admin.components.breadcrumb')
            @slot('title') Редактирование фильтров @endslot
            @slot('parent') Главная @endslot
            @slot('attrs_filter') Список фильтров @endslot
            @slot('active') Редактирование фильтра @endslot
        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{url('/admin/filter/attr-edit', $attr->id)}}" method="post" data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="value">Наименование</label>
                                <input type="text" name="value" class="form-control" id="title"
                                       placeholder="Наименование группы" value="{{ $attr->value }}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <select name="attr_group_id" id="category_id" class="form-control">
                                <option>Выберите группу</option>
                                @foreach($group as $item)
                                    <option value="{{ $item->id }}" @if($attr->attr_group_id == $item->id) selected @endif>
                                        {{$item->title}}</option>
                                @endforeach
                            </select>
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
