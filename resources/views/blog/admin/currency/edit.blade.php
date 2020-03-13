@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('blog.admin.components.breadcrumb')
            @slot('title') Редактирование валюты @endslot
            @slot('parent') Главная @endslot
            @slot('currency') Список валют @endslot
            @slot('active') Редактирование валюты @endslot
        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{url('/admin/currency/edit', $currency->id)}}"
                          method="post" data-toggle="validator" id="addattrs">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование валюты</label>
                                <input value="{{$currency->title, old('title')}}" type="text"
                                       name="title" class="form-control" id="title"
                                       placeholder="Наименование валюты" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="code">Код валюты</label>
                                <input value="{{$currency->code, old('code')}}" type="text"
                                       name="code" class="form-control" id="title"
                                       placeholder="Код валюты" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="symbol_left">Символ слева</label>
                                <input value="{{$currency->symbol_left, old('symbol_left')}}"
                                       type="text" name="symbol_left" class="form-control" id="title"
                                       placeholder="Символ слева">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="symbol_right">Символ справа</label>
                                <input value="{{$currency->symbol_right, old('symbol_right')}}"
                                       type="text" name="symbol_right" class="form-control" id="title"
                                       placeholder="Символ справа">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="value">Значение</label>
                                <input value="{{$currency->value, old('value')}}" type="text"
                                       name="value" class="form-control" id="title" placeholder="Значение"
                                       title="если это базовая валюта поставте 1, то курс к базовой валюте."
                                       required data-error="Допускаеются цифры и десятичная точка" pattern="^[0-9.]{1,}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>

                                <div class="help-block form-control-feedback"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="value">
                                    <input type="checkbox" name="base" @if ($currency->base) checked @endif>
                                    Базовая валюта
                                </label>
                            </div>

                        </div>
                        <div class="box-footer">
                            <button class="btn btn-success" type="submit">Сохранить</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
