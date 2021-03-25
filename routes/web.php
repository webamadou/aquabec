<?php

use App\Http\Controllers\Backend\Admin\CategoryController;
use App\Http\Controllers\Backend\Admin\CaracteristicController;
use App\Http\Controllers\Backend\Admin\CaracteristicOptionController;
use App\Http\Controllers\Backend\Admin\CityController;
use App\Http\Controllers\Backend\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Backend\Admin\OrganisationController;
use App\Http\Controllers\Backend\Admin\PermissionController;
use App\Http\Controllers\Backend\Admin\RegionController;
use App\Http\Controllers\Backend\Admin\RoleController;
use App\Http\Controllers\Backend\Admin\SubscriptionController;
use App\Http\Controllers\Backend\Admin\UserController;
use App\Http\Controllers\Backend\Admin\CreditPackController;
use App\Http\Controllers\Backend\Admin\CreditsController;
use App\Http\Controllers\Backend\Admin\CurrencyController;
use App\Http\Controllers\Backend\Admin\AgeRangeController;
use App\Http\Controllers\Backend\Admin\MenuController;
use App\Http\Controllers\Backend\Admin\MenuLinkController;

use App\Http\Controllers\Frontend\DashboardController as UserDashboard;
use App\Http\Controllers\Backend\User\EventController as EventsDashboard;

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\WelcomeController;
use App\Http\Controllers\Frontend\SubscriberController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Backend\Admin\AnnouncementController as BOAnnouncementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Backend\Admin\EventController as BOEventController;

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
/*       PUBLIC ROUTES      */
/******************************/

Route::get('/', [WelcomeController::class, 'welcomePage'])->name('welcome');
Route::get('/home', [WelcomeController::class, 'welcomePage'])->name('home');
Route::get('/index', [WelcomeController::class, 'welcomePage'])->name('index');
Route::get('/accueil', [WelcomeController::class, 'welcomePage'])->name('accueil');
Route::get('contact-us', [ContactController::class, 'contactPage'])->name('contact');
Route::get('how-to-use', [ContactController::class, 'contactPage'])->name('how.to.use');
Route::get('get-started', [ContactController::class, 'contactPage'])->name('get.started');
Route::post('contact', [ContactController::class, 'contactPost'])->name('contact.post');

Route::get('/events/{region:slug}', [WelcomeController::class, 'eventsRegion'])->name('event_region');
Route::get("/announcements/{category:slug}", [WelcomeController::class, 'announcementCategory'])->name('announcement_page');
Route::get("/announcement/{announcement:slug}", [WelcomeController::class, 'showAnnouncement'])->name('page_announcement');
Route::get("/event/{event:slug}", [WelcomeController::class, 'showEvent'])->name('page_event');
Route::get('/profil/{user:slug?}', [WelcomeController::class, 'showProfile'])->name('user_profile');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get("/evenement/{event:slug}", [UserDashboard::class, 'showEvent'])->name('event_page');

//We use following links to display images from storage folder
Route::get('show/images/{filename?}', [UserDashboard::class, 'showImage'])->name('show.image');
//Search route
Route::get('/chercher/',[WelcomeController::class, 'searchContent'])->name('search');

//Pages route
Route::get("/pages/{page:slug}",[WelcomeController::class, 'page'])->name("page");

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
/******************************/
/*  VERIFIED USERS ROUTES     */
/******************************/

Route::middleware(['auth','verified'])->group(function (){
    /*
    * Admin's Routes
    */
    Route::get('get-users-list', [CreditsController::class, 'getUsersLists'])->name("get-users-list");

    /**
     * process transfer credit
     */
    Route::post('credits-transfer', [App\Http\Controllers\TransferCreditsController::class, 'transfering'])->name('credits.transfer');

    Route::middleware(['role:banker|banquier'])->name('banker.')->prefix('banker')->group(function () {
        Route::resource("currencies", CurrencyController::class);
        Route::get("/generator/{currency}",[CurrencyController::class, 'generate'])->name('currencies.generate');
        Route::post("/generator",[CurrencyController::class, 'generator'])->name('currencies.generator');
        Route::get("get-currencies-data", [CurrencyController::class, 'currenciesData'])->name('currencies.data');
        Route::get("/accounts", [CurrencyController::class, 'accounts'])->name('currencies.accounts');
        Route::get("/transfering/{currency}",[CurrencyController::class, 'transfer'])->name('currencies.transfer');
        Route::post("/transfering",[CurrencyController::class, 'transfering'])->name('currencies.transfering');
    });

    Route::middleware(['role:super-admin|admin|banker|banquier'])->name('admin.')->prefix('admin')->group(function () {
        // Dashboard Routes...
        Route::get('dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        //Logs des transferts de credit
        Route::get('/credits-logs',[App\Http\Controllers\TransferCreditsController::class, 'currencyLogs'])->name("credits.logs");
        Route::get('/currency-logs/{id}',[App\Http\Controllers\TransferCreditsController::class, 'singleCurrencyLogs'])->name("currency.logs");

        Route::get('/get-credits-logs', [App\Http\Controllers\TransferCreditsController::class, 'currencyLogsData'])->name('credit.logs');
        Route::get('/get-currency-logs/{id}', [App\Http\Controllers\TransferCreditsController::class, 'singleCurrencyLogsData'])->name('credit.logs');
        // Settings Routes...
        Route::name('settings.')->prefix('settings')->group(function () {
            //Pages routes
            Route::resource("pages",PageController::class);
            Route::get('get-pages-data', [RoleController::class, 'pagesData'])->name('pages.data');

            Route::get("/pages_section/create",[PageController::class, 'create_section'])->name("create_section");
            Route::post("/pages_section",[PageController::class, 'store_section'])->name("store_section");
            Route::get("/pages_section/{home_section}/edit",[PageController::class, 'edit_section'])->name("edit_section");
            Route::put("/pages_section/{home_section}/update",[PageController::class, 'update_section'])->name("update_section");
            
            Route::resource("menus",MenuController::class);
            Route::get('get-menu-data', [MenuController::class, 'menusData'])->name('menus.data');
            
            Route::resource("menu_links",MenuLinkController::class);
            Route::get('get-menu-links-data', [MenuLinkController::class, 'menusData'])->name('menulinks.data');
            // Security Routes ...
            Route::name('security.')->prefix('security')->group(function () {
                // ***FOLLOWING ROUT IS USE TO UPDATE/ADAPT THE CURRENT db TO ORIGINAL ONE ***
                Route::get("/update_db",[\App\Http\Controllers\UpdateDBController::class, 'index']);
                // ******************************************************************************
                // Roles Routes ...
                Route::resource('roles', RoleController::class);
                Route::get('get-role-data', [RoleController::class, 'roleData'])->name('roles.data');
                
                Route::get('roles/{role}/permissions', [RoleController::class, 'getRolePermissions'])->name('roles.permissions');
                Route::put('roles/{role}/permissions', [RoleController::class, 'assignRolePermissions'])->name('roles.permissions.assign');
                // Permissions Routes ...
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
            Route::get('get-categories-data', [CategoryController::class, 'categoriesData'])->name('event.categories.data');
            // Caracteristics Routes
            Route::resource('caracteristics', CaracteristicController::class);
            Route::get('get-cateristics-data', [CaracteristicController::class, 'caracteristicsData'])->name('cateristics.data');
            // Caracteristics options Routes
            //Route::resource('caracteristic_options', CaracteristicOptionController::class);
            Route::get('get-cateristic-options-data/{caracteristic}', [CaracteristicOptionController::class, 'optionsData'])->name('cateristicOptions.data');

            Route::get('/caracteristic/{caracteristic}/caracteristic_options', [CaracteristicOptionController::class, 'index'])->name("caracteristicOption");
            Route::get('/caracteristic/{caracteristic}/caracteristic_options/create', [CaracteristicOptionController::class, 'create'])->name("caracteristicOption.create");
            Route::post('/caracteristic/{caracteristic}/caracteristic_options', [CaracteristicOptionController::class, 'store'])->name("store_caracteristicOption");
            Route::get('/caracteristic/{caracteristic}/caracteristic_options/{option_id}/edit', [CaracteristicOptionController::class, 'edit'])->name("edit_caracteristicOption");
            Route::put('/caracteristic/caracteristic_options/{option}', [CaracteristicOptionController::class, 'update'])->name("update_caracteristicOption");
            Route::delete('/caracteristic/caracteristic_options/{option}', [CaracteristicOptionController::class, 'destroy'])->name("delete_caracteristicOption"); //*/
            //Age range resource
            Route::resource('age_ranges', AgeRangeController::class);
            Route::get('get-age_ranges-data', [AgeRangeController::class, 'eventAgeRangeData'])->name('event.categories.data');

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
        //BO annoucements routes
        Route::get("/myAnnouncements-data", [BOAnnouncementController::class, 'myAnnouncementsData'])->name('myAnnouncements-data');
        Route::get('announcements',[BOAnnouncementController::class, 'index'])->name('announcements');
        Route::get("/creation", [BOAnnouncementController::class, 'create'])->name('create_announcement');
        // Route::post("/store", [UserDashboard::class, 'storeAnnouncement'])->name('store_announcement');
        Route::post("/store", [BOAnnouncementController::class, 'store'])->name('store_announcement');
        Route::get("/announcement/{announcement:id}", [BOAnnouncementController::class, 'show'])->name('show_announcement');
        Route::get("/edit/{announcement:id}", [BOAnnouncementController::class, 'edit'])->name('edit_announcement');
        Route::put("/update/{announcement}", [BOAnnouncementController::class, 'update'])->name('update_announcement');
        Route::delete("/delete_announcement/{announcement}", [BOAnnouncementController::class, 'delete'])->name('delete_announcement');
        Route::post("/validation_announcement/{announcement}", [BOAnnouncementController::class, 'validation'])->name('validation_announcement');
        
        Route::get("/myevents-data", [BOEventController::class, 'myEventsData'])->name('myEvents-data');
        Route::get("/index", [BOEventController::class, 'myEvents'])->name("listevents");
        Route::get("/create_event/{announcement?}", [BOEventController::class, 'create'])->name('create_event');
        Route::post("/store_event", [BOEventController::class, 'store'])->name('store_event');
        Route::get("/event/{event}", [BOEventController::class, 'show'])->name('show_event');
        Route::get("/edit_event/{event}", [BOEventController::class, 'edit'])->name('edit_event');
        Route::put("/update_events/{event}", [BOEventController::class, 'update'])->name('update_event');
        Route::delete("/delete_event/{event}", [BOEventController::class, 'delete'])->name('delete_event');
        Route::post("/validation_event/{event}", [BOEventController::class, 'validation'])->name('validation_event');


    });

    /*
     * Vendor's Routes
     */
    Route::middleware(['role:chef-vendeur|vendeur'])->name('vendeurs.')->group(function () {
        Route::get('/my_team', [UserDashboard::class, 'myTeam'])->name('my_team');
        Route::get('get-my_team-data/{user_id?}', [UserDashboard::class, 'myTeamData'])->name('my_team_data');
        Route::get('/create/vendeur', [UserController::class, 'createVendeur'])->name('create_vendeur');
        Route::post('/create/vendeur', [UserController::class, 'store'])->name('store_vendeur');
        Route::get('/edit/vendeur/{user:slug}/edit', [UserController::class, 'editVendeur'])->name('edit_vendeur');
        Route::put('/update/vendeur/{user:slug}', [UserController::class, 'update'])->name('update_vendeur');
        Route::get('/vendeur/{user:slug}', [UserDashboard::class, 'showProfile'])->name('show_vendeur');
        Route::delete('/vendeur/{user}', [UserController::class, 'destroy'])->name('delete');
    });
    /*
     * User's Routes
     */
    //Route::middleware(['role:user|client'])->name('user.')->group(function () {
    Route::name('user.')->group(function () {
        Route::get('/vendeur/{user:slug?}', [UserDashboard::class, 'showProfile'])->name('show_profile');

        Route::get('dashboard', [UserDashboard::class, 'index'])->name('dashboard');
        Route::resource('events', EventsDashboard::class);
        Route::get('get-city-by-region/{region_id}', [EventsDashboard::class, 'getCityByRegion']);
        Route::get('get-events-data', [EventsDashboard::class, 'getEventsData']);
        Route::get('/membres/{default_tab?}', [UserDashboard::class, 'infosPerso'])->name('infosperso');
        Route::post("/update/members/infosperso", [UserController::class, 'updateInfosPerso'])->name("updateInfosPerso");
        Route::get("select_cities/",[UserDashboard::class, "selectCities"])->name("select_cities");
        Route::get("user_sent_transactions/",[UserDashboard::class, "userSentTransactions"])->name("userSentTransactions");
        Route::post("/update_password", [UserController::class, "updatePWD"])->name('update_password');
        Route::post("/assign_role", [UserController::class, "assignRole"])->name('assign_role');
        Route::post("/assign_role_checkout", [UserController::class, "assignRoleCheckout"])->name('assign_role_checkout');
        //FO currencies routes
        Route::get("/transfering/{currency:slug}",[UserDashboard::class, 'transferCurrency'])->name('currencies.transfer');
    });

    //Routes for vendeurs and annonceurs
    Route::middleware(['role:vendeur|annonceur|super-admin|admin'])->name('user.')->group(function(){
        Route::get("/mes_annonces", [UserDashboard::class, 'myAnnouncements'])->name("my_announcements");
        Route::get("/mes_annonces/creation", [AnnouncementController::class, 'create'])->name('create_announcement');
        // Route::post("/mes_annonces/store", [UserDashboard::class, 'storeAnnouncement'])->name('store_announcement');
        Route::post("/mes_annonces/store", [AnnouncementController::class, 'store'])->name('store_announcement');
        Route::get("/mes_annonces/announcement/{announcement:slug}", [AnnouncementController::class, 'show'])->name('show_announcement');
        Route::get("/mes_annonces/edit/{announcement:slug}", [AnnouncementController::class, 'edit'])->name('edit_announcement');
        Route::put("/mes_annonces/update/{announcement}", [AnnouncementController::class, 'update'])->name('update_announcement');
        Route::get("/myAnnouncements-data", [AnnouncementController::class, 'myAnnouncementsData'])->name('myAnnouncements-data');
        Route::delete("/mes_annonces/delete/{announcement:slug}", [AnnouncementController::class, 'delete'])->name('delete_announcement');

        Route::get("/mes_evenements", [EventController::class, 'myEvents'])->name("my_events");
        Route::get("/mes_evenements/create/{announcement:slug?}", [EventController::class, 'create'])->name('create_event');
        Route::post("/mes_evenements/store", [EventController::class, 'store'])->name('store_event');
        Route::get("/mes_evenements/event/{event:slug}", [EventController::class, 'show'])->name('show_event');
        Route::get("/mes_evenements/edit/{event:slug}", [EventController::class, 'edit'])->name('edit_event');
        Route::put("/mes_evenements/update/{event}", [EventController::class, 'update'])->name('update_event');
        Route::get("/myevents-data", [EventController::class, 'myEventsData'])->name('myEvents-data');
        Route::delete("/mes_evenements/delete/{event:slug}", [EventController::class, 'delete'])->name('delete_event');
    });
    /**
     * User's subscription
     */
    Route::get("subscription_summary/{subscription:slug}", [SubscriberController::class, "summary"])->name("subscription_summary");
    Route::get("/my_safe", [SubscriberController::class, "mySafe"])->name("my_safe");


    /**
     * Transactions routes 
     */
    Route::post("/payment", [\App\Http\Controllers\PaymentController::class, 'payment'])->name('payment');
    Route::post("/checkout", [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('checkout');

    Route::get("/purchase", [CurrencyController::class, "purchase"])->name("purchase_currency");
    Route::post("/update_prices_list", [CurrencyController::class, "updatePricesList"])->name("update_prices_list");
    Route::post("/process_purchase", [CurrencyController::class, "purchasing"])->name("process_purchase_currency");
    Route::post("/process_purchase_checkout", [CurrencyController::class, "purchasing_checkout"])->name("checkout_purchase_currency");
});
