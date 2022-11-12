<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'name' => 'item (1',
                'discount' => 10,
                'price' => 100,
                'menu_id' => 3,
            ],
            [
                'name' => 'item (2',
                'discount' => 20,
                'price' => 100,
                'menu_id' => 3,
            ],
            [
                'name' => 'item (3',
                'discount' => 20,
                'price' => 100,
                'menu_id' => 5,
            ],
            [
                'name' => 'item (4',
                'discount' => 15,
                'price' => 100,
                'menu_id' => 5,
            ],
            [
                'name' => 'item (5',
                'discount' => 10,
                'price' => 100,
                'menu_id' => 7,
            ],
        ];
        Item::insert($items);
    }

}
