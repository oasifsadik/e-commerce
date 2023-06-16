@extends('layouts.frontend')

@section('title')
    My Wishlist
@endsection

@section('content')

<div class="py-3 mb-4 shadow-sm bg-warning border-top">
    <div class="container product_data">
        {{-- <h6 class="mb-0">Callection/{{ $product->category->name }}/{{ $product->name }}</h6> --}}
        <h6 class="mb-0">
            <a href="{{ url('/') }}">Home</a>/
            <a href="{{ url('wishlist') }}">Wishlist</a>

        </h6>
    </div>
</div>

<div class="container my-5">
    <div class="card shadow">
        <div class="card-body">

        @if ($wishlist->count()> 0)

        <div class="card-body">
            @foreach ($wishlist as $item)
            <div class="row product_data">
                <div class="col-md-2">
                    <img src="{{ asset('uploads/product/'.$item->products->image) }}" height="70px" width="70px" alt="">
                </div>
                <div class="col-md-2">
                    <h6>{{ $item->products->name }}</h6>
                </div>
                <div class="col-md-2 my-auto">
                    <h6>Rs {{ $item->products->selling_price }}</h6>
                </div>
                <div class="col-md-2">
                    <input type="hidden" class="prod_id" value="{{ $item->prod_id }}">
                    @if($item->products->qty >= $item->prod_id )
                    <label for="qty">Quantity</label>
                        <div class="input-group text-center mb-3" style="width: 130px;">
                            <button class="input-group-text changeQuantity decrement-btn ">-</button>
                            <input type="text" name="qty" class="form-control qty-input text-center" value="1">
                            <button class="input-group-text changeQuantity increment-btn" >+</button>
                        </div>
                    <h6> In Stock</h6>
                    @else
                    <h6>Out Of Stock</h6>
                    @endif

                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary addToCartBtn"><i class="material-icons opacity-10">local_grocery_store</i> Add To Cart</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger remove-wishlist-item"><i class="material-icons opacity-10">delete</i> Remove</button>
                </div>
            </div>

            @endforeach
        </div>
        @else
            <h4>There are no product in your wishlist</h4>
        @endif
        </div>
    </div>
</div>
@endsection


@section('script')
    <script>
        $(document).ready(function () {
            $('.increment-btn').click(function (e) {
                e.preventDefault();

                var inc_value = $(this).closest('.product_data').find('.qty-input').val();
                var value = parseInt(inc_value,10);
                value = isNaN(value) ? 0 :value;
                if(value < 10)
                {
                    value++;
                    $(this).closest('.product_data').find('.qty-input').val(value);
                }
            });

            $('.decrement-btn').click(function (e) {
                e.preventDefault();

                var dec_value = $(this).closest('.product_data').find('.qty-input').val();
                var value = parseInt(dec_value,10);
                value = isNaN(value) ? 0 :value;
                if(value > 1)
                {
                    value--;
                    $(this).closest('.product_data').find('.qty-input').val(value);
                }
            });

            // $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });

            $('.remove-wishlist-item').click(function (e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var prod_id = $(this).closest('.product_data').find('.prod_id').val();
                $.ajax({
                    method: "POST",
                    url: "delete-wishlist-item",
                    data:
                    {
                        'prod_id' : prod_id,
                    },

                    success: function (response) {
                        window.location.reload();
                        swal("",response.status,"success");
                    }
                });
            });

            // $('.changeQuantity').click(function (e) {
            //     e.preventDefault();
            //     var prod_id = $(this).closest('.product_data').find('.prod_id').val();
            //     var qty = $(this).closest('.product_data').find('.qty-input').val();
            //     data = {
            //         'prod_id' : prod_id,
            //         'prod_qty' : qty,
            //     }
            //     $.ajax({
            //         method: "POST",
            //         url: "update-cart",
            //         data: data,

            //         success: function (response) {
            //             window.location.reload();
            //         }
            //     });
            // });
            $('.addToCartBtn').click(function (e) {
                e.preventDefault();

                var product_id = $(this).closest('.product_data').find('.prod_id').val();
                var product_qty = $(this).closest('.product_data').find('.qty-input').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    method: "POST",
                    url: "/add-to-cart",
                    data:
                    {
                        'product_id':product_id,
                        'product_qty':product_qty
                    },

                    success: function (response) {
                        swal(response.status);
                    }
                });
            });
        });
    </script>
@endsection
