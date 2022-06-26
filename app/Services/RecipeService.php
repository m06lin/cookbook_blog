<?php
namespace App\Services;

use App\Repositories\RecipeRepository;

class RecipeService
{
    private $rep;
    public function __construct(RecipeRepository $rep)
    {
        $this->rep = $rep;
    }

    public function page($limit, $page, $condition)
    {
        $results = json_decode($this->rep->page($limit, $page, $condition));
        $pageList = array_values($results->data);
        $lists = collect($pageList)->map(function ($info) {
            $calories = 0;
            $amount = 0;
            return [
                'id' => $info->id,
                'name' => $info->name,
                'dish_type' => $info->dish_type->name,
                'ingredient_list' => collect($info->ingredients)->map(function ($ingredient) use (&$calories, &$amount) {
                    $unitCount = $ingredient->pivot->ingredient_quantity / $ingredient->quantity;
                    $calories += $unitCount * $ingredient->calories;
                    $amount += $unitCount * $ingredient->amount;
                    return [
                        'name' => $ingredient->name,
                        'unit' => $ingredient->unit,
                        'quantity' => $ingredient->pivot->ingredient_quantity
                    ];
                }),
                'calories' => ceil($calories),
                'cost' => ceil($amount),
            ];
        })->toArray();

        return [
            'total_count' => $results->total,
            'current_page' => $results->current_page,
            'last_page' => $results->last_page,
            'recipe_list' => $lists
        ];
    }
}