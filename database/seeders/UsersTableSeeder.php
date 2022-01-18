<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;
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
        $menu = Menus::create(['name' => 'Roles List']);
        $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
        ];
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission, 'menu_id' => $menu->id, 'menu_name' => $menu->name]);
        }

        $menu = Menus::create(['name' => 'Users List']);
        $permissions = [
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
        ];
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission, 'menu_id' => $menu->id, 'menu_name' => $menu->name]);
        }

        $menu = Menus::create(['name' => 'Permissions']);
        $permissions = [
           'permission-list',
           'permission-create',
           'permission-edit',
           'permission-delete',
        ];
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission, 'menu_id' => $menu->id, 'menu_name' => $menu->name]);
        }

        $menu = Menus::create(['name' => 'Perusahaan']);
        $datas = [
           'perusahaan-list',
           'perusahaan-create',
           'perusahaan-edit',
           'perusahaan-delete',
        ];
        foreach ($datas as $row) {
             Permission::create(['name' => $row, 'menu_id' => $menu->id, 'menu_name' => $menu->name]);
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