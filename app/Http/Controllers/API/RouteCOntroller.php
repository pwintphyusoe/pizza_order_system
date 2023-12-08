<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteCOntroller extends Controller
{
    //api user List
    public function userList(){
        $user = User::get();
        return response()->json($user,200);
    }

    //product category list
    public function productCategoryList(){
        $product = Product::get();
        $category = Category::get();

        $data = [
            'product' => $product,
            'category' => $category
        ];

        return response()->json($data,200);
    }

    //order list
    public function orderList(){
        $orderList = OrderList::select('order_lists.*','users.name as user_name','products.name as product_name')
                                ->leftJoin('users','users.id','order_lists.user_id')
                                ->leftJoin('products','products.id','order_lists.product_id')
                                ->get();

        return response()->json($orderList,200);
    }

    //order
    public function order(){
        $order = Order::select('orders.*','users.name as user_name')
                    ->leftJoin('users','users.id','orders.user_id')
                    ->get();
        return response()->json($order,200);
    }

    //category create
    public function  categoryCreate(Request $request){
        // dd($request->header('name'))
        // dd($request->all());
        $data = [
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        $response = Category::create($data);
        return response()->json($response,200);

    }

    //create contact
    public function createContact(Request $request){
        $data = $this->getContactData($request);
        $response = Contact::create($data);
        return response()->json($response,200);
    }

    //delete category with post
    public function deleteCategory(Request $request){
        $data = Category::where('id',$request->category_id)->first();

        if(isset($data)){
            Category::where('id',$request->category_id)->delete();
            return response()->json(['message' => 'delete success','data' => $data],200);
        }

        return response()->json(['message' => 'There is no category'],200);
    }

    //delete category with get
    public function deleteCategoryData($id){
        $data = Category::where('id',$id)->first();

        if(isset($data)){
            Category::where('id',$id)->delete();
            return response()->json(['message' => 'delete success','data' => $data],200);
        }
        return response()->json(['message' => 'there is no category'],200);
    }

    // category list
    public function categoryList(){
        $category = Category::get();
        return response()->json($category,200);
    }

    // each category list
    public function categoryListwithId($id){
        $data = Category::where('id',$id)->first();

        if(isset($data)){
            return response()->json(['status' => true , 'category' => $data],200);
        }

        return response()->json(['status' => false , 'category' => 'there is no category here'],200);
    }

    //category update
    public function categoryUpdate(Request $request){
        // dd($request->all());
        $category = Category::where('id',$request->category_id)->first();
        if(isset($category)){
            $updateData = $this->updateCategory($request);
            Category::where('id',$request->category_id)->update($updateData);
            return response()->json(['status' => true, 'updateCategory' => $updateData],200);
        }
        return response()->json(['status' => false,'category' => 'There is no category for update...'],200);

    }

    //get contact data
    private function getContactData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }

    //update category
    private function updateCategory($request){
        return [
            'name' => $request->category_name,
            'updated_at' => Carbon::now()
        ];
    }
}
