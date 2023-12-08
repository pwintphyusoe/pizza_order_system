<?php

use App\Http\Controllers\API\RouteCOntroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// GET
Route::get('user/list',[RouteCOntroller::class,'userList']);
Route::get('product/category/list',[RouteCOntroller::class,'productCategoryList']);
Route::get('order/list',[RouteCOntroller::class,'orderList']);
Route::get('order',[RouteCOntroller::class,'order']);

//POST
Route::post('category/create',[RouteCOntroller::class,'categoryCreate']); //Create
Route::post('create/contact',[RouteCOntroller::class,'createContact']);

Route::post('delete/category',[RouteCOntroller::class,'deleteCategory']);
Route::get('delete/Category/{id}',[RouteCOntroller::class,'deleteCategoryData']); // Delete

Route::get('category/list',[RouteCOntroller::class,'categoryList']);
Route::get('category/list/{id}',[RouteCOntroller::class,'categoryListwithId']); //Read

Route::post('category/update',[RouteCOntroller::class,'categoryUpdate']); //Update


// localhost:8000/api/products/list (Get)

// localhost:8000/api/user/list (Get)

/*

create category
localhost:8000/api/category/create (POST)

body {
    name : 'category name'
}

key => category_id , category_name

*/
