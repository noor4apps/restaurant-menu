<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'discount', 'type', 'menu_id'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'menu_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'menu_id');
    }

    public static function tree()
    {
        $allMenus = Menu::get();
        $rootMenus = $allMenus->whereNull('menu_id');

        self::formatTree($rootMenus,$allMenus);

        return $rootMenus;
    }

    private static function formatTree($menus, $allMenus)
    {
        foreach ($menus as $menu) {
            $menu->children = $allMenus->where('menu_id', $menu->id)->values();

            if($menu->children->isNotEmpty()) {
                self::formatTree($menu->children, $allMenus);
            }
        }
    }
}
