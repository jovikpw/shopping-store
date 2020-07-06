@extends('layouts.front.app')

@section('content')
    <div class="container product-in-cart-list">
        <div class="row">
            <div class="col-md-12">
                <hr>
                <p class="alert alert-success">Ваш заказ принят! И поступил на обработку<a href="{{ route('home') }}">Показать больше!</a></p>
            </div>
        </div>
    </div>
@endsection