<?php


use Phinx\Seed\AbstractSeed;

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
        $data = [
            [
                'name' => 'Test User',
                'email' => 'user@test.com',
                'password' => 'password',
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