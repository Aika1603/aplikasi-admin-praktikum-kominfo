<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;
use App\Action;
use App\Menus;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Action::create(['name' => 'list', 'desc' => '']);
        Action::create(['name' => 'create', 'desc' => '']);
        Action::create(['name' => 'edit', 'desc' => '']);
        Action::create(['name' => 'delete', 'desc' => '']);

        $menu = Menus::create(['name' => 'Roles List']);
        $permissions = [
           'roles-list',
           'roles-create',
           'roles-edit',
           'roles-delete',
        ];
        $i = 1;
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission, 'menu_id' => $menu->id, 'action_id' => $i]);
             $i++;
        }

        $menu = Menus::create(['name' => 'Users List']);
        $permissions = [
           'users-list',
           'users-create',
           'users-edit',
           'users-delete',
        ];
        $i = 1;
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission, 'menu_id' => $menu->id, 'action_id' => $i]);
             $i++;
        }

        $menu = Menus::create(['name' => 'Permissions']);
        $permissions = [
           'permissions-list',
           'permissions-create',
           'permissions-edit',
           'permissions-delete',
        ];
        $i = 1;
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission, 'menu_id' => $menu->id, 'action_id' => $i]);
             $i++;
        }

        $menu = Menus::create(['name' => 'Menus']);
        $datas = [
           'menus-list',
           'menus-create',
           'menus-edit',
           'menus-delete',
        ];
        $i = 1;
        foreach ($datas as $row) {
             Permission::create(['name' => $row, 'menu_id' => $menu->id, 'action_id' => $i]);
             $i++;
        }

        $menu = Menus::create(['name' => 'Actions']);
        $datas = [
           'actions-list',
           'actions-create',
           'actions-edit',
           'actions-delete',
        ];
        $i = 1;
        foreach ($datas as $row) {
             Permission::create(['name' => $row, 'menu_id' => $menu->id, 'action_id' => $i]);
             $i++;
        }
        
        $menu = Menus::create(['name' => 'Perusahaan']);
        $datas = [
           'perusahaans-list',
           'perusahaans-create',
           'perusahaans-edit',
           'perusahaans-delete',
        ];
        $i = 1;
        foreach ($datas as $row) {
             Permission::create(['name' => $row, 'menu_id' => $menu->id, 'action_id' => $i]);
             $i++;
        }


        $user = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'asep.saepul205@gmail.com',
            'phone_number' => '089648338115',
            'email_verified_at' => now(),
            'password' => bcrypt('123123123'),
        ]);
  
        $role = Role::create(['name' => 'admin']);
   
        $permissions = Permission::pluck('id','id')->all();
  
        $role->syncPermissions($permissions);
   
        $user->assignRole([$role->id]);
    }
}