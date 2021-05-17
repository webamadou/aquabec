<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Menu ;

class MenuLink extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function page()
    {
        return $this->belongsTo(\App\Models\Page::class,'page_id','id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
