@extends('admin.layouts.master')

@section('title','Category List')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-3 offset-8">
                    <a href="{{ route('products#list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
                </div>
            </div>
            <div class="col-lg-6 offset-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Create Your Product</h3>
                        </div>
                        <hr>
                        <form action="{{ route('products#create') }}" method="post" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label mb-1">Name</label>
                                <input id="cc-pament" name="pizaName" type="text" value="{{ old('pizaName')}}" class="form-control @error('pizaName') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter item Name...">
                                @error('pizaName')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="control-label mb-1">Category</label>
                                <select name="pizaCategory" class="form-control  @error('pizaCategory') is-invalid @enderror">
                                    <option value="">Choose Your Category</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                    @error('pizaCategory')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label mb-1">Description</label>
                                <textarea name="pizaDescription" class="form-control @error('pizaDescription') is-invalid @enderror" cols="30" rows="10" placeholder="Enter Description...">{{ old('pizaDescription')}}</textarea>
                                @error('pizaDescription')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="control-label mb-1">Image</label>
                                <input type="file" name="pizaImage" class="form-control  @error('pizaImage') is-invalid @enderror">
                                @error('pizaImage')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="control-label mb-1">Price</label>
                                <input id="cc-pament" name="pizaPrice" type="number" value="{{ old('pizaPrice')}}" class="form-control  @error('pizaPrice') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Item Price...">
                                @error('pizaPrice')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="control-label mb-1">Waiting Time</label>
                                <input id="cc-pament" name="pizaWaitingTime" type="number" value="{{ old('pizaWaitingTime')}}" class="form-control  @error('pizaWaitingTime') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Item Price...">
                                @error('pizaWaitingTime')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                    <span id="payment-button-amount">Create</span>
                                    <i class="fa-solid fa-circle-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection
