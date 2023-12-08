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
                            <h3 class="text-center title-2">{{ $data->name }}Profile</h3>
                        </div>

                        <form action="{{ route('admin#change',$data->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4 offset-2">
                                    @if($data->image == null)
                                        @if($data->gender == 'male')
                                            <img src="{{ asset('image/male_default_user.jpg')}}" class="img-thumbnail shadow-sm" alt="">
                                        @else
                                            <img src="{{ asset('image/female_default_user.jpg')}}" class="img-thumbnail shadow-sm" alt="">
                                        @endif
                                    @else
                                        <img src="{{ asset('storage/'.$data->image) }}" class="img-thumbnail shadow-sm"/>
                                    @endif

                                </div>
                                <div class="row col-6">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input id="cc-pament" disabled name="name" type="text" value="{{ old('name',$data->name) }}"  class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new name...">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Role</label>
                                        <select name="role" class="form-control">
                                            <option value="admin" @if($data->role == 'admin') selected @endif>Admin</option>
                                            <option value="user" @if($data->role == 'user') selected @endif>user</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Email</label>
                                        <input id="cc-pament" disabled name="email" type="email" value="{{ old('email',$data->email) }}"  class="form-control @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new email...">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" disabled name="phone" type="number" value="{{ old('phone',$data->phone) }}"  class="form-control @error('phone') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new phone...">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Gender</label>
                                        <select name="gender" disabled class="form-control @error('gender') is-invalid @enderror" >
                                            <option value="">Choose Gender...</option>
                                            <option value="male" @if($data->gender == 'male') selected @endif>Male</option>
                                            <option value="female" @if($data->gender == 'female')selected @endif>Female</option>
                                            @error('gender')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Address</label>
                                        <textarea name="address" disabled cols="30" rows="10" class="form-control @error('address') is-invalid @enderror">{{ old('address',$data->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
