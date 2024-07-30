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
        \DB::table('Users')->insert(
            [[
                'email' => 'test@example.com',
                'passwordHash' => password_hash(trim('12345678'), PASSWORD_DEFAULT),//'2y$10$dzz.w1CSzAyecKbzTOGFyeCYDB..Pb8qIgtTCe/WYWiRB9vetnv9m',
                'firstName' => 'test',
                'lastName' => 'example',
                'roleID' => 1,
                'isActive' => 1,
            ],
            [
                'email' => 'test2@example2.com',
                'passwordHash' => password_hash(trim('12345678'), PASSWORD_DEFAULT),//'$2y$10$oWSin7V2.LIsX4/z76xrJeApfu8sll4AxOMRLLxWPdTM7.Xvr3v8.',
                'firstName' => 'test2',
                'lastName' => 'example2',
                'roleID' => 2,
                'isActive' => 1,
            ],
            [
                'email' => 'test3@example3.com',
                'passwordHash' => '',
                'firstName' => 'test3',
                'lastName' => 'example3',
                'roleID' => 4,
                'isActive' => 0,
            ],
            [
                'email' => 'test4@example4.com',
                'passwordHash' => password_hash(trim('12345678'), PASSWORD_DEFAULT),//'$2y$10$U7OnVkq2Ya8e7TvSqPhkBOob4uIdGH5S0cn4vrLlU7q9IWMv01HMq',
                'firstName' => 'test4',
                'lastName' => 'example4',
                'roleID' => 3,
                'isActive' => 1,
            ],
            [
                'email' => 'test5@example5.com',
                'passwordHash' => '',
                'firstName' => 'test5',
                'lastName' => 'example5',
                'roleID' => 2,
                'isActive' => 0,
            ],
            [
                'email' => 'test6@example6.com',
                'passwordHash' => password_hash(trim('12345678'), PASSWORD_DEFAULT),//'$2y$10$FUJIs7RbijP1DoQb4N9a.efaZH4XRJdtO3byXMSUm/BL8jyXQi6XS',
                'firstName' => 'test6',
                'lastName' => 'example6',
                'roleID' => 4,
                'isActive' => 1,
            ],
            [
                'email' => 'test7@example7.com',
                'passwordHash' => '',
                'firstName' => 'test7',
                'lastName' => 'example7',
                'roleID' => 4,
                'isActive' => 0,
            ],
            [
                'email' => 'test10@example10.com',
                'passwordHash' => '',
                'firstName' => 'test10',
                'lastName' => 'example10',
                'roleID' => 2,
                'isActive' => 0,
            ]]
        );
    }
}
