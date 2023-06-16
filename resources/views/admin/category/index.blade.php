@extends('layouts.admin')

@section('content')
      <div class="card">
        <div class="card-header">
            <h1>Category</h1>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                @php($pDesc = strip_tags(htmlspecialchars_decode($item->description)))
                                    <p>
                                            {!! (strlen($pDesc) > 50) ? substr($pDesc,0,50).'...' : $pDesc; !!}
                                    </p>
                            </td>
                            <td>
                                <img src="{{ asset('category/'.$item->image) }}" class="cate-image" alt="">
                            </td>
                            <td>
                                <a href="{{ 'edit-category/'.$item->id }}" class="btn btn-primary">Edit</a>
                                <a href="{{ 'category-delete/'.$item->id }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
@endsection
