<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'discount', 'price', 'menu_id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
