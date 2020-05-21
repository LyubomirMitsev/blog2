<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\User;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'manage blog categories']);
        Permission::create(['name' => 'manage blog posts']);
        Permission::create(['name' => 'approve comments']);

        $role->givePermissionTo(['name' => 'manage blog categories']);
        $role->givePermissionTo(['name' => 'manage blog posts']);
        $role->givePermissionTo(['name' => 'approve comments']);

        DB::table('users')->insert([
            'name' => 'Lyubomir Mitsev',
            'email' => 'lyubomir_mitzev@abv.bg',
            'password' => Hash::make('celticguardian'),
        ]);
        
        User::find(1)->assignRole('admin');
    }
}
