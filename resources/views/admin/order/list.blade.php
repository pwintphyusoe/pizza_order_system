@extends('admin.layouts.master')

@section('title','Category List')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->

                <div class="row mb-3 p-3 text-center">
                    <div class="col-1 bg-white shadow-sm">
                        <h3><i class="fa-solid fa-database"></i> {{ count($order) }} </h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <h4 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span></h4>
                    </div>
                    <div class="col-3 offset-6 mb-3">
                        <form action="{{ route('order#list')}}" method="get">
                            <div class="d-flex">
                                <input type="text" class="form-control" name="key" placeholder="Search..." value="{{ request('key') }}">
                                <button class="btn btn-dark text-white">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <form action="{{ route('order#changeStatus')}}" method="get">
                    <div class="input-group mb-3 col-5">
                        <label class="mt-2 me-3">Order Status</label>
                        <select name="orderStatus" class="form-select">
                            <option value="">All</option>
                            <option value="0" @if(request('orderStatus') == '0') selected @endif>Pending</option>
                            <option value="1" @if(request('orderStatus') == '1') selected @endif>Success</option>
                            <option value="2" @if(request('orderStatus') == '2') selected @endif>Reject</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-dark text-white">Search</button>
                    </div>
                </form>



                <div class="table-responsive table-responsive-data2 mt-3">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>User Id</th>
                                <th>User Name</th>
                                <th>Order Date</th>
                                <th>Order Code</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach($order as $o)
                            <tr>
                                <input type="hidden" class="orderId" value="{{ $o->id }}">
                                <td>{{ $o->user_id }} </td>
                                <td>{{ $o->user_name }}</td>
                                <td>{{ $o->created_at->format('F-d-Y') }}</td>
                                <td>
                                    <a href="{{ route('order#listInfo',$o->order_code) }}" class="text-decoration-none">
                                        {{ $o->order_code }}
                                    </a>
                                </td>
                                <td>{{ $o->total_price }}</td>
                                <td>
                                    <select name="status" class="form-control statusChange" id="statusChange">
                                        <option value="0" @if($o->status == 0) selected @endif>Pending</option>
                                        <option value="1" @if($o->status == 1) selected @endif >Accept</option>
                                        <option value="2" @if($o->status == 2) selected @endif>Reject</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

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
        // $('#orderStatus').change(function(){
        //     $status = $('#orderStatus').val();
        //     // console.log($status);
        //     $.ajax({
        //         type : 'get',
        //         url : 'http://127.0.0.1:8000/order/ajax/status',
        //         data : {
        //             'status' : $status
        //         },
        //         dataType : 'json',
        //         success : function(response){
        //             $list = '';
        //             for($i=0;$i<response.length;$i++){

        //                 $month = ['January','Frbruary','March','April','May','June','July','August','September','October','November','December'];
        //                 // console.log(response[$i].created_at);
        //                 $dbDate = new Date(response[$i].created_at);
        //                 $finalDate = $month[$dbDate.getMonth()]+ "-" + $dbDate.getDate() + "-" +$dbDate.getFullYear();

        //                 if(response[$i].status == 0){
        //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                         <option value="0" selected>Pending</option>
        //                         <option value="1">Accept</option>
        //                         <option value="2">Reject</option>
        //                     </select>
        //                     `;
        //                 }
        //                 else if(response[$i].status == 1){
        //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                         <option value="0">Pending</option>
        //                         <option value="1" selected>Accept</option>
        //                         <option value="2">Reject</option>
        //                     </select>
        //                     `;
        //                 }
        //                 else if(response[$i].status == 2){
        //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                         <option value="0">Pending</option>
        //                         <option value="1">Accept</option>
        //                         <option value="2" selected>Reject</option>
        //                     </select>
        //                     `;
        //                 }

        //                 $list += `
        //                 <tr>
        //                     <input type="hidden" id="orderId" value=${response[$i].id}>
        //                     <td>${response[$i].user_id}</td>
        //                     <td>${response[$i].user_name}</td>
        //                     <td>${$finalDate}</td>
        //                     <td>${response[$i].order_code}</td>
        //                     <td>${response[$i].total_price}</td>
        //                     <td>${$statusMessage}</td>
        //                 </tr>
        //                 `;
        //             }
        //             $('#dataList').html($list);
        //         }
        //     })
        // })

        $('.statusChange').change(function(){
            $currentStatus = $(this).val();
            $parendNode = $(this).parents("tr");
            $orderId = $parendNode.find('.orderId').val();

            console.log($currentStatus);
            $data = {
                'orderId' : $orderId,
                'status' : $currentStatus
            };
            // console.log($data);

            $.ajax({
                type : 'get',
                url : '/order/ajax/change/status' ,
                data : $data  ,
                dataType : 'json',
            })

        })
    })
</script>
@endsection
