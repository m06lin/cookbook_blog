<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DishTypeService;

class DishTypeController extends Controller
{
    private $service;
    public function __construct(DishTypeService $service)
    {
        $this->service = $service;
    }

    public function list(Request $request, $id = null)
    {
        $name = $request->get('name') ?? null;

        $condition = [];
        if (isset($id)) {
            $condition['id'] = [$id];
        }

        if (isset($name)) {
            $condition['name'] = $name;
        }

        $results = $this->service->list($condition);

        return $this->toJsonResponse(200, $results, 'success');
    }

    public function create(Request $request)
    {
        $name = $request->get('name');

        $results = $this->service->create($name);

        return $this->toJsonResponse(200, $results, 'success');
    }

    public function update(Request $request, $id)
    {
        $name = $request->get('name');

        $results = $this->service->update($id, $name);

        return $this->toJsonResponse(200, $results, 'success');
    }

    public function delete(Request $request, $id)
    {
        $results = $this->service->delete($id);

        return $this->toJsonResponse(200, $results, 'success');
    }
}
