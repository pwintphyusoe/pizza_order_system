@extends('admin.layouts.master')

@section('title','detail')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="ms-5">
                            {{-- <a href="{{ route('products#list')}}" class="text-dark text-decoration-none">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a> --}}
                            <i class="fa-solid fa-arrow-left" onclick="history.back()"></i>
                        </div>


                        <div class="row mt-3">
                            <div class="col-3 offset-2">
                                <img src="{{ asset('storage/'.$pizza->image) }}" alt="" class="img-thumbnail shadow-sm"/>
                            </div>
                            <div class="col-5">
                                <h4 class="my-3"><i class="fa-solid fa-cookie-bite me-2"></i>{{ $pizza->name }}</h4>
                                <h4 class="my-3"><i class="fa-solid fa-money-bill-1-wave me-2"></i>{{ $pizza->price }}</h4>
                                <h4 class="my-3"><i class="fa-solid fa-hourglass-half me-2"></i>{{ $pizza->waiting_time }}</h4>
                                <h4 class="my-3"><i class="fa-regular fa-eye me-2"></i>{{ $pizza->view_count }}</h4>
                                <h4 class="my-3"><i class="fa-solid fa-clone"></i> {{ $pizza->category_name }}</h4>
                                <h4 class="my-3"><i class="fa-solid fa-clock me-2"></i>{{ $pizza->created_at->format('j-F-Y')}}</h4>
                                <span class="my-3"><i class="fa-solid fa-comment-dots me-2 fs-4"></i>{{ $pizza->description }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection
