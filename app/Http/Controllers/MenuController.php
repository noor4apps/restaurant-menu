<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{

    public function index()
    {
        $menus = Menu::with('parent')->get();
        return MenuResource::collection($menus);
    }

    public function create()
    {
        $menus = Menu::where('type', 'category')->select(['id', 'name'])->get();
        return MenuResource::collection($menus);
    }

    public function store(StoreMenuRequest $request)
    {
        // Query about the parent to know his type and discount.
        $parentMenu = Menu::where('id', $request->menu_id)->first();
        // Menu must not have mixed children
        // The parent menu only accepts the items.
        if ($request->menu_id != null and $parentMenu->type == 'item') {
            return response()->json(['message' => 'The menu cannot be created. The parent menu only accepts the items.']);
        }

        // Inherit the discount menu from the parent if the menu does not have a discount.
        if ($request->menu_id != null and $request->discount == null) {
            $request->merge(['discount' => $parentMenu->discount]);
        }

        $menu = Menu::create($request->all());
        if ($menu) {
            return response()->json(['message' => 'Added Successfully']);
        }
    }

    public function show(Menu $menu)
    {
        return new MenuResource($menu);
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        // Prevent update if the TYPE is changed and the menu HAS children (menus or items)
        $TypeIsChanged = $request->type != $menu->type;
        if ($TypeIsChanged) {
            $menuHasChildrenMenu  = $menu->children->count() > 0;
            $menuHasChildrenItem = $menu->items->count() > 0;
            if ($menuHasChildrenMenu  or $menuHasChildrenItem) {
                return response()->json(['message' => 'The menu cannot be update. It is not possible to change the (type) of menu that has children.']);
            }
        }

        // Menu must not have mixed children
        // Query about the parent to know his type.
        $parentMenu = Menu::where('id', $request->menu_id)->first();
        // The parent menu only accepts the items.
        if ($request->menu_id != null and $parentMenu->type == 'item') {
            return response()->json(['message' => 'The menu cannot be update. The parent menu only accepts the items.']);
        }

        // Query about the children Who inherit the discount
        $child = Menu::where('menu_id', $menu->id)->where('discount', $menu->discount)->get();
        // Collection of the affected children
        $affectedArray = array();

        foreach ($child as $SubChild) {
            $subChild = Menu::where('menu_id', $SubChild->id)->where('discount', $SubChild->discount)->get();
            $affectedArray[] = $SubChild->id;

            foreach ($subChild as $SubSubChild) {
                $subChild = Menu::where('menu_id', $SubSubChild->id)->where('discount', $SubSubChild->discount)->get();
                $affectedArray[] = $SubSubChild->id;

                foreach ($subChild as $SubSubSubChild) {
                    $affectedArray[] = $SubSubSubChild->id;
                }
            }
        }
        // Update the affected submenus
        DB::table('menus')->whereIn('id', $affectedArray)
            ->update(['discount' => $request->discount]);
        // Update affected items
        DB::table('items')->whereIn('menu_id', $affectedArray)->where('discount', $menu->discount)
            ->update(['discount' => $request->discount]);

        // Update the selected sub menu
        $menu = $menu->update($request->all());

        if ($menu) {
            return response()->json(['message' => 'Updated Successfully']);
        }
    }

    public function destroy(Menu $menu)
    {
        $menuHasChildrenMenu  = $menu->children->count() > 0;
        // Prevent destroy if the menu has children menu
        if ($menuHasChildrenMenu ) {
            return response()->json(['message' => 'The menu has children Menu cannot be deleted']);
        }

        $menu = $menu->delete();
        if ($menu) {
            return response()->json(['message' => 'Deleted Successfully']);
        }
    }
}
