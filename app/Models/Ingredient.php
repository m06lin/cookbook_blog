<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'ingredients';

    protected $fillable = [
        'id', 
        'name',
        'calories',
        'quantity',
        'unit',
        'amount'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
