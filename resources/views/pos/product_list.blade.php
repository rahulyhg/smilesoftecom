@foreach($products as $product)

    @php
        $prod = \App\ProductsModel::find($product->products_id);
        $barcode = \App\BarcodeModel::where(['product_id'=>$product->products_id])->first();
    @endphp
    <div class="col-md-3 col-xs-4 product_list no-print target" onclick="getProductRow('{{$product->products_id}}');">
        <div class="product_box bg-gray" data-toggle="tooltip" data-placement="bottom" data-variation_id="57" title=""
             data-original-title="{{$product->products_name}}">
            <div class="image-container">
                @php
                    $dir= "$prod->products_image";
                @endphp
                {{--<img src="https://pos.ultimatefosters.com/uploads/img/1528727793_acerE15.jpg" alt="">--}}

                @if(file_exists($dir))
                    <img src="{{url('').'/'.$prod->products_image}}" alt="">
                @else
                    <img src="{{url('resources/assets/images/no_product3.png')}}" alt="">
                @endif
            </div>
            <div class="text text-muted text-uppercase">
                <small>
                    {{$product->products_name}}
                </small>
            </div>
            <small class="text-muted">
                {{isset($barcode->barcode)?$barcode->barcode:'0'}}
            </small>
        </div>
    </div>
@endforeach