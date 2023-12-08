<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //order list
    public function list(){
        $order = Order::select('orders.*','users.name as user_name')
                    ->leftJoin('users','users.id','orders.user_id')
                    ->when(request('key'),function($query){
                        $query->where('users.name','like','%'.request('key').'%');
                    })
                    ->orderBy('orders.created_at','desc')
                    ->get();

        // dd($order->toArray());
        return view('admin.order.list',compact('order'));
    }

    //sort with ajax status
    public function changeStatus(Request $request){
        // logger($request->all());
        // $request->status == null ? '' : $request->status;
        // ->where('orders.status',$request->status)
        // dd($request->orderStatus);

        $order = Order::select('orders.*','users.name as user_name')
                ->leftJoin('users','users.id','orders.user_id')
                ->orderBy('created_at','desc');

        if($request->orderStatus == null){
            $order = $order->get();
        }
        else{
            $order = $order->where('orders.status',$request->orderStatus)->get();
        }
        // dd($order->toArray());
        return view('admin.order.list',compact('order'));
    }

    //change status
    public function ajaxChangeStatus(Request $request){
        logger($request->all());
        Order::where('id',$request->orderId)->update([
            'status'=>$request->status
        ]);

        $order = Order::select('orders.*','users.name as user_name')
                            ->leftJoin('users','users.id','orders.user_id')
                            ->orderBy('created_at','desc')
                            ->get();

        return response()->json($order,200);
    }

    //Order List Info
    public function listInfo($orderCode){
        $order = Order::where('order_code',$orderCode)->first();
        $orderList = OrderList::where('order_code',$orderCode)
                                ->select('order_lists.*','users.name as user_name','products.name as product_name','products.image as product_image')
                                ->leftJoin('users','users.id','order_lists.user_id')
                                ->leftJoin('products','products.id','order_lists.product_id')
                                ->get();

                                // dd($orderList->toArray());
        return view('admin.order.orderList',compact('orderList','order'));
    }
}
