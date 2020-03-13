@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('blog.admin.components.breadcrumb')
            @slot('title') Фильтры @endslot
            @slot('parent') Главная @endslot
            @slot('active') Фильтры @endslot
        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{url('/admin/filter/attr-add')}}" class="btn btn-primary">
                                <i class="fa fa-fw fa-close fa-plus"></i>
                                Добавить атрибут
                            </a>
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Наименование</td>
                                    <td>Группа</td>
                                    <td>Действие</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($attrs as $attr)
                                    <tr>
                                        <td>{{$attr->id }}</td>
                                        <td>{{$attr->value }}</td>
                                        <td>{{$attr->title }}</td>
                                        <td>
                                            <a href="{{url('/admin/filter/attr-edit', $attr->id)}}" title=Редактирование">
                                                <i class="fa fa-fw fa-pencil"></i>
                                            </a>&nbsp;&nbsp;&nbsp;
                                            <a href="{{url('/admin/filter/attr-delete', $attr->id)}}" class="delete text-danger" title="Удаление">
                                                <i class="fa fa-fw fa-close text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-danger">
                            <p>@php echo count($attrs)@endphp фильтров из {{$count}}</p>
                            {{$attrs}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection
