<?php
use App\Http\Controllers\Admin\AboutRaceController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PriceListController;
use App\Http\Controllers\Admin\HelpController;
use App\Http\Controllers\Admin\CoverageController;
use App\Http\Controllers\Admin\SosmedController;
use App\Http\Controllers\Admin\SuggestController;
use App\Http\Controllers\Admin\HeaderController;
use App\Http\Controllers\Admin\BroadbandController;
use App\Http\Controllers\Admin\DedicatedController;
use App\Http\Controllers\Admin\HostingController;
use App\Http\Controllers\Admin\GeneralController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ColocationController;
use App\Http\Controllers\Admin\ITSolutionController;
use App\Http\Controllers\Admin\ManageServiceController;
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
    Route::get('/product/broadband-internet', [ViewController::class, 'broadband'])->name('broadband');
    Route::get('/product/dedicated-internet', [ViewController::class, 'dedicated'])->name('dedicated');
    Route::get('/product/hosting-and-colocation', [ViewController::class, 'hosting'])->name('hosting');
    Route::get('/product/manage-service-solution', [ViewController::class, 'service'])->name('service');
    Route::get('/product/it-solution', [ViewController::class, 'solution'])->name('solution');
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
            // Route::get('/admin/admin-dashboard', 'index')->name('dashboard');
            Route::post('/admin/admin-profile', 'profile')->name('profile');
        });
        
        Route::controller(PriceListController::class)->group(function () {
            Route::get('/admin/home/pricelist', 'index')->name('pricelist.index');
            Route::get('/admin/home/pricelist/create', 'create')->name('pricelist.create');
            Route::post('/admin/home/pricelist/store', 'store')->name('pricelist.store');
            Route::get('/admin/home/pricelist/edit/{pricelist}', 'edit')->name('pricelist.edit');
            Route::put('/admin/home/pricelist/update/{pricelist}', 'update')->name('pricelist.update');
            Route::post('/admin/home/pricelist/delete', 'delete')->name('pricelist.delete');
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
            Route::get('/admin/about/about-list', 'index')->name('about.index');
            Route::get('/admin/about/about-list/create', 'create')->name('about.create');
            Route::post('/admin/about/about-list/store', 'store')->name('about.store');
            Route::get('/admin/about/about-list/edit/{about}', 'edit')->name('about.edit');
            Route::put('/admin/about/about-list/update/{about}', 'update')->name('about.update');
            Route::post('/admin/about/about-list/delete', 'delete')->name('about.delete');
        });

        Route::controller(ContentController::class)->group(function () {
            Route::get('/admin/about/content', 'index')->name('content.index');
            Route::get('/admin/about/content/create', 'create')->name('content.create');
            Route::post('/admin/about/content/store', 'store')->name('content.store');
            Route::get('/admin/about/content/edit/{content}', 'edit')->name('content.edit');
            Route::put('/admin/about/content/update/{content}', 'update')->name('content.update');
            Route::post('/admin/about/content/delete', 'delete')->name('content.delete');
        });

        Route::controller(GeneralController::class)->group(function () {
            Route::get('/admin/home/content', 'index')->name('homecontent.index');
            Route::get('/admin/home/content/create', 'create')->name('homecontent.create');
            Route::post('/admin/home/content/store', 'store')->name('homecontent.store');
            Route::get('/admin/home/content/edit/{homecontent}', 'edit')->name('homecontent.edit');
            Route::put('/admin/home/content/update/{homecontent}', 'update')->name('homecontent.update');
            Route::post('/admin/home/content/delete', 'delete')->name('homecontent.delete');
        });

        Route::controller(HeaderController::class)->group(function () {
            Route::get('/admin/header', 'index')->name('header.index');
            Route::get('/admin/header/create', 'create')->name('header.create');
            Route::post('/admin/header/store', 'store')->name('header.store');
            Route::get('/admin/header/edit/{header}', 'edit')->name('header.edit');
            Route::put('/admin/header/update/{header}', 'update')->name('header.update');
            Route::post('/admin/header/delete', 'delete')->name('header.delete');
        });

        Route::controller(BroadbandController::class)->group(function () {
            Route::get('/admin/product/broadband-internet', 'index')->name('broadband.index');
            Route::get('/admin/product/broadband-internet/create', 'create')->name('broadband.create');
            Route::post('/admin/product/broadband-internet/store', 'store')->name('broadband.store');
            Route::get('/admin/product/broadband-internet/edit/{broadband}', 'edit')->name('broadband.edit');
            Route::put('/admin/product/broadband-internet/update/{broadband}', 'update')->name('broadband.update');
            Route::post('/admin/product/broadband-internet/delete', 'delete')->name('broadband.delete');
        });

        Route::controller(DedicatedController::class)->group(function () {
            Route::get('/admin/product/dedicated-internet', 'index')->name('dedicated.index');
            Route::get('/admin/product/dedicated-internet/create', 'create')->name('dedicated.create');
            Route::post('/admin/product/dedicated-internet/store', 'store')->name('dedicated.store');
            Route::get('/admin/product/dedicated-internet/edit/{dedicated}', 'edit')->name('dedicated.edit');
            Route::put('/admin/product/dedicated-internet/update/{dedicated}', 'update')->name('dedicated.update');
            Route::post('/admin/product/dedicated-internet/delete', 'delete')->name('dedicated.delete');
        });

        Route::controller(DedicatedController::class)->group(function () {
            Route::get('/admin/product/dedicated-internet/detail/create', 'create')->name('dedicated-detail.create');
            Route::post('/admin/product/dedicated-internet/detail/store', 'store_detail')->name('dedicated-detail.store');
            Route::get('/admin/product/dedicated-internet/detail/edit/{dedicated_detail}', 'edit_detail')->name('dedicated-detail.edit');
            Route::put('/admin/product/dedicated-internet/detail/update/{dedicated_detail}', 'update_detail')->name('dedicated-detail.update');
            Route::post('/admin/product/dedicated-internet/detail/delete', 'delete_detail')->name('dedicated-detail.delete');
        });
        
        Route::controller(HostingController::class)->group(function () {
            Route::get('/admin/product/hosting', 'index')->name('hosting.index');
            Route::get('/admin/product/hosting/create', 'create')->name('hosting.create');
            Route::post('/admin/product/hosting/store', 'store')->name('hosting.store');
            Route::get('/admin/product/hosting/edit/{hosting}', 'edit')->name('hosting.edit');
            Route::put('/admin/product/hosting/update/{hosting}', 'update')->name('hosting.update');
            Route::post('/admin/product/hosting/delete', 'delete')->name('hosting.delete');
        });

        Route::controller(HostingController::class)->group(function () {
            Route::get('/admin/product/hosting/detail/create', 'create')->name('hosting-detail.create');
            Route::post('/admin/product/hosting/detail/store', 'store_detail')->name('hosting-detail.store');
            Route::get('/admin/product/hosting/detail/edit/{hosting_detail}', 'edit_detail')->name('hosting-detail.edit');
            Route::put('/admin/product/hosting/detail/update/{hosting_detail}', 'update_detail')->name('hosting-detail.update');
            Route::post('/admin/product/hosting/detail/delete', 'delete_detail')->name('hosting-detail.delete');
        });


        Route::controller(ColocationController::class)->group(function () {
            Route::get('/admin/product/colocation', 'index')->name('colocation.index');
            Route::get('/admin/product/colocation/create', 'create')->name('colocation.create');
            Route::post('/admin/product/colocation/store', 'store')->name('colocation.store');
            Route::get('/admin/product/colocation/edit/{colocation}', 'edit')->name('colocation.edit');
            Route::put('/admin/product/colocation/update/{colocation}', 'update')->name('colocation.update');
            Route::post('/admin/product/colocation/delete', 'delete')->name('colocation.delete');
        });

        Route::controller(ColocationController::class)->group(function () {
            Route::get('/admin/product/colocation/detail/create', 'create')->name('colocation-detail.create');
            Route::post('/admin/product/colocation/detail/store', 'store_detail')->name('colocation-detail.store');
            Route::get('/admin/product/colocation/detail/edit/{colocation_detail}', 'edit_detail')->name('colocation-detail.edit');
            Route::put('/admin/product/colocation/detail/update/{colocation_detail}', 'update_detail')->name('colocation-detail.update');
            Route::post('/admin/product/colocation/detail/delete', 'delete_detail')->name('colocation-detail.delete');
        });

        Route::controller(ManageServiceController::class)->group(function () {
            Route::get('/admin/product/manage-service-solution', 'index')->name('manage-service.index');
            Route::get('/admin/product/manage-service-solution/create', 'create')->name('manage-service.create');
            Route::post('/admin/product/manage-service-solution/store', 'store')->name('manage-service.store');
            Route::get('/admin/product/manage-service-solution/edit/{manage_service}', 'edit')->name('manage-service.edit');
            Route::put('/admin/product/manage-service-solution/update/{manage_service}', 'update')->name('manage-service.update');
            Route::post('/admin/product/manage-service-solution/delete', 'delete')->name('manage-service.delete');
        });

        Route::controller(ManageServiceController::class)->group(function () {
            Route::get('/admin/product/manage-service-solution/detail/create', 'create')->name('manage-service-detail.create');
            Route::post('/admin/product/manage-service-solution/detail/store', 'store_detail')->name('manage-service-detail.store');
            Route::get('/admin/product/manage-service-solution/detail/edit/{manage_service_detail}', 'edit_detail')->name('manage-service-detail.edit');
            Route::put('/admin/product/manage-service-solution/detail/update/{manage_service_detail}', 'update_detail')->name('manage-service-detail.update');
            Route::post('/admin/product/manage-service-solution/detail/delete', 'delete_detail')->name('manage-service-detail.delete');
        });
        Route::controller(ITSolutionController::class)->group(function () {
            Route::get('/admin/product/it-solution', 'index')->name('it-solution.index');
            Route::get('/admin/product/it-solution/create', 'create')->name('it-solution.create');
            Route::post('/admin/product/it-solution/store', 'store')->name('it-solution.store');
            Route::get('/admin/product/it-solution/edit/{it_solution}', 'edit')->name('it-solution.edit');
            Route::put('/admin/product/it-solution/update/{it_solution}', 'update')->name('it-solution.update');
            Route::post('/admin/product/it-solution/delete', 'delete')->name('it-solution.delete');
        });

        Route::controller(ITSolutionController::class)->group(function () {
            Route::get('/admin/product/it-solution/detail/create', 'create')->name('it-solution-detail.create');
            Route::post('/admin/product/it-solution/detail/store', 'store_detail')->name('it-solution-detail.store');
            Route::get('/admin/product/it-solution/detail/edit/{it_solution_detail}', 'edit_detail')->name('it-solution-detail.edit');
            Route::put('/admin/product/it-solution/detail/update/{it_solution_detail}', 'update_detail')->name('it-solution-detail.update');
            Route::post('/admin/product/it-solution/detail/delete', 'delete_detail')->name('it-solution-detail.delete');
        });

        Route::controller(SuggestController::class)->group(function () {
            Route::get('/admin/suggest', 'index')->name('suggest.index');
        });
    
    
    });
    
  