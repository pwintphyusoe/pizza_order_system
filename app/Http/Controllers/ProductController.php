<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //product list
    public function list(){
        $pizzas = Product::select('products.*','categories.name as category_name')
                    ->when(request('key'),function($query){
                    $query->where('products.name','like','%'.request('key').'%');
                    })
                    ->leftJoin('categories','products.category_id','categories.id')
                    ->orderBy('products.created_at','desc')
                    ->paginate(4);
        $pizzas->appends(request()->all());
        return view('admin.products.pizaList',compact('pizzas'));
    }

    //create Piza Page
    public function createPiza(){
        $categories = Category::select('id','name')->get();
        // dd($categories->toArray());
        return view('admin.products.create',compact('categories'));
    }

    //create piza
    public function create(Request $request){
        $this->productValidationCheck($request,"create");
        $data = $this->requestProductInfo($request);

        $fileName = uniqid().$request->file('pizaImage')->getClientOriginalName();
        $request->file('pizaImage')->storeAs('public',$fileName);
        $data['image'] = $fileName;

        Product::create($data);
        return redirect()->route('products#list');
    }

    //delete pizza list
    public function delete($id){
        Product::where('id',$id)->delete();
        return redirect()->route('products#list')->with(['deleteSuccess' => 'Product Delete Success...']);
    }

    //edit pizza
    public function edit($id){
        $pizza = Product::select('products.*','categories.name as category_name')
                ->leftJoin('categories','products.category_id','categories.id')
                ->where('products.id',$id)->first();
        return view('admin.products.editPiza',compact('pizza'));
    }

    //update pizza page
    public function updatePage($id){
        $pizza = Product::where('id',$id)->first();
        $category = Category::get();
        return view('admin.products.updatePizza',compact('pizza','category'));
    }

    //update data
    public function update(Request $request){
        $this->productValidationCheck($request,"update");
        $data = $this->requestProductInfo($request);

        if($request->hasFile('pizaImage')){
            $oldImage = Product::where('id',$request->pizzaId)->first();
            $oldImage = $oldImage->image;


            Storage::delete('public/'.$oldImage);


            $fileName = uniqid().$request->file('pizaImage')->getClientOriginalName();
            $request->file('pizaImage')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        Product::where('id',$request->pizzaId)->update($data);
        return redirect()->route('products#list');

    }

    //request product Info
    private function requestProductInfo($request){
        return [
            'category_id' => $request->pizaCategory,
            'name' => $request->pizaName,
            'description' => $request->pizaDescription,
            'price' => $request->pizaPrice,
            'waiting_time' => $request->pizaWaitingTime
        ];
    }

    //product validation check
    private function productValidationCheck($request,$action){

        $validationRules = [
            'pizaName' => 'required|min:4|unique:products,name,'.$request->pizzaId,
            'pizaCategory' => 'required',
            'pizaDescription' => 'required|min:10',
            'pizaPrice' => 'required',
            'pizaWaitingTime' => 'required'
        ];

        $validationRules['pizaImage'] = $action == 'create' ? 'required|mimes:jpg,jpeg,png,webp|file' : 'mimes:jpg,jpeg,png,webp|file';
        Validator::make($request->all(),$validationRules)->validate();
    }
}
