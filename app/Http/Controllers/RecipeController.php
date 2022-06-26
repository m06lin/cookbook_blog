<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Services\RecipeService;

class RecipeController extends Controller
{
    private $service;
    public function __construct(RecipeService $service)
    {
        $this->service = $service;
    }

    public function query(Request $request)
    {
        $limit = $request->get('limit', 10);
        $page = $request->get('page', 1);
        $recipeName = $request->get('recipe_name') ?? null;
        $dishTypes = $request->get('dish_types') ?? null;

        $condition = [];
        if (isset($recipeName)) {
            $condition['name'] = $recipeName;
        }
        if (isset($dishTypes)) {
            $condition['dish_type_id'] =  explode(',', $dishTypes);
        }

        $results = $this->service->page($limit, $page, $condition);

        return $this->toJsonResponse(200, $results, 'success');
    }
}
