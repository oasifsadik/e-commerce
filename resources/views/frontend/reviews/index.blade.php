@extends('layouts.frontend')

@section('title', "Write a Review")

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if ($verified_purchase->count() > 0)
                        <h5>You are writeing a review for {{ $product->name }}</h5>
                        <form action="{{ url('/add-review') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <textarea name="user_review" class="form-control" rows="5" placeholder="write a review"></textarea>
                            <button  type="submit" class="btn btn-primary mt-3">Submit review</button>
                        </form>
                    @else
                        <div class="alert alert-danger">
                            <h5>you are not eligible to write a review this product</h5>
                            <p>
                                For The trusthworthiness of the review, only castomers who purches the product can weite a review about the product.
                            </p>
                            <a href="{{ url('/') }}" class=" btn btn-primary mt-3">Go to home page</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
