@extends('admin.layouts.master')

@section('title','Category List')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->

                <div class="row">
                    <div class="col-4">
                        <div class="card p-3">
                            <h3>Order Details</h3>
                            <small class="text-warning">Delivery fee included!</small>
                            <table class="mt-2">
                                <tr>
                                    <td><i class="fa-solid fa-user me-2"></i>Name</td>
                                    <td>{{ strtoupper($orderList[0]->user_name)}}</td>
                                </tr>
                                <tr>
                                    <td><i class="fa-solid fa-barcode me-2"></i>Order Code</td>
                                    <td>{{ strtoupper($orderList[0]->order_code)}}</td>
                                </tr>
                                <tr>
                                    <td><i class="fa-regular fa-calendar-days me-2"></i>Order Date</td>
                                    <td>{{ strtoupper($orderList[0]->updated_at->format('F-d-Y'))}}</td>
                                </tr>
                                <tr>
                                    <td><i class="fa-solid fa-money-bills me-2"></i>Total</td>
                                    <td>{{ $order->total_price }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Order Date</th>
                                <th>qty</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach($orderList as $o)
                                <tr>
                                    <td>{{ $o->id }}</td>
                                    <td class="col-2"><img src="{{ asset('storage/'.$o->product_image) }}" alt="" class="img-thumbnail shadow-sm"></td>
                                    <td>{{ $o->product_name }}</td>
                                    <td>{{ $o->created_at->format('F-d-Y') }}</td>
                                    <td>{{ $o->qty }}</td>
                                    <td>{{ $o->total }}</td>
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
