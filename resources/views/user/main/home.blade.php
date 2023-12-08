@extends('user.layouts.master')

@section('content')

<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <!-- Price Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-checkbox d-flex align-items-center justify-content-between mb-3 bg-dark px-3 py-2">
                        <label class="text-white pt-1" for="price-all">Categories</label>
                        <span class="badge border font-weight-normal">{{ count($category) }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="{{ route('user#home')}}" class="text-dark text-decoration-none">All</a>
                    </div>
                    @foreach($category as $c)
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="{{ route('user#filter',$c->id)}}" class="text-dark text-decoration-none">{{$c->name}}</a>
                    </div>
                    @endforeach
                </form>
            </div>
            <!-- Price End -->
            <div class="">
                <button class="btn btn btn-warning w-100">Order</button>
            </div>
        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <a href="{{ route('user#cartList')}}">
                                <button type="button" class="btn btn-primary position-relative">
                                    <i class="fa fa-shopping-cart mr-1"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                      {{count($cart)}}
                                    </span>
                                </button>
                            </a>

                            <a href="{{ route('user#history')}}" class="ms-2">
                                <button type="button" class="btn btn-primary position-relative">
                                    <i class="fa fa-shopping-cart mr-1"></i>History
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                      {{count($history)}}
                                    </span>
                                </button>
                            </a>

                        </div>


                            @if(session('contactSuccess'))
                            <div class="col-7">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fa-solid fa-check me-2 text-success me-2"></i>{{ session('contactSuccess') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                            @endif

                        <div class="ml-2">
                            <div class="btn-group">
                                <select name="sorting" id="sortingOption" class="form-control">
                                    <option value="">Choose Option..</option>
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <span class="row" id="dataList">
                   @if(count($pizza) != 0)
                        @foreach ($pizza as $item)
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" style="height: 250px;" src="{{ asset('storage/'.$item->image)}}" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href="{{ route('user#pizzaDetails',$item->id) }}"><i class="fa-solid fa-circle-info"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="">{{ $item->name }}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>{{ $item->price }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                   @endforeach
                   @else
                        <p class="shadow-sm col-6 offset-3 fs-4 py-3 text-center">There is no Product in this Category !</p>
                   @endif
                </span>

            </div>
        </div>
        <!-- Shop Product End -->
    </div>

</div>
<!-- Shop End -->

@endsection


@section('scriptSource')
<script>
    $(document).ready(function(){
        // $.ajax({
        //     type : 'get',
        //     url : 'http://127.0.0.1:8000/user/ajax/pizza/list',
        //     datatype : 'json',
        //     success : function(response){
        //         console.log(response);
        //     }
        // })

        $('#sortingOption').change(function(){
            $eventOption = $('#sortingOption').val();
            if($eventOption == 'desc'){
                $.ajax({
                    type : 'get',
                    url : '/user/ajax/pizza/list',
                    data : {'status' : 'desc'},
                    datatype : 'json',
                    success : function(response){
                        $list = '';
                        for($i=0;$i<response.length;$i++){
                            $list += `
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" style="height: 250px;" src="{{ asset('storage/${response[$i].image}')}}" alt="">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>${response[$i].price}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                        $('#dataList').html($list);
                    }
                })
            }else if($eventOption == 'asc'){
                $.ajax({
                    type : 'get',
                    url : '/user/ajax/pizza/list',
                    data : { 'status' : 'asc' },
                    dataType : 'json',
                    success : function(response){
                        $list = '';
                        for($i=0;$i<response.length;$i++){
                            $list += `
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" style="height: 250px;" src="{{ asset('storage/${response[$i].image}')}}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${response[$i].price}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                        }
                        $('#dataList').html($list);
                    }
                })
            }
        })
    })
</script>
@endsection
