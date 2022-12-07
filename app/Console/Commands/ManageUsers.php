<?php

namespace App\Console\Commands;

use Exception;
use App\Models\User;
use Illuminate\Console\Command;

class ManageUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manage:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create/modify/delete user account';

    private $actions;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->init();

        do {
            $isFinish = $this->operate();
        } while (!$isFinish);
    }

    private function init()
    {
        $this->actions = collect([
            ['key' => 'lu', 'name' => 'List User', 'action' => 'listUsers'],
            ['key' => 'cu', 'name' => 'Create User', 'action' => 'createUser'],
            ['key' => 'pw', 'name' => 'Change PWD', 'action' => 'changePassword'],
            ['key' => 'du', 'name' => 'Delete User', 'action' => 'deleteUser']
        ]);
    }

    private function operate()
    {
        $options = $this->actions->merge([
            ['key' => 'qt', 'name' => 'Exit']
        ])->pluck('name', 'key')->map(function ($actionName) {
            return $actionName;
        });

        $selected = $this->choice('Action', $options->toArray(), 'qt');

        if ($selected == 'qt') {
            return true;
        }

        $action = $this->actions->pluck('action', 'key')->get($selected);
        call_user_func([$this, $action]);

        return false;
    }

    private function listUsers()
    {
        $users = User::all();

        $header = [
            'id',
            'username',
            'created_at',
            'updated_at'
        ];

        $this->table($header, $users->toArray());
    }

    private function createUser()
    {
        $username = $this->ask('Enter new username');
        $password = $this->askPassword();

        if (isset($password)) {
            try {
                $user = User::create([
                    'username' => $username,
                    'password' => bcrypt($password)
                ]);
                $this->comment('Success!');
            } catch (Exception $e) {
                $this->comment('Fail!');
                $this->line($e->getMessage());
            }
        }
    }

    private function changePassword()
    {
        $chosenUser = $this->choiceUser('Change Password');
        $password = $this->askPassword();

        if (isset($password)) {
            try {
                $chosenUser->password = bcrypt($password);
                $chosenUser->save();
                $this->comment('Success!');
            } catch (Exception $e) {
                $this->comment('Fail!');
                $this->line($e->getMessage());
            }
        }
    }

    private function askPassword()
    {
        $password = $this->secret('Enter password');
        $passwordConfirm = $this->secret('Enter again');
        if ($password == $passwordConfirm) {
            return $password;
        } else {
            $this->comment('The second is not the same!');
            return null;
        }
    }

    private function deleteUser()
    {
        $chosenUser = $this->choiceUser('Delete');
        if ($chosenUser && $this->confirm("Confirm delete {$chosenUser->username} ?")) {
            $chosenUser->delete();
        }
    }

    private function choiceUser($action = '')
    {
        $users = User::all();
        $userMap = $users->mapWithKeys(function ($user) {
            return [$user->id => $user->username];
        })->toArray();
        $username = $this->choice("Please chose {$action} id", $userMap);
        $chosenUser = $users->first(function ($user) use ($username) {
            return $user->username == $username;
        });
        return $chosenUser;
    }
}
