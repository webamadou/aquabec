<?php

use App\Http\Controllers\Backend\Admin\CategoryController;
use App\Http\Controllers\Backend\Admin\CityController;
use App\Http\Controllers\Backend\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Backend\Admin\OrganisationController;
use App\Http\Controllers\Backend\Admin\PermissionController;
use App\Http\Controllers\Backend\Admin\RegionController;
use App\Http\Controllers\Backend\Admin\RoleController;
use App\Http\Controllers\Backend\Admin\SubscriptionController;
use App\Http\Controllers\Backend\Admin\UserController;
use App\Http\Controllers\Backend\User\DashboardController as UserDashboard;
use App\Http\Controllers\Backend\User\EventController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\WelcomeController;
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

/******************************/
/*         AUTH ROUTES        */
/******************************/

Auth::routes(['verify' => true]);



/******************************/
/*       FRONTEND ROUTES      */
/******************************/

Route::get('/', [WelcomeController::class, 'welcomePage'])->name('welcome');
Route::get('contact-us', [ContactController::class, 'contactPage'])->name('contact');
Route::get('how-to-use', [ContactController::class, 'contactPage'])->name('how.to.use');
Route::get('get-started', [ContactController::class, 'contactPage'])->name('get.started');
Route::post('contact', [ContactController::class, 'contactPost'])->name('contact.post');



/******************************/
/*       BACKEND ROUTES       */
/******************************/

Route::middleware(['auth','verified'])->group(function (){
    /*
     * Admin's Routes
     */
    Route::middleware(['role:super-admin|admin'])->name('admin.')->prefix('admin')->group(function () {
        // Dashboard Routes...
        Route::get('dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        // Settings Routes...
        Route::name('settings.')->prefix('settings')->group(function () {
            // Security Routes...
            Route::name('security.')->prefix('security')->group(function () {
                // Roles Routes...
                Route::resource('roles', RoleController::class);
                Route::get('get-role-data', [RoleController::class, 'roleData'])->name('roles.data');
                Route::get('roles/{role}/permissions', [RoleController::class, 'getRolePermissions'])->name('roles.permissions');
                Route::put('roles/{role}/permissions', [RoleController::class, 'assignRolePermissions'])->name('roles.permissions.assign');
                // Permissions Routes...
                Route::resource('permissions', PermissionController::class);
                Route::get('get-permission-data', [PermissionController::class, 'permissionData'])->name('permissions.data');
            });
            // Regions Routes
            Route::resource('regions', RegionController::class);
            Route::get('get-regions-data', [RegionController::class, 'regionsData'])->name('regions.data');
            // Cities Routes
            Route::resource('cities', CityController::class);
            Route::get('get-cities-data', [CityController::class, 'citiesData'])->name('cities.data');
            // Categories Routes
            Route::resource('categories', CategoryController::class);
            Route::get('get-event-categories-data', [CategoryController::class, 'eventCategoriesData'])->name('event.categories.data');
            Route::get('get-announcement-categories-data', [CategoryController::class, 'announcementCategoriesData'])->name('announcement.categories.data');

        });
        // Users Routes
        Route::resource('users', UserController::class);
        Route::get('get-users-data', [UserController::class, 'usersData'])->name('users.data');
        // Organisations Routes
        Route::resource('organisations', OrganisationController::class);
        Route::get('get-organisations-data', [OrganisationController::class, 'organisationsData'])->name('organisations.data');
        // Subscriptions Routes
        Route::resource('subscriptions', SubscriptionController::class);
        Route::get('get-subscriptions-data', [SubscriptionController::class, 'subscriptionsData'])->name('subscriptions.data');
    });

    /*
     * User's Routes
     */
    Route::middleware(['role:user'])->name('user.')->group(function () {
        Route::get('dashboard', [UserDashboard::class, 'index'])->name('dashboard');
        Route::resource('events', EventController::class);
        Route::get('get-city-by-region/{region_id}', [EventController::class, 'getCityByRegion']);
        Route::get('get-events-data', [EventController::class, 'getEventsData']);
    });
});