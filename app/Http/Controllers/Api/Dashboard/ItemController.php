<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use App\Http\Resources\MenuResource;
use App\Models\Item;
use App\Models\Menu;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('menu:id,name')->get();
        return ItemResource::collection($items);
    }

    public function create()
    {
        $menus = Menu::where('type', 'item')->select(['id', 'name'])->get();
        return MenuResource::collection($menus);
    }

    public function store(StoreItemRequest $request)
    {
        // Query about the parent to know his type and discount.
        $parentMenu = Menu::where('id', $request->menu_id)->first();

        // Menu must not have mixed children
        // The parent menu only accepts the category.
        if ($parentMenu->type == 'category') {
            return response()->json(['message' => 'Item cannot be created. The parent menu only accepts the category.']);
        }
        // Inherit the discount item from the parent if the item does not have a discount.
        if ($request->menu_id != null && $request->discount == null) {
            $request->merge(['discount' => $parentMenu->discount]);
        }

        $item = Item::create($request->all());
        if($item) {
            return response()->json(['message' => 'Added Successfully']);
        }
    }

    public function show(Item $item)
    {
        return new ItemResource($item);
    }

    public function update(UpdateItemRequest $request, Item $item)
    {

        // Query about the parent to know his type.
        $parentMenu = Menu::where('id', $request->menu_id)->first();
        // The parent menu only accepts the category.
        if ($parentMenu->type == 'category') {
            return response()->json(['message' => 'Item cannot be updated. The parent menu only accepts the category.']);
        }
        // Update the selected item
        $item = $item->update($request->all());
        if ($item) {
            return response()->json(['message' => 'Updated Successfully']);
        }
    }

    public function destroy(Item $item)
    {
        $item = $item->delete();
        if ($item) {
            return response()->json(['message' => 'Deleted Successfully']);
        }
    }
}
