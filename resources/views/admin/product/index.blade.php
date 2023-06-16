@extends('layouts.admin')

@section('content')
      <div class="card">
        <div class="card-header">
            <h1> all product Page</h1>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Selling Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->Category->name }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->selling_price }}</td>
                            <td>
                                <img src="{{ asset('uploads/product/'.$item->image) }}" class="cate-image" alt="">
                            </td>
                            <td>
                                <a href="{{ 'edit-product/'.$item->id }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ 'product-delete/'.$item->id }}" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
@endsection
