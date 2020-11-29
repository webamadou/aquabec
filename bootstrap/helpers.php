<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

if (!function_exists('side_nav_bar_menu_status')) {
    function side_nav_bar_menu_status($name,$status) {
        return Str::of(str_replace('.',' ',Route::currentRouteName()))->contains($name) ? $status : '';
    }
}
