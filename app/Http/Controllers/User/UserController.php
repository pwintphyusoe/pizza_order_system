<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //user home page
    public function home(){
        $pizza = Product::orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart','history'));
    }

    // user List
    public function userList(){
        $users = User::where('role','user')
                        ->when(request('key'),function($query){
                            $query->where('name','like','%'.request('key').'%');
                        })
                        ->paginate('3');
        return view('admin.user.list',compact('users'));
    }

    //user change role
    public function userChangeRole(Request $request){
        User::where('id',$request->userId)->update([
            'role' => $request->status
        ]);
        logger($request->all());
    }

    //changePassword Page
    public function changePasswordPage(){
        return view('user.account.changePassword');
    }

    //change Password
    public function changePassword(Request $request){
        $this->passwordValidationCheck($request);

        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $dbHashValue = $user->password;

        if(Hash::check($request->oldPassword,$dbHashValue)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];

            User::where('id',Auth::user()->id)->update($data);
            return back()->with(['changeSuccess'=>'Password Change Successful']);
        }
        return back()->with(['notmatch' => 'Password not Match,Try Again!']);
    }

    //account info
    public function infoPage(){
        return view('user.account.accountInfo');
    }

    //update account
    public function updateAccount(Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        //for image
        if($request->hasFile('image')){
            $oldImage = User::where('id',Auth::user()->id)->first();
            $oldImage = $oldImage->image;

            if($oldImage != null){
                Storage::delete('public/'.$oldImage);
            }

            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        User::where('id',Auth::user()->id)->update($data);
        return back()->with(['updateSuccess'=>'Account Update Successful']);
    }

    //Pizza Filter
    public function filter($categoryId){
        $pizza = Product::where('category_id',$categoryId)->orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart','history'));
    }

    //Pizza Detail
    public function pizzaDetails($id){
        $pizza = Product::where('id',$id)->first();
        $pizzaList = Product::get();
        return view('user.main.details',compact('pizza','pizzaList'));
    }

    //Cart List
    public function cartList(){
        $cartList = Cart::select('carts.*','products.name as pizza_name','products.price as pizza_price','products.image as pizza_image')
                        ->leftJoin('products','products.id','carts.product_id')
                        ->where('user_id',Auth::user()->id)->get();
        // dd($cartList->toArray());
        $totalPrice = 0;
        foreach($cartList as $c){
            $totalPrice += $c->pizza_price*$c->qty;
        }
        // dd($totalPrice);
        return view('user.main.cart',compact('cartList','totalPrice'));
    }

    //History
    public function history(Request $request){
        $order = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate('3');
        return view('user.main.history',compact('order'));
    }

    //user contact page
    public function userContactPage(){
        return view('user.contact.contact');
    }

    //user contact info
    public function userContactInfo(Request $request){
        $info = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ];
        // dd($info);
        Contact::create($info);
        return redirect()->route('user#home')->with(['contactSuccess' => 'Your information has been sent,Thank you for your feedback.']);
    }

    //user info delete
    public function userInfoDelete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess' => 'Deleted User Account Successful!']);
    }

    //account validation check
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'image' => 'mimes:jpg,jpeg,png,webp|file'
        ])->validate();
    }

    //get User Data
    private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address
        ];
    }

    //check validation
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required|same:newPassword'
        ])->validate();
    }
}
