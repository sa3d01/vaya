<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Entities\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
           'name'=>'admin',
           'email'=>'admin@admin.com',
           'password'=>'secret',
        ]);
    }
}
