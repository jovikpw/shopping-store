@extends('layouts.front.app')

@section('content')
    <!-- Main content -->
    <section class="container content">
        <div class="row">
            <div class="box-body">
                @include('layouts.errors-and-messages')
            </div>
            <div class="col-md-12">
                <h2> <i class="fa fa-home"></i> Мой аккаунт</h2>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" @if(request()->input('tab') == 'profile') class="active" @endif><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Профиль</a></li>
                        <li role="presentation" @if(request()->input('tab') == 'orders') class="active" @endif><a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">Заказы</a></li>
                        <li role="presentation" @if(request()->input('tab') == 'address') class="active" @endif><a href="#address" aria-controls="address" role="tab" data-toggle="tab">Адреса</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content customer-order-list">
                        <div role="tabpanel" class="tab-pane @if(request()->input('tab') == 'profile')active @endif" id="profile">
                            {{$customer->name}} <br /><small>{{$customer->email}}</small>
                        </div>
                        <div role="tabpanel" class="tab-pane @if(request()->input('tab') == 'orders')active @endif" id="orders">
                            @if(!$orders->isEmpty())
                                <table class="table">
                                <tbody>
                                <tr>
                                    <td>Дата</td>
                                    <td>Итого</td>
                                    <td>Статус</td>
                                </tr>
                                </tbody>
                                <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <a data-toggle="modal" data-target="#order_modal_{{$order['id']}}" title="Show order" href="javascript: void(0)">{{ date('M d, Y h:i a', strtotime($order['created_at'])) }}</a>
                                            <!-- Button trigger modal -->
                                            <!-- Modal -->
                                            <div class="modal fade" id="order_modal_{{$order['id']}}" tabindex="-1" role="dialog" aria-labelledby="MyOrders">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Ссылка #{{$order['reference']}}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table">
                                                                <thead>
                                                                    <th>Адрес</th>
                                                                    <th>Способ оплаты</th>
                                                                    <th>Итого</th>
                                                                    <th>Статус</th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <address>
                                                                                <strong>{{$order['address']->alias}}</strong><br />
                                                                                {{$order['address']->address_1}} {{$order['address']->address_2}}<br>
                                                                            </address>
                                                                        </td>
                                                                        <td>{{$order['payment']}}</td>
                                                                        <td>{{ config('cart.currency_symbol') }} {{$order['total']}}</td>
                                                                        <td><p class="text-center" style="color: #ffffff; background-color: {{ $order['status']->color }}">{{ $order['status']->name }}</p></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <hr>
                                                            <p>Детали заказа:</p>
                                                            <table class="table">
                                                              <thead>
                                                                  <th>Название</th>
                                                                  <th>Количество</th>
                                                                  <th>Цена</th>
                                                                  <th>Изображение</th>
                                                              </thead>
                                                              <tbody>
                                                              @foreach ($order['products'] as $product)
                                                                  <tr>
                                                                      <td>{{$product['name']}}</td>
                                                                      <td>{{$product['pivot']['quantity']}}</td>
                                                                      <td>{{$product['price']}}</td>
                                                                      <td><img src="{{ asset("storage/".$product['cover']) }}" width=50px height=50px alt="{{ $product['name'] }}" class="img-orderDetail"></td>
                                                                  </tr>
                                                              @endforeach
                                                              </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="label @if($order['total'] != $order['total_paid']) label-danger @else label-success @endif">{{ config('cart.currency') }} {{ $order['total'] }}</span></td>
                                        <td><p class="text-center" style="color: #ffffff; background-color: {{ $order['status']->color }}">{{ $order['status']->name }}</p></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                                {{ $orders->links() }}
                            @else
                                <p class="alert alert-warning">У вас еще нет заказов. <a href="{{ route('home') }}">Заказать сейчас!</a></p>
                            @endif
                        </div>
                        <div role="tabpanel" class="tab-pane @if(request()->input('tab') == 'address')active @endif" id="address">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('customer.address.create', auth()->user()->id) }}" class="btn btn-primary">Создайте свой адрес</a>
                                </div>
                            </div>
                            @if(!$addresses->isEmpty())
                                <table class="table">
                                <thead>
                                    <th>Ориентир</th>
                                    <th>Полный адрес</th>
                                    <th>Город</th>
{{--                                    <th>City</th>--}}
{{--                                    @if(isset($address->province))--}}
{{--                                    <th>Province</th>--}}
{{--                                    @endif--}}
{{--                                    <th>State</th>--}}
                                    <th>Страна</th>
                                    <th>Почтовый индекс</th>
                                    <th>Ваш номер</th>
                                    <th>Действия</th>
                                </thead>
                                <tbody>
                                    @foreach($addresses as $address)
                                        <tr>
                                            <td>{{$address->alias}}</td>
                                            <td>{{$address->address_1}}</td>
                                            <td>{{$address->address_2}}</td>
{{--                                            <td>{{$address->city}}</td>--}}
{{--                                            @if(isset($address->province))--}}
{{--                                            <td>{{$address->province->name}}</td>--}}
{{--                                            @endif--}}
{{--                                            <td>{{$address->state_code}}</td>--}}
                                            <td>{{$address->country->name}}</td>
                                            <td>{{$address->zip}}</td>
                                            <td>{{$address->phone}}</td>
                                            <td>
                                                <form method="post" action="{{ route('customer.address.destroy', [auth()->user()->id, $address->id]) }}" class="form-horizontal">
                                                    <div class="btn-group">
                                                        <input type="hidden" name="_method" value="delete">
                                                        {{ csrf_field() }}
                                                        <a href="{{ route('customer.address.edit', [auth()->user()->id, $address->id]) }}" class="btn btn-primary"> <i class="fa fa-pencil"></i> Изменить</a>
                                                        <button onclick="return confirm('Вы уверены?')" type="submit" class="btn btn-danger"> <i class="fa fa-trash"></i> Удалить</button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                                <br /> <p class="alert alert-warning">У вас нет сохраненных адресов.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
