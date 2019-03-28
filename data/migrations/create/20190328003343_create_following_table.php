<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

use Phinx\Migration\AbstractMigration;

/**
 * Class CreateFollowingTable
 */
class CreateFollowingTable extends AbstractMigration
{
    public function change()
    {
        $this->table('following')
            ->addColumn('follower_id', 'integer')
            ->addColumn('followed_id', 'integer')
            ->addColumn('created_at', 'datetime')
            ->addForeignKey('follower_id', 'users', 'id')
            ->addForeignKey('followed_id', 'users', 'id')
            ->create();
    }
}
