<?php


use Phinx\Migration\AbstractMigration;

class UpdateCategoriesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('categories')
            ->renameColumn('title', 'name')
            ->renameColumn('date_created', 'created_at')
            ->addColumn('update_at', 'datetime', ['null' => true])
            ->update();
    }
}
