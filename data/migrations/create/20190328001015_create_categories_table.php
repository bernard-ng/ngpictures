<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

use Phinx\Migration\AbstractMigration;

/**
 * Class CreateCategoriesTable
 */
class CreateCategoriesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('categories')
            ->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('slug', 'string', ['limit' => 120])
            ->addColumn('description', 'string', ['limit' => 500])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->create();
    }
}
