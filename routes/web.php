<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('load-cart-data','Frontend\CartController@cartcount');


Route::get('/','Frontend\FrontendController@index');
Route::get('/e-shop/category','Frontend\FrontendController@category');
Route::get('view-category/{slug}','Frontend\FrontendController@viewcategory');
Route::get('category/{cat_slug}/{prod_slug}','Frontend\FrontendController@productview');


Route::get('product-list','Frontend\FrontendController@productlistAjax');
Route::post('searchproduct','Frontend\FrontendController@searchProduct');

Auth::routes();

Route::post('/add-to-cart','Frontend\CartController@addproduct');
Route::post('delete-cart-item','Frontend\CartController@deleteproduct');
Route::post('update-cart','Frontend\CartController@updatecart');


Route::post('/add-to-wishlist','Frontend\WishlistController@addwishlist');
Route::post('/delete-wishlist-item','Frontend\WishlistController@deletewishlist');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function(){
Route::get('cart','Frontend\CartController@viewcart');
Route::get('checkout','Frontend\CheckoutController@index');
Route::post('place-order','Frontend\CheckoutController@placeorder');
Route::get('my-order','Frontend\UserController@index');
Route::get('view-order/{id}','Frontend\UserController@view');

Route::post('add-rating','Frontend\RatingController@add');

Route::get('add-review/{product_slug}/userreview','Frontend\ReviewController@add');
Route::post('/add-review','Frontend\ReviewController@create');
Route::get('edit-review/{product_slug}/userreview','Frontend\ReviewController@edit');
Route::post('/update-review','Frontend\ReviewController@update');

Route::get('wishlist','Frontend\WishlistController@index');

});


 Route::middleware(['auth','isAdmin'])->group(function(){
    Route::get('/dashboard', 'Admin\FrontendController@index');

    Route::get('/categories', 'Admin\CategoryController@index');

    Route::get('/add-category', 'Admin\CategoryController@add');

    Route::post('/insert-category','Admin\CategoryController@insert');

    Route::get('/edit-category/{id}','Admin\CategoryController@edit');

    Route::post('/update-category/{id}','Admin\CategoryController@update');

    Route::get('/category-delete/{id}', 'Admin\CategoryController@delete');


    //Product
    Route::get('/product','Admin\ProductController@index');
    Route::get('/add-product','Admin\ProductController@add');
    Route::post('/insert-product','Admin\ProductController@insert');
    Route::get('edit-product/{id}','Admin\ProductController@edit');
    Route::post('/update-product/{id}','Admin\ProductController@update');
    Route::get('product-delete/{id}','Admin\ProductController@delete');




    Route::get('orders','Admin\OrderController@index');
    Route::get('admin/view-order/{id}','Admin\OrderController@view');
    Route::post('update-order/{id}','Admin\OrderController@updateorder');
    Route::get('order-history','Admin\OrderController@orderhistory');


    Route::get('users','Admin\DashboardController@users');
    Route::get('view-user/{id}','Admin\DashboardController@viewuser');

 });
