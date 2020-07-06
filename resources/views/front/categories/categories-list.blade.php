@if(!empty($categories) && !collect($categories)->isEmpty())
    <ul class="row text-center list-unstyled">
        @foreach($categories as $category)
            <li class="col-md-3 col-sm-6 col-xs-12 product-list">
                <div class="single-product">
                    <div class="product">
                        <div class="product-overlay">
                            <div class="vcenter">
                                <div class="centrize">
                                    <ul class="list-unstyled list-group">
                                        <li>
                                            <form action="{{ route('cart.store') }}" class="form-inline" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="quantity" value="1" />
                                                <input type="hidden" name="product" value="{{ $category->id }}">
                                                <button id="add-to-cart-btn" type="submit" class="btn btn-warning" data-toggle="modal" data-target="#cart-modal"> <i class="fa fa-cart-plus"></i> Добавить в корзину</button>
                                            </form>
                                        </li>
                                        <li>  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal_{{ $category->id }}"> <i class="fa fa-eye"></i> Просмотреть</button>
                                        <li>  <a class="btn btn-default product-btn" href="{{ route('front.get.product', str_slug($category->slug)) }}"> <i class="fa fa-link"></i> Перейти к продукту</a> </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @if(isset($category->cover))
                            <img src="{{ asset("storage/$product->cover") }}" alt="{{ $category->name }}" class="img-bordered img-responsive">
                        @else
                            <img src="https://placehold.it/263x330" alt="{{ $category->name }}" class="img-bordered img-responsive" />
                        @endif
                    </div>

                    <div class="product-text">
                        <h4>{{ $category->name }}</h4>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal_{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div clas s="modal-dialog" role="document">
                            <div class="modal-content">
                                @include('layouts.front.product')
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
        @if($products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left">{{ $categories->links() }}</div>
                </div>
            </div>
        @endif
    </ul>
@else
    <p class="alert alert-warning">Продуктов еще нет</p>
@endif