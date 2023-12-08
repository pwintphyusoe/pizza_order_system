@extends('admin.layouts.master')

@section('title','User List')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->

                <div class="row mb-3 p-3 text-center">
                    <div class="col-1 bg-white shadow-sm">
                        <h3><i class="fa-solid fa-database"></i> {{ $users->total()}} </h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <h4 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span></h4>
                    </div>
                    <div class="col-3 offset-6 mb-3">
                        <form action="{{ route('admin#userList')}}" method="get">
                            <div class="d-flex">
                                <input type="text" class="form-control" name="key" placeholder="Search..." value="{{ request('key') }}">
                                <button class="btn btn-dark text-white">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
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

                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Gender</th>
                                <th>Role</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach ($users as $user)
                                <tr>
                                    <input type="hidden" name="userId" class="userId" value="{{ $user->id }}">
                                    <td class="col-2">
                                        @if($user->image == null)
                                            @if($user->gender == 'male')
                                                <img src="{{ asset('image/male_default_user.jpg')}}" class="img-thumbnails shadow-sm">
                                            @else
                                                <img src="{{ asset('image/female_default_user.jpg')}}" class="img-thumbnails shadow-sm">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/'.$user->image) }}" alt="">
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->address}}</td>
                                    <td>{{ $user->gender}}</td>
                                    <td>
                                        <select name="role" class="form-control statusChange">
                                            <option value="user" @if($user->role == 'user') selected @endif>User</option>
                                            <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="{{ route('user#editPage',$user->id)}}"><i class="fa-solid fa-user-pen fs-5 me-2"></i></a>
                                        <a href="{{ route('user#infoDelete',$user->id) }}"><i class="fa-solid fa-trash-can fs-5 text-danger"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>

                </div>

                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection

@section('scriptSection')
<script>
    $(document).ready(function(){
        $('.statusChange').change(function(){
            $currentStatus = $(this).val();
            $parentNode = $(this).parents('tr');
            $userId = $parentNode.find('.userId').val();

            $data = {
                'userId' : $userId,
                'status' : $currentStatus
            }

            $.ajax({
                type : 'get',
                url : '/user/ajax/change/role',
                data : $data,
                dataType : 'json'
            })
            location.reload();
        })
    })
</script>
@endsection
