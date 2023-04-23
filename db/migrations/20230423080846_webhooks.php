<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Webhooks extends AbstractMigration
{

    public function up(): void
    {
        $table = $this->table('webhooks', ['id' => false]);
        $table->addColumn('id', 'biginteger', ['identity' => true])
            ->addIndex('id', ['unique' => true])
            ->addColumn('event', 'string', ['null' => false])
            ->addColumn('action', 'string', ['null' => false])
            ->addColumn('referenc_id', 'string', ['null' => false])
            ->addColumn('subscription_id', 'biginteger', ['null' => false])

            ->addColumn('partner_id', 'biginteger', ['null' => true])

            ->addColumn('amount', 'decimal', ['null' => true, 'precision' => 10, 'scale' => 2])
            ->addColumn('currency', 'string', ['null' => true])
            ->addColumn('email', 'string', ['null' => true])


            ->addColumn('description', 'string', ['null' => true])
            ->addColumn('error', 'string', ['null' => true])
            ->addColumn('payload', 'json', ['null' => false, 'limit' => 255])

            ->addTimestamps()
            ->addIndex(['event', 'action', 'partner_id'])
            ->create();
    }

    public function down(): void
    {
        $this->dropTable('webhooks', true);
    }
}