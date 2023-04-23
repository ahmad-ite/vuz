<?php

use Phinx\Seed\AbstractSeed;
use Faker\Factory as Faker;

class Users extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $faker = Faker::create();
        $data = [
            [
                'name' => 'Test User',
                'email' => 'user3@test.com',
                'phone' => $faker->phoneNumber,
                'password' => password_hash('password', null),
                'created_at' => date('Y-m-d H:i:s'),
                'email_verified_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($data as $elem) {
            try {
                $this->insert('users', $elem);
            } catch (\Throwable $th) { //email dublicated
                //throw $th;
            }
        }
    }
}
