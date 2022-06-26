<?php
namespace App\Repositories;

use App\Models\DishType;

class DishTypeRepository
{
    private $model;

    public function __construct(DishType $model)
    {
        $this->model = $model;
    }

    public function list($condition = [])
    {
        $query = $this->model->query();

        if (isset($condition['id'])) {
            $query = $query->whereIn('id', $condition['id']);
        }

        if (isset($condition['name'])) {
            $query = $query->where('name', 'like', '%'.$condition['name'].'%');
        }

        return $query->get();
    }

    public function create($name)
    {
        return $this->model->create(['name' => $name]);
    }

    public function update($id, $name)
    {
        $type = $this->model->find($id);
        $type->name = $name;
        $type->save();

        return $type;
    }

    public function delete($id)
    {
        $isSuccess = $this->model->destroy($id);

        return [
            'id' => $isSuccess ? $id : null
        ];
    }
}
