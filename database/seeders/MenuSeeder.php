<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name' => 'cat (1',
                'discount' => 10,
                'type' => 'category',
                'menu_id' => null,
            ],
            [
                'name' => 'cat (2',
                'discount' => null,
                'type' => 'category',
                'menu_id' => null,
            ],
            [
                'name' => 'cat (3',
                'discount' => 10,
                'type' => 'item',
                'menu_id' => 1,
            ],
            [
                'name' => 'cat (4',
                'discount' => 10,
                'type' => 'category',
                'menu_id' => 1,
            ],
            [
                'name' => 'cat (5',
                'discount' => 20,
                'type' => 'item',
                'menu_id' => 4,
            ],
            [
                'name' => 'cat (6',
                'discount' => 10,
                'type' => 'category',
                'menu_id' => 4,
            ],
            [
                'name' => 'cat (7',
                'discount' => 10,
                'type' => 'item',
                'menu_id' => 6,
            ],
            [
                'name' => 'cat (8',
                'discount' => 30,
                'type' => 'category',
                'menu_id' => 6,
            ],
            [
                'name' => 'cat (9',
                'discount' => 30,
                'type' => 'category',
                'menu_id' => 6,
            ],
        ];
        Menu::insert($menus);
    }
}
