@extends('admin.layouts.master')

@section('title','Category List')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Product List</h2>

                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <a href="{{ route('products#createPage')}}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>Add Product
                            </button>
                        </a>
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            CSV download
                        </button>
                    </div>
                </div>

                @if(session('deleteSuccess'))
                <div class="col-5 offset-7">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif

                <div class="row mb-3 p-3 text-center">
                    <div class="col-1 bg-white shadow-sm">
                        <h3><i class="fa-solid fa-database"></i> {{ $pizzas->total() }} </h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <h4 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span></h4>
                    </div>
                    <div class="col-3 offset-6 mb-3">
                        <form action="{{ route('products#list')}}" method="get">
                            <div class="d-flex">
                                <input type="text" class="form-control" name="key" placeholder="Search..." value="{{ request('key') }}">
                                <button class="btn btn-dark text-white">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if (count($pizzas) != 0)
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Waiting Time</th>
                                <th>View Count</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pizzas as $p)
                            <tr class="tr-shadow my-2">
                                <td class="col-2"><img src="{{ asset('storage/'.$p->image) }}" alt="" class="img-thumbnail shadow-sm"></td>
                                <td class="col-2">{{ $p->name }}</td>
                                <td class="col-2">{{ $p->price }}</td>
                                <td class="col-2">{{ $p->category_name }}</td>
                                <td class="col-2">{{ $p->waiting_time }} min</td>
                                <td class="col-2"><i class="fa-solid fa-eye me-2"></i>{{ $p->view_count }}</td>
                                <td class="col-2">
                                    <div class="table-data-feature">
                                        <a href="{{ route('products#edit',$p->id) }}">
                                            <button class="item me-2" data-toggle="tooltip" data-placement="top" title="view">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('products#updatePage',$p->id)}}">
                                            <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('products#delete',$p->id) }}">
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $pizzas->links() }}
                    </div>
                </div>
                @else
                <h2 class="text-secondary text-center">There is no item here!</h2>
                @endif
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection
