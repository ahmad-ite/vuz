<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SubscriptionRequests extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('subscription_requests', ['id' => false]);
        $table->addColumn('id', 'biginteger', ['identity' => true, 'null' => false])

            ->addColumn('user_id', 'biginteger')
            // ->addForeignKey('user_id',  'users', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])

            ->addColumn('service_subscription_type_id', 'biginteger', ['null' => false])
            // ->addForeignKey('service_subscription_type_id',  'service_subscription_types', 'id', ['delete' => 'RESTRICT', 'update' => 'RESTRICT'])


            ->addColumn('status', 'integer', ['null' => false, 'default' => 1])

            ->addColumn('type', 'string', ['null' => false, 'default' => 'sub']) //sub-unsub

            //parent_subscription_request_id to strore subscription_request_id  linke to unsubscripe request
            ->addColumn('parent_subscription_request_id', 'biginteger', ['null' => true])
            // ->addForeignKey('parent_subscription_request_id',  'subscription_requests', 'id', ['delete' => 'RESTRICT', 'update' => 'RESTRICT'])

            ->addIndex(['id', 'status', 'type', 'user_id', 'service_subscription_type_id'])
            ->addTimestamps()
            ->addColumn('deleted_at', 'datetime', ['null' => true])
            ->create();


        $this->execute("ALTER TABLE subscription_requests PARTITION BY LIST (status)
            (PARTITION p_pending VALUES IN (1),
             PARTITION p_subscripe VALUES IN (2),
             PARTITION p_unubscripe VALUES IN (3))");
    }

    public function down(): void
    {
        $this->dropTable('subscription_requests', true);
    }
}
