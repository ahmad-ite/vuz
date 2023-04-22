<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ServiceSubscriptionTypes extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('service_subscription_types', ['id' => false]);
        $table->addColumn('id', 'biginteger', ['identity' => true, 'null' => false])
            ->addIndex('id', ['unique' => true])

            ->addColumn('partner_service_id', 'biginteger', ['null' => false])
            ->addForeignKey('partner_service_id', 'partner_services', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])

            ->addColumn('subscription_type_id', 'biginteger', ['null' => false])
            ->addForeignKey('subscription_type_id', 'subscription_types', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])

            ->addIndex(['partner_service_id', 'subscription_type_id'])

            //reference_subscription_id is a subscription id that shared by the partner for this service
            ->addColumn('reference_subscription_id', 'string', ['null' => false])
            ->addIndex('reference_subscription_id', ['unique' => true])

            ->addColumn('price', 'decimal', ['null' => false, 'precision' => 10, 'scale' => 2])
            ->addColumn('currency', 'string', ['null' => false, 'default' => 'USD'])

            ->addTimestamps()
            ->create();
    }

    public function down(): void
    {
        $this->dropTable('service_subscription_types', true);
    }
}