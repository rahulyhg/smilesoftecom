@foreach($products as $product)

    @php
        $prod = \App\ProductsModel::find($product->products_id);
    @endphp
    <div class="col-md-3 col-xs-4 product_list no-print target" onclick="getProductRow('{{$product->products_id}}');">
        <div class="product_box bg-gray" data-toggle="tooltip" data-placement="bottom" data-variation_id="57" title=""
             data-original-title="{{$product->products_name}}">
            <div class="image-container">
                {{--<img src="https://pos.ultimatefosters.com/uploads/img/1528727793_acerE15.jpg" alt="">--}}
                <img src="{{url('').'/'.$prod->products_image}}" alt="">
            </div>
            <div class="text text-muted text-uppercase">
                <small>
                    {{$product->products_name}}
                </small>
            </div>
            <small class="text-muted">
                {{rand(10000,99999)}}
            </small>
        </div>
    </div>
@endforeach