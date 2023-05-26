<?php

namespace App\Repository\Admin\User;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository
{

     public function storeUser(Request $request,array $data)
     {
        $user = new User();
        $user->name = $request->input('name');
        $user->phone1 = $request->input('phone1');
        $user->phone2 = $request->input('phone2');
        $user->address1 = $request->input('address1');
        $user->address2 = $request->input('address2');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->password);
        $user->save();
     }

     public function updateUser(Request $request,User $user, array $data)
     {
        $user->name = $request->input('name');
        $user->phone1 = $request->input('phone1');
        $user->phone2 = $request->input('phone2');
        $user->address1 = $request->input('address1');
        $user->address2 = $request->input('address2');
        $user->update();
     }

     public function deleteUser(User $user)
     {
        $user->delete();
     }

}