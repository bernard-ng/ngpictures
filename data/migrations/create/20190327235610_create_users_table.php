<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

/**
 * Class CreateUsersTable
 */
class CreateUsersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('users')
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('slug', 'string', ['limit' => 300])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('phone', 'string', ['limit' => 20])
            ->addColumn('bio', 'string', ['limit' => 300, 'default' => "Hey I'm using Ngpictures"])
            ->addColumn('avatar', 'string', ['limit' => 500, 'default' => "/uploads/avatars/default.jpg"])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('role', 'string', ['limit' => 10, 'default' => 'user'])
            ->addColumn('verified', 'boolean', ['default' => 0])
            ->addColumn('confirmation_token', 'string', ['limit' => 65, 'null' => true])
            ->addColumn('confirmed_at', 'datetime', ['null' => true])
            ->addColumn('reset_token', 'string', ['limit' => 65, 'null' => true])
            ->addColumn('reset_at', 'datetime', ['null' => true])
            ->addColumn('remember_token', 'string', ['limit' => 65, 'null' => true])
            ->addColumn('facebook_url', 'string', ['limit' => 300, 'null' => true])
            ->addColumn('instagram_url', 'string', ['limit' => 300, 'null' => true])
            ->addColumn('website_url', 'string', ['limit' => 300, 'null' => true])
            ->addColumn('country', 'string', ['limit' => 300, 'null' => true])
            ->addColumn('private', 'boolean', ['default' => 0])
            ->create();
    }
}
