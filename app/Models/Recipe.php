<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipes';

    protected $fillable = [
        'id',
        'name'
    ];

    protected $hidden = [
        'dish_type_id',
        'created_at',
        'updated_at'
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 
            'recipe_ingredient', 'recipe_id', 'ingredient_id')
            ->withPivot('ingredient_quantity');
    }

    public function dishType()
    {
        return $this->hasOne(DishType::class, 'id', 'dish_type_id');
    }
}
