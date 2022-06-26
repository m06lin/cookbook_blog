<?php
namespace App\Repositories;

use App\Models\Recipe;

class RecipeRepository
{
    private $model;

    public function __construct(Recipe $model)
    {
        $this->model = $model;
    }

    public function page($limit = 10, $page = 1, $condition = [])
    {
        $query = $this->model->with(['dishType', 'ingredients']);

        if (isset($condition['name'])) {
            $query = $query->where('name', 'like', '%'.$condition['name'].'%');
        }

        if (isset($condition['dish_type_id'])) {
            $query = $query->whereIn('dish_type_id', $condition['dish_type_id']);
        }

        return $query->paginate(
            $perPage = $limit, $columns = ['*'], $pageName = 'page', $page = $page
        )->toJson();
    } 
}
