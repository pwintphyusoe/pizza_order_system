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
                            <h3 class="text-center title-2"></h3>
                        </div>

                        <form action="{{ route('products#update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4 offset-2">
                                    <div class="mt-3">
                                        <img src="{{ asset('storage/'.$pizza->image) }}" alt="" class="img-thumbnail shadow-sm"/>
                                    </div>
                                    <div class="mt-3">
                                        <input type="hidden" name="pizzaId" value="{{ old('pizzaId',$pizza->id) }}">
                                        <input type="file" name="pizaImage" value="{{ old('pizaImage',$pizza->image) }}" class="form-control @error('pizaImage') is-invalid @enderror" >
                                        @error('pizaImage')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row col-6">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="pizaName" type="text" value="{{ old('pizaName',$pizza->name) }}"  class="form-control @error('pizaName') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Name...">
                                        @error('pizaName')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Description</label>
                                        <textarea name="pizaDescription" cols="30" rows="10" class="form-control @error('pizaDescription') is-invalid @enderror" placeholder="Enter Description...">{{ old('pizaDescription',$pizza->description) }}</textarea>
                                        @error('pizaDescription')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Price</label>
                                        <input id="cc-pament" name="pizaPrice" type="number" value="{{ old('pizaPrice',$pizza->price) }}"  class="form-control @error('pizaPrice') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new pizaPrice...">
                                        @error('pizaPrice')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Category</label>
                                        <select name="pizaCategory" class="form-control @error('pizaCategory') is-invalid @enderror" >
                                            <option value="">Choose category...</option>
                                            @foreach ($category as $c)
                                                <option value="{{ $c->id }}" @if( $pizza->category_id == $c->id) selected @endif>{{ $c->name }}</option>
                                            @endforeach
                                            @error('pizaCategory')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Waiting Time</label>
                                        <input id="cc-pament" name="pizaWaitingTime" type="number" value="{{ old('pizaWaitingTime',$pizza->waiting_time) }}"  class="form-control " aria-required="true" aria-invalid="false">
                                        @error('pizaWaitingTime')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">View Count</label>
                                        <input id="cc-pament" name="viewCount" type="text" value="{{ old('viewCount',$pizza->view_count) }}"  class="form-control " aria-required="true" aria-invalid="false" disabled>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success float-end col-4" type="submit">
                                            <i class="fa-solid fa-angles-right me-2"></i>Update
                                        </button>
                                    </div>
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
