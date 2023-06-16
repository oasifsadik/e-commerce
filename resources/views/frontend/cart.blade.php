@extends('layouts.frontend')

@section('title')
    My Cart
@endsection

@section('content')

<div class="py-3 mb-4 shadow-sm bg-warning border-top">
    <div class="container">
        {{-- <h6 class="mb-0">Callection/{{ $product->category->name }}/{{ $product->name }}</h6> --}}
        <h6 class="mb-0">
            <a href="{{ url('/') }}">Home</a>/
            <a href="{{ url('cart') }}">Cart</a>

        </h6>
    </div>
</div>

<div class="container my-5">
    <div class="card shadow product_data ">
        @if ($cartitem ->count() > 0)
        <div class="card-body">
            @php
                $total = 0;
            @endphp
            @foreach ($cartitem as $item)
            <div class="row">
                <div class="col-md-2">
                    <img src="{{ asset('uploads/product/'.$item->products->image) }}" height="70px" width="70px" alt="">
                </div>
                <div class="col-md-3">
                    <h6>{{ $item->products->name }}</h6>
                </div>
                <div class="col-md-2 my-auto">
                    <h6>Rs {{ $item->products->selling_price }}</h6>
                </div>
                <div class="col-md-3">
                    <input type="hidden" class="prod_id" value="{{ $item->prod_id }}">
                    @if($item->products->qty >= $item->prod_id )
                        <label for="qty">Quantity</label>
                        <div class="input-group text-center mb-3" style="width: 130px;">
                            <button class="input-group-text changeQuantity decrement-btn ">-</button>
                            <input type="text" name="qty" class="form-control qty-input text-center" value="{{ $item->prod_qty }}">
                            <button class="input-group-text changeQuantity increment-btn" >+</button>
                        </div>
                            @php
                            $total += $item->products->selling_price * $item->prod_qty;
                            @endphp
                    @else
                    <h6>Out Of Stock</h6>
                    @endif

                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger delete-cart-item"><i class="material-icons opacity-10">delete</i></button>
                </div>
            </div>

            @endforeach
        </div>
        <div class="card-footer">
            <h6>Total Price : Rs {{ $total }}

                <a href="{{ url('checkout') }}" class="btn btn-outline-success float-end">Process to Checkout</a>
            </h6>

        </div>
        @else
        <div class="card-body text-center">
            <h2>Your <i class="material-icons opacity-10">local_grocery_store</i> Cart is empty</h2>
            <a href="{{ url('/e-shop/category') }}" class="btn btn-outline-primary float-end">Continue Shopping</a>
        </div>
        @endif

    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {

            // $('.addToCartBtn').click(function (e) {
            //     e.preventDefault();

            //     var product_id = $(this).closest('.product_data').find('.prod_id').val();
            //     var product_qty = $(this).closest('.product_data').find('.qty-input').val();

            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });

            //     $.ajax({
            //         method: "POST",
            //         url: "/add-to-cart",
            //         data:
            //         {
            //             'product_id':product_id,
            //             'product_qty':product_qty
            //         },

            //         success: function (response) {
            //             swal(response.status);
            //         }
            //     });
            // });


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

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            $('.delete-cart-item').click(function (e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var prod_id = $(this).closest('.product_data').find('.prod_id').val();
                $.ajax({
                    method: "POST",
                    url: "delete-cart-item",
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

            $('.changeQuantity').click(function (e) {
                e.preventDefault();
                var prod_id = $(this).closest('.product_data').find('.prod_id').val();
                var qty = $(this).closest('.product_data').find('.qty-input').val();
                data = {
                    'prod_id' : prod_id,
                    'prod_qty' : qty,
                }
                $.ajax({
                    method: "POST",
                    url: "update-cart",
                    data: data,

                    success: function (response) {
                        window.location.reload();
                    }
                });
            });
        });
    </script>
@endsection
