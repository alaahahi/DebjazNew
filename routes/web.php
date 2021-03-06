<?php

use Illuminate\Support\Facades\Route;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\CheckoutController;
//use Livewire\ShowProduct;

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

// Open Routes
Route::get('/', 'FrontendController@index')->name('welcome');

Route::get('on-sale', 'FrontendController@onSale')->name('on-sale');
Route::get('/category/{slug}', 'FrontendController@category')->name('frontendCategory');
Route::get('/categories', 'FrontendController@categories')->name('frontendCategories');
Route::get('/sub-category/{slug}', 'FrontendController@subcategory')->name('subcategory');
Route::get('/product/{slug}', 'FrontendController@show')->name('single-product');
Route::post('/contact', 'FrontendController@contactStore')->name('store-contact');
Route::get('/about', 'FrontendController@aboutUs')->name('about-us');
Route::get('/contact', 'FrontendController@contact')->name('contact-us');
Route::get('/terms-and-conditions', 'FrontendController@terms')->name('terms.conditions');
Route::get('/privacy-policy', 'FrontendController@privacy')->name('privacy.policy');
Route::get('my-print/{id}/{order_id?}', 'Admin\ProductController@print')->name('my-print.printCards');

Route::get('livewire/ShowPost','FrontendController@index_livewire');
//Route::get('/show',[App\Http\Livewire\ShowProduct::class])->name('show');
//Route::get('ShowPosts',ShowProduct::class);


Route::resource('cart', 'CartController');
Route::resource('wishlist', 'WishlistController');
Route::post('coupons', 'CouponsController@store')->name('coupons.store');
Route::delete('coupons', 'CouponsController@destroy')->name('coupons.destroy');

//Paypal Routes
Route::get('paypal-checkout/{order}', 'PaypalController@paypalCheckout')->name('paypal.checkout');
Route::get('paypal-success', 'PaypalController@paypalSuccess')->name('paypal.success');
Route::get('paypal-cancel', 'PaypalController@paypalCancel')->name('paypal.cancel');


// Authenticated users routes
Route::middleware('auth')->group(function () {
	Route::get('my-orders', 'ProfileController@index')->name('my-orders.index');
	Route::get('my-profile', 'ProfileController@edit')->name('my-profile.edit');
	Route::post('my-profile', 'ProfileController@update')->name('my-profile.store');
	Route::get('my-orders/{id}', 'ProfileController@show')->name('my-profile.show');
	Route::resource('orders', 'OrderController');
	Route::resource('checkout', 'CheckoutController');

});
	Route::get('stripe', [CheckoutController::class, 'stripe']);
	Route::post('stripe', [CheckoutController::class, 'stripePost'])->name('stripe.post');
// Login & Register Routes
Auth::routes();
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

// Adminstrator Routes
Route::middleware(['auth', 'admin'])->group(function () {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::resource('admin/users', 'Admin\UserController');
	Route::resource('admin/slides', 'Admin\SlideController');
	Route::resource('admin/categories', 'Admin\CategoryController');
	Route::resource('admin/subcategories', 'Admin\SubCategoryController');
	Route::delete('admin/products/photo/{id}', 'Admin\ProductController@destroyImage')->name('destroyImage');
	Route::post('admin/products/print/{id}', 'Admin\ProductController@print')->name('printCards');
	Route::delete('admin/products/attribute/{id}', 'Admin\ProductController@destroyAttribute')->name('destroyAttribute');
	Route::resource('admin/coupon', 'Admin\CouponController');
	Route::resource('admin/products', 'Admin\ProductController');
	Route::resource('admin/system-settings', 'Admin\SystemSettingsController');
	Route::get('/admin/contact', 'Admin\MessageController@index')->name('contactMessages');
	Route::get('/admin/contact/{id}', 'Admin\MessageController@show')->name('contact.show');
	Route::get('/admin/orders', 'Admin\OrderController@index')->name('orders.index');
	Route::get('/admin/orders/{id}', 'Admin\OrderController@show')->name('orders.show');
	Route::patch('/admin/orders/{id}', 'Admin\OrderController@update')->name('orders.update');
	Route::resource('admin/about', 'Admin\AboutController');
	Route::resource('admin/terms', 'Admin\TermsController');
	Route::resource('admin/privacy', 'Admin\PrivacyPolicyController');
	Route::resource('admin/social-links', 'Admin\SocialLinkController');
});


Route::get('setlocale/{locale}', function ($locale) {
	  session(['locale' => $locale]);
	return redirect()->back();
  });

  Route::get('setcurrency/{currency}', function ($currency) {
	session(['currency' => $currency]);
  return redirect()->back();
});


