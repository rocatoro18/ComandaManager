<?php

namespace App\Repository;

use App\Models\User as ModelsUser;

class UserRepo implements IUserRepo
{
    function all(){
        $users = ModelsUser::all();
        return  $users;
    }
}