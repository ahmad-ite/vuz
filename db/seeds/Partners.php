<?php


use Phinx\Seed\AbstractSeed;
use Faker\Factory as Faker;

class Partners extends AbstractSeed
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

        //seed Partners
        $data = [
            [
                'name' => 'Etisalat',
                'host' => 'https://example.com/',
                'key' => 'key',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($data as $elem) {
            try {
                $this->insert('partners', $elem);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }


        //seed Partner subscriptions
        $partner = $this->fetchRow('SELECT * FROM partners', [1]);
        if ($partner) {
            $data = [
                [
                    'name' =>  $faker->name,
                    'partner_id' => $partner['id'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ];

            foreach ($data as $elem) {
                try {
                    $this->insert('partner_services', $elem);
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }



        //seed Subscription Types

        $data = [
            [
                'name' =>  'Yearly',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($data as $elem) {
            try {
                $this->insert('subscription_types', $elem);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }


        //seed service subscription types 
        $partnerSubscription = $this->fetchRow('SELECT * FROM partner_services', [1]);
        $subscriptionType = $this->fetchRow('SELECT * FROM subscription_types', [1]);
        if ($partnerSubscription && $subscriptionType) {
            $data = [
                [
                    'partner_service_id' =>  $partnerSubscription['id'],
                    'subscription_type_id' => $subscriptionType['id'],


                    'reference_subscription_id' => 'reference_subscription_id',

                    'price' => 10,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ];

            foreach ($data as $elem) {
                try {
                    $this->insert('service_subscription_types', $elem);
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }
    }
}