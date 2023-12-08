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
                        <div class="card-title">
                            <h3 class="text-center title-2">{{ Auth::user()->name }} Profile</h3>
                        </div>

                        <div class="row mt-3">
                            <div class="col-3 offset-2">
                                @if(Auth::user()->image == null)
                                    @if(Auth::user()->gender == 'male')
                                        <img src="{{ asset('image/male_default_user.jpg')}}" class="img-thumbnail shadow-sm" alt="">
                                    @else
                                        <img src="{{ asset('image/female_default_user.jpg')}}" class="img-thumbnail shadow-sm" alt="">
                                    @endif
                                @else
                                    <img src="{{ asset('storage/'.Auth::user()->image)}}" class="img-thumbnail shadow-sm"/>
                                @endif
                            </div>
                            <div class="col-5">
                                <h4 class="my-3"><i class="fa-regular fa-face-grin-wide me-3"></i>{{ Auth::user()->name }}</h4>
                                <h4 class="my-3"><i class="fa-solid fa-envelope me-3"></i>{{ Auth::user()->email }}</h4>
                                <h4 class="my-3"><i class="fa-solid fa-phone me-3"></i>{{ Auth::user()->phone }}</h4>
                                <h4 class="my-3"><i class="fa-solid fa-mars-and-venus me-3"></i>{{ Auth::user()->gender }}</h4>
                                <h4 class="my-3"><i class="fa-solid fa-location-dot me-3"></i>{{ Auth::user()->address }}</h4>
                                <h4 class="my-3"><i class="fa-regular fa-calendar-days me-3"></i>{{ Auth::user()->created_at->format('j-F-Y')}}</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <a href="{{ route('admin#edit') }}">
                                <button class="btn btn-dark col-2 offset-3">
                                    <i class="fa-solid fa-user-pen me-2"></i>Edit
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection
