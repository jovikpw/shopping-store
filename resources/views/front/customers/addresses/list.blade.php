@extends('layouts.front.app')

@section('content')
    <!-- Main content -->
    <section class="content container">
    @include('layouts.errors-and-messages')
    <!-- Default box -->
        @if($addresses)
            <div class="box">
                <div class="box-body">
                    <h2>Адреса</h2>
                    @if(!$addresses->isEmpty())
                        <table class="table">
                        <tbody>
                        <tr>
                            <td>Ориентир</td>
                            <td>Полный Адрес</td>
                            @if(isset($address->province))
                            <td>Область</td>
                            @endif
                            <td>State</td>
                            <td>City</td>
                            <td>Почтовый индекс</td>
                            <td>Страна</td>
                            <td>Статус</td>
                            <td>Действия</td>
                        </tr>
                        </tbody>
                        <tbody>
                        @foreach ($addresses as $address)
                            <tr>
                                <td><a href="{{ route('admin.customers.show', $customer->id) }}">{{ $address->alias }}</a></td>
                                <td>{{ $address->address_1 }}</td>
                                @if(isset($address->province))
                                <td>{{ $address->province->name }}</td>
                                @endif
                                <td>{{ $address->state_code }}</td>
                                <td>{{ $address->city }}</td>
                                <td>{{ $address->zip }}</td>
                                <td>{{ $address->country->name }}</td>
                                <td>@include('layouts.status', ['status' => $address->status])</td>
                                <td>
                                    <form action="{{ route('admin.addresses.destroy', $address->id) }}" method="post" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.addresses.edit', $address->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                            <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                        <a href="{{ route('accounts', ['tab' => 'profile']) }}" class="btn btn-default">Вернуться на главную аккаунта</a>
                    @else
                        <p class="alert alert-warning">У вас еще нет адресов. <a href="{{ route('customer.address.create', auth()->id()) }}">Создать</a></p>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        @else
            <div class="box">
                <div class="box-body"><p class="alert alert-warning">Не найдено сохраненных адресов.</p></div>
            </div>
        @endif
    </section>
    <!-- /.content -->
@endsection