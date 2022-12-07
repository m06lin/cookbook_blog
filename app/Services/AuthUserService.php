<?php
namespace App\Services;

use App\Repositories\UserRepository;

class AuthUserService
{
    private $user;
    private $rep;

    public function __construct(UserRepository $rep)
    {
        $this->user = auth('web')->user();
        $this->rep = $rep;
    }

    public function recipeList()
    {
        $id = $this->user->id;

        return $this->rep->getRecipts($id)->toArray();
    }

    public function changePassword($newPassword)
    {
        $id = $this->user->id;

        return $this->rep->update($id, $newPassword)->toArray();
    }
}
