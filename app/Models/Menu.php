<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Menu;

class Menu extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function menu_links()
    {
        return $this->hasMany(\App\Models\MenuLink::class);
    }

    public function page()
    {
        return $this->belongsTo(\App\Models\Menu::class);
    } 

    public function hasLinks()
    {
        return $this->menu_links->count() > 0 ? true : false;
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'parent', 'id');
    } 
}
