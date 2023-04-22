<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PartnerServices extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('partner_services', ['id' => false]);
        $table->addColumn('id', 'biginteger', ['identity' => true, 'null' => false])
            ->addIndex('id', ['unique' => true])
            ->addColumn('name', 'string', ['null' => false])
            ->addColumn('icon', 'string')
            ->addColumn('partner_id', 'biginteger', ['null' => false])
            ->addForeignKey('partner_id', 'partners', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addIndex('partner_id')
            ->addTimestamps()
            ->addColumn('deleted_at', 'datetime', ['null' => true])
            ->create();
    }

    public function down(): void
    {
        $this->dropTable('partner_services', true);
    }
}