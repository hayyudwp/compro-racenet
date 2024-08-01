<?php
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AboutRaceController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\FranschiseController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GeneralController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PartnershipController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PriceListController;
use App\Http\Controllers\Admin\HelpController;
use App\Http\Controllers\Admin\CoverageController;
use App\Http\Controllers\Admin\SosmedController;
use App\Http\Controllers\Admin\SuggestController;
use App\Http\Controllers\Admin\HeaderController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\DashboardController;
use App\Models\Sosmed;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


    Route::get('/', [ViewController::class, 'home'])->name('home');
    Route::get('/about', [ViewController::class, 'about'])->name('about');
    Route::get('/contact', [ViewController::class, 'contact'])->name('contact');
    Route::get('/contact/store', [SuggestController::class, 'store'])->name('contact.store');
    Route::get('/help', [ViewController::class, 'help'])->name('help');
    Route::get('/coverage', [ViewController::class, 'coverage'])->name('coverage');

    Route::controller(LoginRegisterController::class)->group(function () {
        Route::get('/admin/register', 'register')->name('register');
        Route::post('/admin/store', 'store')->name('store');
        Route::get('/admin/login', 'login')->name('login');
        Route::post('/admin/authenticate', 'authenticate')->name('authenticate');
        Route::get('/admin/dashboards', 'dashboard')->name('dashboards');
        Route::post('/admin/logout', 'logout')->name('logout');
    });

    Route::middleware(['auth'])->group(function () {

        Route::controller(DashboardController::class)->group(function () {
            Route::get('/admin/admin-dashboard', 'index')->name('dashboard');
            Route::post('/admin/admin-profile', 'profile')->name('profile');
        });
        
        Route::controller(PriceListController::class)->group(function () {
            Route::get('/admin/pricelist', 'index')->name('pricelist.index');
            Route::get('/admin/pricelist/create', 'create')->name('pricelist.create');
            Route::post('/admin/pricelist/store', 'store')->name('pricelist.store');
            Route::get('/admin/pricelist/edit/{pricelist}', 'edit')->name('pricelist.edit');
            Route::put('/admin/pricelist/update/{pricelist}', 'update')->name('pricelist.update');
            Route::post('/admin/pricelist/delete', 'delete')->name('pricelist.delete');
        });

        Route::controller(HelpController::class)->group(function () {
            Route::get('/admin/help', 'index')->name('help.index');
            Route::get('/admin/help/create', 'create')->name('help.create');
            Route::post('/admin/help/store', 'store')->name('help.store');
            Route::get('/admin/help/edit/{help}', 'edit')->name('help.edit');
            Route::put('/admin/help/update/{help}', 'update')->name('help.update');
            Route::post('/admin/help/delete', 'delete')->name('help.delete');
        });

        Route::controller(CoverageController::class)->group(function () {
            Route::get('/admin/coverage', 'index')->name('coverage.index');
            Route::get('/admin/coverage/create', 'create')->name('coverage.create');
            Route::post('/admin/coverage/store', 'store')->name('coverage.store');
            Route::get('/admin/coverage/edit/{coverage}', 'edit')->name('coverage.edit');
            Route::put('/admin/coverage/update/{coverage}', 'update')->name('coverage.update');
            Route::post('/admin/coverage/delete', 'delete')->name('coverage.delete');
        });

        Route::controller(SosmedController::class)->group(function () {
            Route::get('/admin/sosmed', 'index')->name('sosmed.index');
            Route::get('/admin/sosmed/create', 'create')->name('sosmed.create');
            Route::post('/admin/sosmed/store', 'store')->name('sosmed.store');
            Route::get('/admin/sosmed/edit/{sosmed}', 'edit')->name('sosmed.edit');
            Route::put('/admin/sosmed/update/{sosmed}', 'update')->name('sosmed.update');
            Route::post('/admin/sosmed/delete', 'delete')->name('sosmed.delete');
        });

        Route::controller(AboutRaceController::class)->group(function () {
            Route::get('/admin/about', 'index')->name('about.index');
            Route::get('/admin/about/create', 'create')->name('about.create');
            Route::post('/admin/about/store', 'store')->name('about.store');
            Route::get('/admin/about/edit/{about}', 'edit')->name('about.edit');
            Route::put('/admin/about/update/{about}', 'update')->name('about.update');
            Route::post('/admin/about/delete', 'delete')->name('about.delete');
        });

        Route::controller(ContentController::class)->group(function () {
            Route::get('/admin/content', 'index')->name('content.index');
            Route::get('/admin/content/create', 'create')->name('content.create');
            Route::post('/admin/content/store', 'store')->name('content.store');
            Route::get('/admin/content/edit/{content}', 'edit')->name('content.edit');
            Route::put('/admin/content/update/{content}', 'update')->name('content.update');
            Route::post('/admin/content/delete', 'delete')->name('content.delete');
        });

        Route::controller(GeneralController::class)->group(function () {
            Route::get('/admin/homecontent', 'index')->name('homecontent.index');
            Route::get('/admin/homecontent/create', 'create')->name('homecontent.create');
            Route::post('/admin/homecontent/store', 'store')->name('homecontent.store');
            Route::get('/admin/homecontent/edit/{homecontent}', 'edit')->name('homecontent.edit');
            Route::put('/admin/homecontent/update/{homecontent}', 'update')->name('homecontent.update');
            Route::post('/admin/homecontent/delete', 'delete')->name('homecontent.delete');
        });

        Route::controller(HeaderController::class)->group(function () {
            Route::get('/admin/header', 'index')->name('header.index');
            Route::get('/admin/header/create', 'create')->name('header.create');
            Route::post('/admin/header/store', 'store')->name('header.store');
            Route::get('/admin/header/edit/{header}', 'edit')->name('header.edit');
            Route::put('/admin/header/update/{header}', 'update')->name('header.update');
            Route::post('/admin/header/delete', 'delete')->name('header.delete');
        });

        Route::controller(SuggestController::class)->group(function () {
            Route::get('/admin/suggest', 'index')->name('suggest.index');
        });
    
    
    });
    
  