<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SubscriptionTypes extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('subscription_types', ['id' => false]);
        $table->addColumn('id', 'biginteger', ['identity' => true, 'null' => false])
            ->addIndex('id', ['unique' => true])
            ->addColumn('name', 'string', ['null' => false])
            ->addIndex('name', ['unique' => true])
            ->addColumn('icon', 'string')
            ->addTimestamps()
            ->addColumn('deleted_at', 'datetime', ['null' => true])
            ->create();
    }

    public function down(): void
    {
        $this->dropTable('subscription_types', true);
    }
}