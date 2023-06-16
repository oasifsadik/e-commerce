@extends('layouts.frontend')

@section('title')
    Welcome to E-Shop
@endsection

@section('content')
     @include('layouts.inc.slider')

<div class="py-5">
    <div class="container">
        <div class="row">
            <h2>Featured Product</h2>
            <div class="owl-carousel owl-theme">
                @foreach ($featured_product as $product)
                    <div class="item">
                        <div class="card">
                            <a href="{{ url('category/'.$product->category->name.'/'.$product->slug) }}">
                                <img src="{{ asset('uploads/product/'.$product->image) }}" style="height: 250px" alt="product image">
                                <div class="card-body">
                                    <h5>{{ $product->name }}</h5>
                                    @php($pDesc = strip_tags(htmlspecialchars_decode($product->description)))
                                        <p>
                                                {!! (strlen($pDesc) > 50) ? substr($pDesc,0,50).'...' : $pDesc; !!}
                                        </p>
                                    <span class="float-start">{{ $product->selling_price }}</span>
                                    <span class="float-end"> <s>{{ $product->original_price }}</s></span>
                                </div>
                             </a>
                        </div>
                    </div>
            @endforeach
            </div>
        </div>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="row">
            <h2>Trending Category</h2>
            <div class="owl-carousel owl-theme">
                @foreach ($trending_category as $category)
                    <div class="item">
                        <a href="{{ url('view-category/'.$category->slug) }}">
                            <div class="card">
                                <img src="{{ asset('category/'.$category->image) }}" style="height: 250px" alt="product image">
                                <div class="card-body">
                                    <h5>{{ $category->name }}</h5>
                                    @php($pDesc = strip_tags(htmlspecialchars_decode($category->description)))
                                        <p>
                                                {!! (strlen($pDesc) > 50) ? substr($pDesc,0,50).'...' : $pDesc; !!}
                                        </p>
                                    {{-- <p>
                                        {{ $category->description }}
                                    </p> --}}
                                </div>
                            </div>
                        </a>
                    </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel();
    });

    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots:false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    })
</script>
@endsection
