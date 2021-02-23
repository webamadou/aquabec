<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\Notifications;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);
		$users = null;
        $organisations = null;
        $events = null;
        $announcements = null;
        $notifications = null;

/*         if (Schema::hasTable('users')) {
            $users = User::role('user')->with('roles')->get();
        }
        if (Schema::hasTable('organisations')) {
            $organisations = Organisation::all();
        }
        if (Schema::hasTable('events')) {
            $events = Event::all();
        }
        if (Schema::hasTable('announcements')) {
            $announcements = Announcement::all();
        }
        if (Schema::hasTable('notifications')) {
            $notifications = Notifications::all();
        }


 */
        /*$users = User::role('user')->with('roles')->get();
        $organisations = Organisation::all();
        $events = Event::all();
        $announcements = Announcement::all();
        $notifications = Notifications::all();
        View::share(compact('users','organisations','events','announcements','notifications'));
   */ }
}
