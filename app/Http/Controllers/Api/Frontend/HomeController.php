<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function menusTree()
    {
        $menus = Menu::tree();
        return response()->json(['data' => $menus]);
    }

    public function itemsSelected()
    {
        $menu_id = request('menu_id');
        $items = Item::where('menu_id', $menu_id)->get();

        return ItemResource::collection($items);
    }
}
