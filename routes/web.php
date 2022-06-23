<?php

use App\Http\Controllers\Admin\CustomerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CheckLocationController;
use App\Http\Controllers\DashboardProfileController;
use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\Admin\UpdateProfileController;
use App\Http\Controllers\UpdatePasswordUsersController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PemesananController;
use App\Http\Controllers\Admin\TrashCategoryController;
use App\Http\Controllers\Admin\TrashCustomerController;
use App\Http\Controllers\Admin\TrashKategoriController;
use App\Http\Controllers\Admin\TrashProductController;
use App\Http\Controllers\Admin\TrashTransactionController;
use App\Http\Controllers\Admin\TrashUserController;
use App\Http\Controllers\Admin\UpdatePasswordController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\DashboardOrderController;
use App\Http\Controllers\GenerateLaporanController;
use App\Http\Controllers\Pemilik\CategoryController as PemilikCategoryController;
use App\Http\Controllers\Pemilik\CustomersController;
use App\Http\Controllers\Pemilik\DashboardPemilikController;
use App\Http\Controllers\Pemilik\LaporanPemilikController;
use App\Http\Controllers\Pemilik\PemesananPemilikController;
use App\Http\Controllers\Pemilik\PemilikUserController;
use App\Http\Controllers\Pemilik\ProductsController;
use App\Http\Controllers\Pemilik\UpdatePasswordPemilikController;
use App\Http\Controllers\Pemilik\UpdateProfilePemilikController;

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

Route::get('/', [HomeController::class, 'index'])
    ->name('home');
Route::get('/register-success', [HomeController::class, 'success'])
    ->name('register-success');

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories');
Route::get('/categories/{id}', [CategoryController::class, 'detail'])
    ->name('categories-detail');

Route::get('/details/{id}', [DetailController::class, 'index'])
    ->name('detail');
Route::post('add-to-cart', [DetailController::class, 'add'])->name('detail-add');
Route::get('/success', [CartController::class, 'success'])
    ->name('success');
Route::get('/unfinish', [CartController::class, 'unfinish'])
    ->name('unfinish');
Route::get('/error', [CartController::class, 'failed'])
    ->name('failed');
Route::get('/Faq', [FaqController::class, 'index'])->name('faq');

Route::get('/auth', [CustomLoginController::class, 'index'])->name('customer.login');
Route::post('/auth', [CustomLoginController::class, 'proseslogin'])->name('customer.proseslogin');
Route::get('/register/customer', [CustomLoginController::class, 'register'])->name('customer.register');
Route::post('customer-registration', [CustomLoginController::class, 'customregister'])->name('customer.proses');

// Route::get('/auth/login', [CustomLoginController::class, 'admins'])->name('admin.login');
Route::post('/generatelaporan', [GenerateLaporanController::class, 'laporandates'])->name('generatepenjualan');
Route::get('/generateallreport', [GenerateLaporanController::class, 'alllaporan'])->name('generateallreports');
Route::post('/generatepesanan', [GenerateLaporanController::class, 'pesananrequest'])->name('generatepesanan');
Route::get('/generateallreport/pesanan', [GenerateLaporanController::class, 'pesananall'])->name('generateallpesanan');
Route::post('/generateproduk', [GenerateLaporanController::class, 'productrequest'])->name('generateproduk');
Route::get('/generateprodukall', [GenerateLaporanController::class, 'productall'])->name('generateprodukall');
Route::post('/generatecustomer', [GenerateLaporanController::class, 'customerrequest'])->name('generatecustomer');
Route::get('/generateallcustomer', [GenerateLaporanController::class, 'customerall'])->name('generateallcustomer');
// Route::post('logout', [UserController::class, 'logout'])->name('logout');
// Route::post('logout', [CustomLoginController::class, 'signout'])->name('customer.logout');
Route::post('/checkout/callback', [CheckoutController::class, 'callback'])
    ->name('midtrans-callback');

Route::group(['middleware' => ['auth:customer']], function () {
    //checkout/ keranjang customer
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout');
    Route::get('/cart', [CartController::class, 'index'])->name('detail-carts');
    Route::get('/load-cart-data', [CartController::class, 'cartcount'])->name('cart-count');
    Route::post('update-cart', [CartController::class, 'updatecart']);
    Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart-delete');

    //dashboard customer
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //update profile customer
    Route::post('/getkabupaten', [CartController::class, 'getkabupaten'])->name('getkabupaten');
    Route::get('/cities/{province_id}', [CartController::class, 'getCities']);
    Route::get('/password/edit', [UpdatePasswordUsersController::class, 'edit'])->name('password-users.edit');
    Route::put('/password/edit', [UpdatePasswordUsersController::class, 'update']);
    Route::get('/profile/edit', [DashboardProfileController::class, 'edit'])->name('profile-users.edit');
    Route::put('/profile/edit', [DashboardProfileController::class, 'update']);

    Route::post('change-profile-picture', [DashboardProfileController::class, 'updatePicture'])->name('usersUpdatePicture');

    //history/ order customer
    Route::get('/myorder', [DashboardOrderController::class, 'index'])->name('users.order');
    Route::get('myorder/{id}/edit', [DashboardOrderController::class, 'edit'])->name('user.order.detail');
    Route::put('myorder/{id}', [DashboardOrderController::class, 'update'])->name('user.order.update');
});

// Route::prefix('customer')
//     ->namespace('Customer')
//     ->middleware(['auth', 'customer'])
//     ->group(function () {
//         // Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout');
//         // Route::get('/cart', [CartController::class, 'index'])->name('detail-carts');
//         // Route::get('/load-cart-data', [CartController::class, 'cartcount'])->name('cart-count');
//         // Route::post('update-cart', [CartController::class, 'updatecart']);
//         // Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart-delete');
//         Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//         Route::get('/cities/{province_id}', [CartController::class, 'getCities']);
//         Route::get('/password/edit', [UpdatePasswordUsersController::class, 'edit'])->name('password-users.edit');
//         Route::put('/password/edit', [UpdatePasswordUsersController::class, 'update']);

//         Route::get('/myorder', [DashboardOrderController::class, 'index'])->name('users.order');
//         Route::get('myorder/{id}/edit', [DashboardOrderController::class, 'edit'])->name('user.order.detail');
//         Route::put('myorder/{id}', [DashboardOrderController::class, 'update'])->name('user.order.update');

//         Route::get('/profile/edit', [DashboardProfileController::class, 'edit'])->name('profile-users.edit');
//         Route::put('/profile/edit', [DashboardProfileController::class, 'update']);

//         Route::post('change-profile-picture', [DashboardProfileController::class, 'updatePicture'])->name('usersUpdatePicture');
//     });

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        //dashboard admin
        Route::get('/', [DashboardAdminController::class, 'index'])->name('admin-dashboard');
        Route::resource('products', '\App\Http\Controllers\Admin\ProductController');
        Route::post('/products/gallery/upload', [ProductController::class, 'uploadGallery'])->name('product-gallery-upload');
        Route::get('/products/gallery/delete/{id}', [ProductController::class, 'deleteGallery'])->name('product-gallery-delete');
        Route::resource('users', '\App\Http\Controllers\Admin\UserController');
        Route::resource('kustomer', '\App\Http\Controllers\Admin\CustomerController');
        Route::resource('category', '\App\Http\Controllers\Admin\CategoryController');
        Route::resource('orders', '\App\Http\Controllers\Admin\TransactionController');
        // Route::post('orders/', '\App\Http\Controllers\Admin\PaymentTransactionController@updateOrder')->name('update-shipping');
        // Route::resource('order', '\App\Http\Controllers\Admin\OrderTransactionController');

        //edit data profile
        Route::get('/password/edit', [UpdatePasswordController::class, 'edit'])->name('password.edits');
        Route::put('/password/edit', [UpdatePasswordController::class, 'update']);
        Route::post('/getkabupaten', [UpdateProfileController::class, 'getkabupatens'])->name('getkabupatens');
        Route::get('/profile/edit', [UpdateProfileController::class, 'edit'])->name('profile-admin.edit');
        Route::put('/profile/edit', [UpdateProfileController::class, 'update']);

        Route::post('change-profile-picture', [UpdateProfileController::class, 'updatePicture'])->name('adminUpdatePicture');
        //data laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('datalaporan');
        Route::get('/pesanan', [PemesananController::class, 'index'])->name('datapesanan');

        Route::get('/product-reports', [ProductController::class, 'reports'])->name('dataproduks');
        Route::get('/customerdata', [CustomerController::class, 'getdatacustomer'])->name('data.customers');

        //trashed data
        Route::get('/trash/category', [TrashCategoryController::class, 'index'])->name('trash.category');
        Route::get('/trash/product', [TrashProductController::class, 'index'])->name('trash.product');
        Route::get('/trash/user', [TrashUserController::class, 'index'])->name('trash.user');
        Route::get('/trash/customer', [TrashCustomerController::class, 'index'])->name('trash.customer');
        Route::get('/trash/transaction', [TrashTransactionController::class, 'index'])->name('trash.transaction');
        //trashed restore or delete
        Route::get('/restore/trash/category/{id?}', [TrashCategoryController::class, 'restore'])->name('trash.restore');
        Route::get('/restore/trash/product/{id?}', [TrashProductController::class, 'restore'])->name('trash.restore.product');
        Route::get('/restore/trash/user/{id?}', [TrashUserController::class, 'restore'])->name('trash.restore.user');
        Route::get('/restore/trash/customer/{id?}', [TrashCustomerController::class, 'restore'])->name('trash.restore.customer');
        Route::get('/restore/trash/transaction/{id?}', [TrashTransactionController::class, 'restore'])->name('trash.restore.transaction');
        Route::delete('/delete/trash/category/{id?}', [TrashCategoryController::class, 'deletepermanent'])->name('trash.deletes');
        Route::delete('/delete/trash/user/{id?}', [TrashUserController::class, 'deletepermanent'])->name('trash.deletes.user');
        Route::delete('/delete/trash/customer/{id?}', [TrashCustomerController::class, 'deletepermanent'])->name('trash.deletes.customer');
        Route::delete('/delete/trash/product/{id?}', [TrashProductController::class, 'deletepermanent'])->name('trash.deletes.product');
        Route::delete('/delete/trash/transaction/{id?}', [TrashTransactionController::class, 'deletepermanent'])->name('trash.deletes.transaction');
    });

Route::prefix('pemilik')
    ->namespace('Pemilik')
    ->middleware(['auth', 'pemilik'])
    ->group(function () {
        //dashboard pemilik
        Route::get('/', [DashboardPemilikController::class, 'index'])->name('pemilik-dashboard');
        Route::get('/category', [PemilikCategoryController::class, 'index'])->name('pemilik-category');
        Route::get('/products', [ProductsController::class, 'GetData'])->name('pemilik-products');
        Route::get('users/', [PemilikUserController::class, 'index'])->name('pemilik-users');
        Route::get('/customers/', [CustomersController::class, 'GetData'])->name('pemilik-customers');
        Route::get('/orders/', [PemesananPemilikController::class, 'GetData'])->name('pemilik-orders');
        Route::get('/orders/{id}', [PemesananPemilikController::class, 'show'])->name('pemilik-orders-show');
        //edit profile pemilik
        Route::get('/password/edit', [UpdatePasswordPemilikController::class, 'edit'])->name('password-pemilik.edits');
        Route::put('/password/edit', [UpdatePasswordPemilikController::class, 'update']);
        Route::post('/getkabupaten', [UpdateProfilePemilikController::class, 'getkabupaten'])->name('kabupaten');
        Route::get('/profile/edit', [UpdateProfilePemilikController::class, 'edit'])->name('profile-pemilik.edit');
        Route::put('/profile/edit', [UpdateProfilePemilikController::class, 'update']);

        Route::post('change-profile-picture', [UpdateProfilePemilikController::class, 'updatePicture'])->name('pemilikUpdatePicture');
        //laporan pemilik
        Route::get('/product-reports', [ProductsController::class, 'index'])->name('dataproduk');
        Route::get('/customerdata', [CustomersController::class, 'index'])->name('data.customer');
        Route::get('/laporan', [LaporanPemilikController::class, 'index'])->name('datalaporanpemilik');
        Route::get('/pesanan', [PemesananPemilikController::class, 'index'])->name('datapesananpemilik');
    });
Auth::routes();
