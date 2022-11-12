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
}
