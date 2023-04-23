<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Users extends AbstractMigration
{

    public function up(): void
    {
        $table = $this->table('users', ['id' => false]);
        $table->addColumn('id', 'biginteger', ['identity' => true])
            ->addColumn('name', 'string', ['null' => false])
            ->addColumn('phone', 'string', ['null' => false])
            ->addColumn('email', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('password', 'string', ['null' => false])
            ->addColumn('created_at', 'date', ['default' => date('Y-m-d')])
            ->addColumn('email_verified_at', 'date')
            ->addIndex(['id', 'created_at'])
            ->addIndex(['email', 'created_at'], ['unique' => true])
            ->addColumn('deleted_at', 'datetime', ['null' => true])
            ->create();

        $this->execute("ALTER TABLE users PARTITION BY RANGE (YEAR(created_at))
            (PARTITION p0 VALUES LESS THAN (2020),
             PARTITION p1 VALUES LESS THAN (2021),
             PARTITION p2 VALUES LESS THAN (2022),
             PARTITION p3 VALUES LESS THAN (2023),
             PARTITION p4 VALUES LESS THAN (2024),
             PARTITION p5 VALUES LESS THAN MAXVALUE)");
    }

    public function down(): void
    {
        $this->dropTable('users', true);
    }
}
