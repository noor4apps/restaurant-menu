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

    static $affectedArray = array();

    public static function tree($id = null)
    {
        $allMenus = Menu::get();

        if (!is_null($id)) {
            $rootMenus = $allMenus->where('id', $id);
        } else {
            $rootMenus = $allMenus->whereNull('menu_id');
        }

        self::formatTree($rootMenus, $allMenus, $id);
        return $rootMenus;
    }

    private static function formatTree($menus, $allMenus, $id = null)
    {
        foreach ($menus as $menu) {
            if (!is_null($id)) {
                $menu->children = $allMenus->where('menu_id', $menu->id)->where('discount', $menu->discount);
                self::$affectedArray[] = $menu->id;
            }

            if ($menu->children->isNotEmpty()) {
                self::formatTree($menu->children, $allMenus, $id);
            }
        }
    }
}
