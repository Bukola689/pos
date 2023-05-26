<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\Admin\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $users = Cache::remember('users', 60, function () {

            if(! $users = User::with('roles')->paginate(5)) {

              return response()->json(['user not found']);
            }          
            
            if($users->isEmpty()) {
                return response()->json([
                    'error message' => 'User Not Found'
                ]);
            }
         });
       
        return response()->json([
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        $data = $request->all();

        $this->user->storeUser($request, $data);

        Cache::put('user', $data);

       return response()->json([
        'message' => 'User Saved Successfully'
       ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,User $user)
    {
        $userShow = Cache::remember('user:', $request->id, function() use($user) {
            return $user;
        });

        return response()->json([
            'status' => true,
            'user' => $userShow
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompanyRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'address1' => 'required',
            'address2' => 'required',
        ]);

        $data = $request->all();

        $this->user->updateUser($request, $user, $data);

        Cache::put('user', $data);

        return response()->json([
            'message' => 'User Updated Successfully'
           ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

      $this->user->deleteUser($user);  

        Cache::pull('user');

        if($user) {
            return response()->json([
                'message' => 'User Delelted Successfully !',
                'user' => $user,
            ]);
           }
    
           else {
            return response()->json([
                'status' => false,
                'message' => 'User Not Found !'
            ]);
           }
    }

    public function searchUser($search)
    {
        $user = User::where('name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($user) {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'user not found'
            ]);
        }
    }
}
