<?php

namespace App\Repository\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;

interface IUserRepository
{
     public function storeUser(Request $request, array $data);

     public function updateUser(Request $request, User $user, array $data);

     public function deleteUser(User $user);
}