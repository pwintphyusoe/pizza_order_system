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
                            <h2 class="title-1">Admin List</h2>

                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <a href="{{ route('category#createPage')}}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>add category
                            </button>
                        </a>
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            CSV download
                        </button>
                    </div>
                </div>

                @if(session('deleteSuccess'))
                <div class="col-5 offset-7">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif

                <div class="row mb-3 p-3 text-center">
                    <div class="col-1 bg-white shadow-sm">
                        <h3><i class="fa-solid fa-database me-2"></i>{{ $admin->total() }}  </h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <h4 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span></h4>
                    </div>
                    <div class="col-3 offset-6 mb-3">
                        <form action="{{ route('admin#list')}}" method="get">
                            <div class="d-flex">
                                <input type="text" class="form-control" name="key" placeholder="Search..." value="{{ request('key') }}">
                                <button class="btn btn-dark text-white">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admin as $a)
                                <tr class="tr-shadow my-2">
                                    <td class="col-2">
                                        @if($a->image == null)
                                            @if($a->gender == 'male')
                                                <img src="{{ asset('image/male_default_user.jpg')}}" class="img-thumbnail shadow-sm" alt="">
                                            @else
                                                <img src="{{ asset('image/female_default_user.jpg')}}" class="img-thumbnail shadow-sm" alt="">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/'.$a->image)}} " class="img-thumbnail shadow-sm" alt="">
                                        @endif
                                    </td>
                                    <td>{{ $a->name }}</td>
                                    <td>{{ $a->email }}</td>
                                    <td>{{ $a->gender }}</td>
                                    <td>{{ $a->phone }}</td>
                                    <td>{{ $a->address }}</td>
                                    <td>
                                        <div class="table-data-feature">
                                            @if( Auth::user()->id == $a->id)

                                            @else
                                            <input type="hidden" value="{{ $a->id }}" id="adminId">
                                            <select name="role" class="form-control roleChange me-2">
                                                <option value="admin" selected>Admin</option>
                                                <option value="user">User</option>
                                            </select>

                                                {{-- <a href="{{ route('admin#changeRolePage',$a->id) }}">
                                                    <button class="item me-2" data-toggle="tooltip" data-placement="top" title="change role">
                                                        <i class="fa-solid fa-bolt"></i>
                                                    </button>
                                                </a> --}}
                                                <a href="{{ route('admin#delete',$a->id)}}">
                                                    <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $admin->links() }}
                        {{-- {{ $categories->appends(request()->query())->links()}} --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection

@section('scriptSection')
    <script>
        $(document).ready(function(){
            $('.roleChange').change(function(){
                $currentStatus = $(this).val();
                // console.log($currentStatus);

                $parentNode = $(this).parents("tr");
                $adminId = $parentNode.find('#adminId').val();

                $role = {
                    'adminId' : $adminId,
                    'role' : $currentStatus
                }

                $.ajax({
                    type : 'get',
                    url : '/admin/change/rolewith/ajax',
                    data : $role,
                    dataType : 'json'
                })
                location.reload();
            })
        })
    </script>
@endsection
