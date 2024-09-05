<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        \DB::table('users')->insert(
            [[
                'email' => 'test@example.com',
                'password' => password_hash(trim('12345678'), PASSWORD_DEFAULT),//'2y$10$dzz.w1CSzAyecKbzTOGFyeCYDB..Pb8qIgtTCe/WYWiRB9vetnv9m',
                'first_name' => 'test',
                'last_name' => 'example',
                'role_id' => 1,
                'is_active' => 1,
            ],
            [
                'email' => 'test2@example2.com',
                'password' => password_hash(trim('12345678'), PASSWORD_DEFAULT),//'$2y$10$oWSin7V2.LIsX4/z76xrJeApfu8sll4AxOMRLLxWPdTM7.Xvr3v8.',
                'first_name' => 'test2',
                'last_name' => 'example2',
                'role_id' => 2,
                'is_Active' => 1,
            ],
            [
                'email' => 'test3@example3.com',
                'password' => '',
                'first_name' => 'test3',
                'last_name' => 'example3',
                'role_id' => 4,
                'is_active' => 0,
            ],
            [
                'email' => 'test4@example4.com',
                'password' => password_hash(trim('12345678'), PASSWORD_DEFAULT),//'$2y$10$U7OnVkq2Ya8e7TvSqPhkBOob4uIdGH5S0cn4vrLlU7q9IWMv01HMq',
                'first_name' => 'test4',
                'last_name' => 'example4',
                'role_id' => 3,
                'is_active' => 1,
            ],
            [
                'email' => 'test5@example5.com',
                'password' => '',
                'first_name' => 'test5',
                'last_name' => 'example5',
                'role_id' => 2,
                'is_active' => 0,
            ],
            [
                'email' => 'test6@example6.com',
                'password' => password_hash(trim('12345678'), PASSWORD_DEFAULT),//'$2y$10$FUJIs7RbijP1DoQb4N9a.efaZH4XRJdtO3byXMSUm/BL8jyXQi6XS',
                'first_name' => 'test6',
                'last_name' => 'example6',
                'role_id' => 4,
                'is_active' => 1,
            ],
            [
                'email' => 'test7@example7.com',
                'password' => '',
                'first_name' => 'test7',
                'last_name' => 'example7',
                'role_id' => 4,
                'is_active' => 0,
            ],
            [
                'email' => 'test10@example10.com',
                'password' => '',
                'first_name' => 'test10',
                'last_name' => 'example10',
                'role_id' => 2,
                'is_active' => 0,
            ]]
        );
    }
}
