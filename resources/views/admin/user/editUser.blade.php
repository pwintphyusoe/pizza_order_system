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
                            <h3 class="text-center title-2">{{ $userData->name }} Profile</h3>
                        </div>

                        <form action="{{ route('user#updateInfo',$userData->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4 offset-2">
                                    @if($userData->image == null)
                                        @if($userData->gender == 'male')
                                            <img src="{{ asset('image/male_default_user.jpg')}}" class="img-thumbnail shadow-sm" alt="">
                                        @else
                                            <img src="{{ asset('image/female_default_user.jpg')}}" class="img-thumbnail shadow-sm" alt="">
                                        @endif
                                    @else
                                        <img src="{{ asset('storage/'.$userData->image) }}" class="img-thumbnail shadow-sm"/>
                                    @endif
                                    <div class="mt-3">
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" value="{{ old('image',$userData->image) }}">
                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row col-6">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="name" type="text" value="{{ old('name',$userData->name) }}"  class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new name...">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Email</label>
                                        <input id="cc-pament" name="email" type="email" value="{{ old('email',$userData->email) }}"  class="form-control @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new email...">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" name="phone" type="number" value="{{ old('phone',$userData->phone) }}"  class="form-control @error('phone') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new phone...">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Gender</label>
                                        <select name="gender" class="form-control @error('gender') is-invalid @enderror" >
                                            <option value="">Choose Gender...</option>
                                            <option value="male" @if($userData->gender == 'male') selected @endif>Male</option>
                                            <option value="female" @if($userData->gender == 'female')selected @endif>Female</option>
                                            @error('gender')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Address</label>
                                        <textarea name="address" cols="30" rows="10" class="form-control @error('address') is-invalid @enderror">{{ old('address',$userData->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Role</label>
                                        <input id="cc-pament" name="role" type="text" value="{{ old('role',$userData->role) }}"  class="form-control " aria-required="true" aria-invalid="false" disabled>
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
