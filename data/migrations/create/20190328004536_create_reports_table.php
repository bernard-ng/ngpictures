<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

use Phinx\Migration\AbstractMigration;

/**
 * Class CreateReportsTable
 */
class CreateReportsTable extends AbstractMigration
{

    public function change()
    {
        $this->table('reports')
            ->addColumn('type', 'integer', ['limit' => 2, 'default' => 1])
            ->addColumn('description', 'string', ['limit' => 300, 'null' => true])
            ->addColumn('posts_id', 'integer')
            ->addForeignKey('posts_id', 'posts', 'id')
            ->create();
    }
}
