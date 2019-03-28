<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

use Phinx\Migration\AbstractMigration;

/**
 * Class CreateCollectionsTable
 */
class CreateCollectionsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('collections')
            ->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('slug', 'string', ['limit' => 120])
            ->addColumn('description', 'string', ['limit' => 500])
            ->addColumn('users_id', 'integer')
            ->addForeignKey('users_id', 'users', 'id')
            ->addColumn('access_token', 'string', ['limit' => 65, 'null' => true])
            ->addColumn('private', 'boolean', ['default' => 0])
            ->addColumn('online', 'boolean', ['default' => 1])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->create();
    }
}
