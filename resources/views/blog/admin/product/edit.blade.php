@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('blog.admin.components.breadcrumb')
            @slot('title')  Редактирование товара @endslot
            @slot('parent') Главная @endslot
            @slot('product') Список товаров @endslot
            @slot('active') Редактирование товара {{ $product->title }} @endslot
        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{ route('blog.admin.products.update', $product->id) }}"
                          method="post" data-toggle="validator" id="add">
                        @method('PATCH')
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Наименование товара</label>
                                <input type="text" name="title" class="form-control" id="title"
                                       placeholder="Наименование товара" value="{{ $product->title }}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group">
                                <label for="title">Категория товара</label>
                                <select name="parent_id" id="parent_id" class="form-control" required>
                                    <option disabled>-- Выберите категорию --</option>

                                    @include('blog.admin.product.include.categories_for_prod', ['categories'=>$categories])


                                </select>
                            </div>

                            <div class="form-group">
                                <label for="keywords">Ключевые слова</label>
                                <input type="text" name="keywords" class="form-control" id="keywords"
                                       placeholder="Ключевые слова" value="{{ $product->keywords }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Описание</label>
                                <input type="text" name="description" class="form-control" id="description"
                                       placeholder="Описание" value="{{ $product->description}}" required>
                            </div>

                            <div class="form-group">
                                <label for="price">Цена</label>
                                <input type="text" name="price" class="form-control" id="price"
                                       placeholder="Цена" pattern="^[0-9.]{1,}$" value="{{ $product->price }}"
                                       required data-error="Допускаются цифры и десятичная точка">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group">
                                <label for="old_price">Старая цена</label>
                                <input type="text" name="old_price" class="form-control" id="old_price"
                                       placeholder="Старая Цена" pattern="^[0-9.]{1,}$" value="{{ $product->old_price }}"
                                       required data-error="Допускаются цифры и десятичная точка">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="content">Контент</label>
                                <textarea name="content" id="editorl" cols="80" rows="10">
                                    {{ $product->content }}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="status" {{ $product->status ? "checked" : null }}>Статус
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="hit" {{ $product->hit ? "checked" : null }}>Хит
                                </label>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="related">Связанные товары</label>
                                <p><small>Начните вводить наименование товара...</small></p>
                                <select name="related[]" class="select2 form-control" id="related" multiple>
                                    @if(!empty($related_products))
                                        @foreach($related_products as $prod)
                                            <option value="{{ $prod->related_id }}" selected>
                                                {{ $prod->title }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="related">Фильтры продукта</label>
                                {{ Widget::run('filter', ['tpl'=>'widgets.filter', 'filter' =>$filter,])}}
                                {{-- 'widgets.filter' - resource widget name --}}
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    @include('blog.admin.product.include.image_single_edit')
                                </div>
                                <div class="col-md-8">
                                    @include('blog.admin.product.include.image_gallery_edit')
                                </div>
                            </div>





                        </div>
                        <input type="hidden" id="_token" value="{{ csrf_token() }}">
                        <div class="box-footer">
                            <button class="btn btn-success" type="submit">Добавить</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <di class = "hidden" data-name="{{$id}}"></di>
@endsection
