<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Reset cached roles and permissions
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         $accessUser = 'access user';
         $addUser = 'add user';
         $editUser = 'edit user';
         $deleteUser = 'delete user';
         $searchUser = 'search user';

         $accessProduct = 'access product';
         $addProduct = 'add product';
         $editProduct = 'edit product';
         $deleteProduct = 'delete product';
         $searchProduct = 'search product';

         $accessCategory = 'access category';
         $addCategory = 'add category';
         $editCategory = 'edit category';
         $deleteCategory = 'delete category';
         $searchCategory = 'search category';

         $accessCart = 'access cart';
         $addCart = 'add cart';
         $removeCart = 'remove cart';

         $accessOrder = 'access order';
         $addOrder = 'add order';

         $accessOrderItem = 'access orderItem';

         $accessCompany = 'access company';
         $addCompany = 'add company';
         $editCompany = 'edit company';
         $deleteCompany = 'delete company';
         $searchCompany = 'search company';

         $editSetting = 'edit setting';

         //...permission..//
         Permission::create(['name' => $accessUser]);
         Permission::create(['name' => $addUser]);
         Permission::create(['name' => $editUser]);
         Permission::create(['name' => $deleteUser]);
         Permission::create(['name' => $searchUser]);

         Permission::create(['name' => $accessCategory]);
         Permission::create(['name' => $addCategory]);
         Permission::create(['name' => $editCategory]);
         Permission::create(['name' => $deleteCategory]);
         Permission::create(['name' => $searchCategory]);

         Permission::create(['name' => $accessProduct]);
         Permission::create(['name' => $addProduct]);
         Permission::create(['name' => $editProduct]);
         Permission::create(['name' => $deleteProduct]);
         Permission::create(['name' => $searchProduct]);

         Permission::create(['name' => $accessCart]);
         Permission::create(['name' => $addCart]);
         Permission::create(['name' => $removeCart]);

         Permission::create(['name' => $accessOrder]);
         Permission::create(['name' => $addOrder]);

         Permission::create(['name' => $accessOrderItem]);
         
         Permission::create(['name' => $accessCompany]);
         Permission::create(['name' => $addCompany]);
         Permission::create(['name' => $editCompany]);
         Permission::create(['name' => $deleteCompany]);
         Permission::create(['name' => $searchCompany]);
        
         Permission::create(['name' => $editSetting]);

         //..Role..//
         $admin = 'admin';
         $customer = 'customer';

         Role::create(['name' => $admin])->givePermissionTo(Permission::all());

         Role::create(['name' => $customer])->givePermissionTo([
            $accessCart,
            $addCart,
            $removeCart,
            $accessOrder,
            $addOrder,
            $accessOrderItem,
         ]);
    }
}
