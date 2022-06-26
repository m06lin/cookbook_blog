<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DishType extends Model
{
    protected $table = 'dish_types';

    protected $fillable = [
        'id', 
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    
}
