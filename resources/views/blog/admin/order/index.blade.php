@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('blog.admin.components.breadcrumb')
            @slot('title') Панель управления @endslot
            @slot('parent') Главная @endslot
            @slot('active') Список заказов @endslot
        @endcomponent

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Покупатель</td>
                                    <td>Статус</td>
                                    <td>Сумма</td>
                                    <td>Дата создания</td>
                                    <td>Дата изменения</td>
                                    <td>Действия</td>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($paginator as $order)
                                    @php $class = $order->status ? 'success' : '' @endphp
                                <tr {{ $class }} style="@if($order->status == 1)background: #add6ac @endif">
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>
                                        @if($order->status == 0)Новый @endif
                                        @if($order->status == 1)Завершен @endif
                                            @if($order->status == 2)<b style="color: #cd0a0a">Удален</b> @endif
                                    </td>
                                    <td>{{ $order->sum }} {{ $order->currency }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('blog.admin.orders.edit', $order->id) }}" title="Редактировать заказ"><i class="fa fa-fw fa-eye"></i></a>&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('blog.admin.orders.forcedestroy', $order->id) }}" title="Удалить заказ"><i class="fa fa-fw fa-close text-danger deletedb"></i></a>
                                    </td>
                                </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center" colspan="3">Заказов нет</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <p>{{ count($paginator) }} заказа(ов) из {{$countOrders}}</p>
                            @if($paginator->total() > $paginator->count())
                                <br>
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                {{ $paginator->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>

        </section>


@endsection
