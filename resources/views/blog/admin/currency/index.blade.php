@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('blog.admin.components.breadcrumb')
            @slot('title') Валюта @endslot
            @slot('parent') Главная @endslot
            @slot('active') Валюта @endslot
        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{url('/admin/currency/add') }}" class="btn btn-primary">
                                <i class="fa fa-fw fa-close fa-plus"></i>
                                Добавить валюту
                            </a>
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Наименование</td>
                                    <td>Код</td>
                                    <td>Значение</td>
                                    <td>Базовая</td>
                                    <td>Действие</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($currency as $item)
                                    <tr>
                                        <td>{{$item->id }}</td>
                                        <td>{{$item->title }}</td>
                                        <td>{{$item->code }}</td>
                                        <td>{{$item->value }}</td>
                                        <td>@if ($item->base == 1) Да @else Нет @endif</td>
                                        <td>
                                            <a href="{{url('/admin/currency/edit', $item->id)}}" title=Редактировать">
                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                                            <a href="{{url('/admin/currency/delete', $item->id)}}" class="" title="Удалить">
                                                <i class="fa fa-fw fa-close text-danger delete"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection
