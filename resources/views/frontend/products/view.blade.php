@extends('layouts.frontend')

@section('title',$product->name)

@section('content')

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ url('add-rating') }}" method="POST">
            @csrf
            <input type="hidden" class="product_id" value="{{ $product->id }}">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Rate this {{ $product->name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="rating-css">
                    <div class="star-icon">
                        @if($user_reting)

                        @for ($i =1; $i<=$user_reting->stars_rated; $i++)
                            <input type="radio" value="{{ $i }}" name="product_rating" checked id="{{ $i }}">
                            <label for="rating{{ $i }}" ><i class="material-icons opacity-10 checked">favorite</i></label>
                        @endfor
                        @for($j = $user_reting->stars_rated+1; $j <= 5; $j++)
                            <input type="radio" value="{{ $j }}" name="product_rating"  id="{{ $j }}">
                            <label for="rating{{ $j }}" ><i class="material-icons opacity-10 ">favorite</i></label>
                        @endfor

                        @else
                        <input type="radio" value="1" name="product_rating" checked id="rating1">
                        <label for="rating1" ><i class="material-icons opacity-10">favorite</i></label>
                        <input type="radio" value="2" name="product_rating" id="rating2">
                        <label for="rating2" ><i class="material-icons opacity-10">sentiment_dissatisfied</i></label>
                        <input type="radio" value="3" name="product_rating" id="rating3">
                        <label for="rating3" ><i class="material-icons opacity-10">sentiment_neutral</i></label>
                        <input type="radio" value="4" name="product_rating" id="rating4">
                        <label for="rating4" ><i class="material-icons opacity-10">sentiment_satisfied</i></label>
                        <input type="radio" value="5" name="product_rating" id="rating5">
                        <label for="rating5" ><i class="material-icons opacity-10">sentiment_very_satisfied</i></label>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>


<div class="py-3 mb-4 shadow-sm bg-warning border-top">
    <div class="container">
        {{-- <h6 class="mb-0">Callection/{{ $product->category->name }}/{{ $product->name }}</h6> --}}
        <h6 class="mb-0">
            <a href="{{ url('/e-shop/category') }}">Collection</a>/
            <a href="{{ url('view-category/'.$product->category->slug) }}">{{ $product->category->name }}</a>/
            <a href="{{ url('/e-shop/category/'.$product->category->slug.'/'.$product->slug) }}">{{ $product->name }}</a>
        </h6>
    </div>
</div>
<div class="container">
    <div class="card shadow product_data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 border-right">
                    <img src="{{ asset('uploads/product/'.$product->image) }}" style="height: 300px;" alt="">
                </div>
                <div class="col-md-8">
                    <h2 class="mb-0">
                        {{ $product->name }}
                        @if ($product->trending == '1')
                        <label style="font-size: 16px;" class="float-end badge bg-danger trending_tag">Trending</label>
                        @endif

                    </h2>

                    <hr>
                    <label class="me-3">Original Price : <s>Rs {{ $product->original_price }}</s></label>
                    <label class="fw-bold">Selling Price : Rs {{ $product->selling_price }}</label>
                    @php
                        $ratenum = number_format($rating_value)
                    @endphp
                    <div class="rating">
                        @for ($i =1; $i<=$ratenum; $i++)
                             <i class="material-icons opacity-10 checked">favorite</i>
                        @endfor

                        @for($j = $ratenum+1; $j <= 5; $j++)
                        <i class="material-icons opacity-10 ">favorite</i>
                        @endfor
                            <span>
                                @if($ratings->count() > 0)
                                     {{ $ratings->count() }} Ratings
                                @else
                               No Rating
                                @endif

                            </span>
                    </div>
                    <p class="mt-3">
                        {!! $product->small_description !!}
                    </p>
                    <hr>
                    @if($product->qty >0)
                        <label class="badge bg-success">In stock</label>
                        @else
                        <label class="badge bg-danger"> Out of stock</label>
                    @endif

                    <div class="row mt-2">
                        <div class="col-md-3">
                            <input type="hidden" class="prod_id" value="{{ $product->id }}">
                            <label for="Quantity">Quantity</label>
                            <div class="input-group text-center mb-3">
                                <span class="input-group-btn">
                                    <button class="input-group-text decrement-btn">-</button>
                                    <span class="glyphicon glyphicon-minus"></span>
                                </span>
                                 <input type="text" name="qty" value="1" class="form-control qty-input text-center" value="1">
                                <span class="input-group-btn">
                                    <button class="input-group-text increment-btn" >+</button>
                                </span>

                            </div>
                        </div>
                        <div class="col-md-9">
                            <br/>
                            @if($product->qty >0)
                                <button type="button" class="btn btn-primary me-3 addToCartBtn float-start">Add to Cart <i class="material-icons opacity-10">local_grocery_store</i></button>
                            @endif

                            <button type="button" class="btn btn-success me-3 addToWishlist float-start">Add to Wishlist <i class="material-icons opacity-10">favorite</i></button>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h3>Description</h3>
                    <p>
                        {{ $product->description }}
                    </p>
                </div>
                <hr>
                <div class="col md 12">
                     <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Rate this product
                      </button>
                      <a href="{{ url('add-review/'.$product->slug.'/userreview') }}" class="btn btn-primary">
                        write a review
                      </a>
                </div>
            </div>


        </div>

    </div>
    <div class="col-md-12 py-5">
        @foreach ($reviews as $item)
        <div class="user-review">
            <label for="">{{ $item->user->name .' '.$item->user->lname }}</label>
            @if ($item->user_id == Auth::id())
            <a href="{{ url('edit-review/'.$product->slug.'/userreview') }}">edit</a>
            @endif
            <br>
            @php
                $rating = App\Models\Rating::where('prod_id',$product->id)->where('user_id',$item->user->id)->first();
            @endphp
            @if($rating)
            @php
                $userated =$rating->stars_rated
            @endphp
            @for ($i =1; $i<=$userated; $i++)
            <i class="material-icons opacity-10 checked">favorite</i>
            @endfor

            @for($j = $userated+1; $j <= 5; $j++)
            <i class="material-icons opacity-10 ">favorite</i>
            @endfor
            @endif
            <small> Reviewed on {{ $item->created_at->format('d M Y') }}</small>
            <p>
                {{ $item->user_review }}
            </p>
        </div>

        @endforeach
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {

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


            $('.increment-btn').click(function (e) {
                e.preventDefault();

                var inc_value = $('.qty-input').val();
                var value = parseInt(inc_value,10);
                value = isNaN(value) ? 0 :value;
                if(value < 10)
                {
                    value++;
                    $('.qty-input').val(value);
                }
            });

            $('.decrement-btn').click(function (e) {
                e.preventDefault();

                var dec_value = $('.qty-input').val();
                var value = parseInt(dec_value,10);
                value = isNaN(value) ? 0 :value;
                if(value > 1)
                {
                    value--;
                    $('.qty-input').val(value);
                }
            });

            $('.addToWishlist').click(function (e) {
                e.preventDefault();
                var product_id = $(this).closest('.product_data').find('.prod_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                   method: "POST",
                   url: "/add-to-wishlist",
                   data:
                   {
                       'product_id':product_id,
                   },

                    success: function (response) {
                       swal(response.status);
                     }
                 });
            });
        });
    </script>
@endsection
