<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class EndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'end-user']);
    }
}
