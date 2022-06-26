<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getRecipts($id)
    {
        return $this->model->find($id)->with('recipes')->first();
    }

    public function list($condition = [])
    {
        $query = $this->model->query();

        if (isset($condition['id'])) {
            $query = $query->whereIn('id', $condition['id']);
        }

        if (isset($condition['username'])) {
            $query = $query->where('username', $condition['username']);
        }

        return $query->get();
    }

    public function create($username, $password)
    {
        return $this->model->create([
            'username' => $username,
            'password' => bcrypt($password)
        ]);
    }

    public function update($id, $newPassword)
    {
        $type = $this->model->find($id);
        $type->password = bcrypt($newPassword);
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
