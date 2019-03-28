<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

use Phinx\Migration\AbstractMigration;

/**
 * Class CreateLikesTable
 */
class CreateLikesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('likes')
            ->addColumn('users_id', 'integer')
            ->addForeignKey('users_id', 'users', 'id')
            ->addColumn('posts_id', 'integer')
            ->addForeignKey('posts_id', 'posts', 'id')
            ->addColumn('created_at', 'datetime')
            ->create();
    }
}
