<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      App\User::create([
        'name' => 'Julian Daniel',
        'email' => 'jdiaz@tiqal.com',
        'password' => bcrypt('12345678'),
        'type' => 1
      ]);

      App\User::create([
        'name' => 'Luisa',
        'email' => 'lramirez@tiqal.com',
        'password' => bcrypt('12345678'),
        'type' => 0
      ]);

      App\User::create([
        'name' => 'Yuber',
        'email' => 'ylopez@solution.com',
        'password' => bcrypt('12345678'),
        'type' => 1
      ]);


      // factory(App\post::class, 24)->create();
        // $this->call(UsersTableSeeder::class);
    }
}
