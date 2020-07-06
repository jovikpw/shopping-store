@extends('layouts.front.app')

@section('content')
    <div class="container product-in-cart-list">
        <div class="row">
            <div class="col-md-12">
                <hr>
                <p class="alert alert-warning">Вы отменили ваш заказ. Можеты вы хотите <a href="{{ route('home') }}">заказать другие?</a></p>
            </div>
        </div>
    </div>
@endsection