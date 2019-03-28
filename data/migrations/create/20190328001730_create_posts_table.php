<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

/**
 * Class CreatePostsTable
 */
class CreatePostsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('posts')
            ->addColumn('name', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('slug', 'string', ['limit' => 300])
            ->addColumn('description', 'string', ['limit' => 500, 'null' => true])
            ->addColumn('thumb', 'string', ['limit' => 500])
            ->addColumn('exif', 'string', ['limit' => 1000, 'null' => true])
            ->addColumn('color', 'string', ['limit' => 10])
            ->addColumn('downloads_count', 'integer', ['limit' => MysqlAdapter::INT_REGULAR])
            ->addColumn('saves_count', 'integer', ['limit' => MysqlAdapter::INT_REGULAR])
            ->addColumn('likes_count', 'integer', ['limit' => MysqlAdapter::INT_REGULAR])
            ->addColumn('online', 'boolean', ['default' => 1])
            ->addColumn('categories_id', 'integer')
            ->addColumn('collections_id', 'integer')
            ->addColumn('users_id', 'integer')
            ->addForeignKey('users_id', 'users', 'id')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addColumn('tags', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('access_token', 'string', ['limit' => 65, 'null' => true])
            ->addColumn('private', 'boolean', ['default' => 0])
            ->create();
    }
}
