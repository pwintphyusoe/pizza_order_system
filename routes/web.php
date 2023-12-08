<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;

// login , Register
Route::middleware(['admin_auth'])->group(function(){
    Route::redirect('/','loginPage');
    Route::get('loginPage',[AuthController::class,'loginPage'])->name('auth#loginPage');
    Route::get('registerPage',[AuthController::class,'registerPage'])->name('auth#registerPage');
});

Route::middleware(['auth'])->group(function () {
    //dashboard
    Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');

    //admin
    //middleware
    // Route::group(['middleware' => 'admin_auth'],function(){
    // }); OR

    Route::middleware(['admin_auth'])->group(function(){
         //Category
         Route::prefix('category')->group(function(){
            Route::get('list',[CategoryController::class,'list'])->name('category#list');
            Route::get('create/page',[CategoryController::class,'createPage'])->name('category#createPage');
            Route::post('create',[CategoryController::class,'create'])->name('category#create');
            Route::get('delete/{id}',[CategoryController::class,'delete'])->name('categoty#delete');
            Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category#edit');
            Route::post('update',[CategoryController::class,'update'])->name('category#update');
        });

        // admin account
        Route::prefix('admin')->group(function(){
            //password
            Route::get('password/changePage',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('change/password',[AdminController::class,'changePassword'])->name('admin#changepassword');

            //detail
            Route::get('details',[AdminController::class,'details'])->name('admin#details');
            Route::get('edit',[AdminController::class,'edit'])->name('admin#edit');
            Route::post('update/{id}',[AdminController::class,'update'])->name('admin#update');
            Route::get('list',[AdminController::class,'list'])->name('admin#list');
            Route::get('delete/{id}',[AdminController::class,'delete'])->name('admin#delete');
            Route::get('change/rolePage/{id}',[AdminController::class,'changeRolePage'])->name('admin#changeRolePage');
            Route::post('change/{id}',[AdminController::class,'change'])->name('admin#change');
            Route::get('change/rolewith/ajax',[AdminController::class,'changeRole'])->name('admin#changeRoleWithAjax');
        });

        //products
        Route::prefix('products')->group(function(){
            Route::get('list',[ProductController::class,'list'])->name('products#list');
            Route::get('createPage',[ProductController::class,'createPiza'])->name('products#createPage');
            Route::post('create',[ProductController::class,'create'])->name('products#create');
            Route::get('delete/{id}',[ProductController::class,'delete'])->name('products#delete');
            Route::get('edit/{id}',[ProductController::class,'edit'])->name('products#edit');
            Route::get('updatepage/{id}',[ProductController::class,'updatePage'])->name('products#updatePage');
            Route::post('update',[ProductController::class,'update'])->name('products#update');
        });

        //order
        Route::prefix('order')->group(function(){
            Route::get('list',[OrderController::class,'list'])->name('order#list');
            Route::get('change/status',[OrderController::class,'changeStatus'])->name('order#changeStatus');
            Route::get('ajax/change/status',[OrderController::class,'ajaxChangeStatus'])->name('order#ajaxChangeStatus');
            Route::get('list/info/{orderCode}',[OrderController::class,'listInfo'])->name('order#listInfo');
        });

        //user lists
        Route::prefix('user')->group(function(){
            Route::get('list',[UserController::class,'userList'])->name('admin#userList');
            Route::get('ajax/change/role',[UserController::class,'userChangeRole'])->name('user#ajaxChangeRole');
            Route::get('info/delete/{id}',[UserController::class,'userInfoDelete'])->name('user#infoDelete');
            Route::get('contact/list/page',[AdminController::class,'userContactPage'])->name('user#contactListPage');
            Route::get('contact/delete/{id}',[AdminController::class,'userContactDelete'])->name('user#contactDelete');
            Route::get('edit/page/{id}',[AdminController::class,'userEditPage'])->name('user#editPage');
            Route::post('update/info/{id}',[AdminController::class,'userUpdateInfo'])->name('user#updateInfo');
        });
    });

    //user
    //home
    Route::group(['prefix' => 'user','middleware' => 'user_auth'],function(){
        Route::get('/home',[UserController::class,'home'])->name('user#home');
        Route::get('filter/{id}',[UserController::class,'filter'])->name('user#filter');
        Route::get('history',[UserCOntroller::class,'history'])->name('user#history');

        //pizza detail list
        Route::prefix('pizza')->group(function(){
            Route::get('detail/{id}',[UserController::class,'pizzaDetails'])->name('user#pizzaDetails');
        });

        //cart list
        Route::prefix('cart')->group(function(){
            Route::get('list',[UserController::class,'cartList'])->name('user#cartList');
        });

        //password
        Route::prefix('user')->group(function(){
            Route::get('changePasswordPage',[UserController::class,'changePasswordPage'])->name('user#changePasswordPage');
            Route::post('change',[UserController::class,'changePassword'])->name('user#changePassword');
        });

        //account
        Route::prefix('user')->group(function(){
            Route::get('infoPage',[UserController::class,'infoPage'])->name('user#infoPage');
            Route::post('updateAccount',[UserController::class,'updateAccount'])->name('user#updateAccount');
            Route::get('contact/page',[UserController::class,'userContactPage'])->name('user#contactPage');
            Route::post('contact/info',[UserController::class,'userContactInfo'])->name('user#contactInfo');
        });

        //Ajax
        Route::prefix('ajax')->group(function(){
            Route::get('pizza/list',[AjaxController::class,'pizzaList'])->name('ajax#pizzaList');
            Route::get('addtoCart',[AjaxController::class,'addToCart'])->name('ajax#addToCart');
            Route::get('order',[AjaxController::class,'order'])->name('ajax#order');
            Route::get('clear/cart',[AjaxController::class,'clearCart'])->name('ajax#clearCart');
            Route::get('clear/currentProduct',[AjaxController::class,'clearCurrentProduct'])->name('ajax#clearCurrentProduct');
            Route::get('increase/view/count',[AjaxController::class,'increaseViewCount'])->name('ajax#increaseViewCount');
        });

    });
});




/*
    Project Cache
    1.php artisan config:clear
    2.php artisan cache:clear
    3.php artisan config:cache

    Browser Cache
    setting > history > clear history > Clear Browsing Data > Browsing History & Cache Image and file
    inspect > right click reload > Empty Cache and Hard Reload
    > Application > cookie > clear

*/
