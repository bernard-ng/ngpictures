<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

use Phinx\Migration\AbstractMigration;

/**
 * Class CreateNotificationTable
 */
class CreateNotificationTable extends AbstractMigration
{

    public function change()
    {
        $this->table('notifications')
            ->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('body', 'string', ['limit' => 255])
            ->addColumn('users_id', 'integer')
            ->addForeignKey('users_id', 'users', 'id')
            ->addColumn('action_url', 'string', ['limit' => 500, 'null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('read', 'boolean', ['default' => 0])
            ->create();
    }
}
