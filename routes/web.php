<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index']);
Route::get('contact', [HomeController::class,'contact']);
Route::post('contact', [HomeController::class,'send'])->name('contact.send');
Route::get('about', [HomeController::class,'about']);
Route::get('/verify', [VerificationController::class, 'index'])->name('verify');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verify');
Route::get('/create-verification-code', [UserController::class, 'createVerificationCode'])->name('createVerificationCode');

Route::get('/province', [ProvinceController::class, 'provinceDetail'])->name('province.show');
Route::get('/hotel/{id}', [HotelController::class, 'roomInHotel'])->name('hotel.show');

Route::get('/admin/login', [AdminController::class, 'adminLoginForm']);
Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/employee/login', [EmployeeController::class, 'loginForm']);
Route::post('/employee/login', [EmployeeController::class, 'login']);
Route::get('/employee/logout', [EmployeeController::class, 'logout']);

Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/admin/logout', [AdminController::class,'logout']);

Route::group(['middleware' => 'checklogin'], function () {
    Route::get('/login', [UserController::class, 'loginForm']);
    Route::post('/login', [UserController::class, 'login']);

    Route::get('/register', [UserController::class, 'registerForm'])->name('register');
    Route::post('/register', [UserController::class, 'register']);
});
Route::group(['middleware' => 'userauth'], function () {
    Route::get('/cart', [CartController::class, 'show'])->name('cart');
    Route::post('/add-cart/{id}', [CartController::class, 'addCart'])->name('cart.add');
    Route::post('/delete-cart/{id}', [CartController::class, 'deleteRoom'])->name('cart.delete');
    Route::get('/clear-cart', [CartController::class, 'clearCart']);
    Route::post('/booking/{id}', [BookingController::class, 'booking'])->name('booking');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/{id}', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [BookingController::class, 'placeOrder'])->name('place_order');
    Route::get('/order', [OrderController::class, 'index']);
    Route::get('/user/success', [BookingController::class,'success'])->name('user.success');
    Route::get('/user/cancel', [BookingController::class,'cancel'])->name('user.cancel');
    Route::get('/order_detail/{id}', [OrderController::class, 'detail'])->name('booking.detail');
    Route::post('/order/add-review/{id}', [ReviewController::class, 'add'])->name('review.add');
    Route::delete('/order/delete-review/{id}', [ReviewController::class, 'delete'])->name('review.delete');
    Route::get('/setting', [UserController::class,'setting']);
    Route::post('/setting', [UserController::class,'update'])->name('user.update');
    Route::post('/change-password', [UserController::class,'changePassword'])->name('password.change');
});


Route::get('/room/{id}', [RoomController::class, 'roomDetail'])->name('room.detail');
Route::get('/room/{id}/search-review', [RoomController::class, 'roomDetail'])->name('review.search');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/', [DashBoardController::class, 'admin']);
    Route::get('/admin/hotel', [HotelController::class, 'admin']);
    Route::get('/admin/hotel/search', [HotelController::class, 'admin'])->name('hotel.search');
    Route::post('/hotel/create', [HotelController::class, 'create'])->name('hotel.create');
    Route::post('/hotel/update/{id}', [HotelController::class, 'update'])->name('hotel.update');
    Route::delete('/hotels/delete/{id}', [HotelController::class, 'delete'])->name('hotels.delete');

    Route::get('/admin/contact', [ContactController::class, 'get']);

    Route::get('/admin/rooms', [RoomController::class, 'index']);

    Route::get('/admin/user', [UserController::class, 'admin']);
    Route::get('/admin/user/search', [UserController::class, 'admin'])->name('user.search');
    Route::delete('admin/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');

    Route::get('/admin/employee', [EmployeeController::class, 'admin']);
    Route::get('/admin/admin', [AdminController::class, 'admin']);
    Route::post('/admin/create-admin', [AdminController::class, 'create'])->name('admin.create');

    Route::get('/admin/booking', [BookingController::class, 'admin']);
    Route::get('/admin/banner', [BannerController::class,'store']);
    Route::post('/admin/banner-create', [BannerController::class,'create'])->name('banner.create');
    Route::delete('/admin/banner-delete/{id}', [BannerController::class,'delete'])->name('banner.delete');
});

Route::group(['middleware' => 'employee'], function () {
    Route::get('/hotel/', [DashBoardController::class,'index']);
    Route::get('/employee/all-booking', [BookingController::class, 'manage'])->name('booking.mamage');
    Route::get('/employee/booking/manage/{id}', [BookingController::class, 'detail'])->name('manage.detail');
    Route::post('/employee/booking/update/{id}', [BookingController::class, 'update'])->name('booking.update');
    Route::get('/employee/offline-booking', [BookingController::class, 'offline']);
    Route::get('/employee/offline-booking/{id}', [BookingController::class, 'offlineBooking'])->name('booking.offline');
    Route::delete('/order/delete/{id}', [BookingController::class, 'delete'])->name('booking.delete');
    Route::get('/hotel/get-notifications', [BookingController::class,'getNotifications']);

    Route::group(['middleware' => 'managercheck'], function () {
        Route::get('/employee/room', [EmployeeController::class, 'index']);
        Route::post('/employee/room/create', [RoomController::class, 'create'])->name('room.create');
        Route::delete('/employee/delete-room/{id}', [RoomController::class, 'delete'])->name('room.delete');
        Route::post('/employee/room/update/{id}', [RoomController::class, 'update'])->name('room.update');
        Route::delete('/employee/room/delete/amenity/{id}', [RoomController::class, 'deleteAmenity'])->name('amenity.delete');
        Route::post('/employee/room/add/amenity/{id}', [RoomController::class, 'addAmenity'])->name('amenity.add');
        Route::post('/employee/room/add-image', [RoomController::class, 'addImage'])->name('image.add');
        Route::delete('/employee/room/delete-image/{id}', [RoomController::class, 'deleteImage'])->name('image.delete');
        Route::get('/employee/get', [EmployeeController::class, 'getEmployee']);
        Route::post('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('/employee/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('/employee/delete/{id}', [EmployeeController::class, 'delete'])->name('employee.delete');
        Route::get('/employee/review', [BookingController::class, 'review']);
    });
});
