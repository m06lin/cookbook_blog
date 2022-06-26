<?php
namespace App\Services;

use App\Repositories\DishTypeRepository;

class DishTypeService
{
    private $rep;
    public function __construct(DishTypeRepository $rep)
    {
        $this->rep = $rep;
    }

    public function list($condition)
    {
        return $this->rep->list($condition)->toArray();
    }

    public function create($name)
    {
        return $this->rep->create($name)->toArray();
    }

    public function update($id, $name)
    {
        return $this->rep->update($id, $name)->toArray();
    }

    public function delete($id)
    {
        return $this->rep->delete($id);
    }
}