<?php


use Phinx\Migration\AbstractMigration;

/**
 * Class UpdatePostsTable
 */
class UpdatePostsTable extends AbstractMigration
{

    public function change()
    {
        $this->table('posts')
            ->addColumn('thumb_old', 'string', ['null' => true])
            ->addColumn('tags', 'string', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addColumn('albums_id', 'integer', ['null' => true])
            ->addColumn('oneline', 'boolean', ['default' => '1'])
            ->renameColumn('date_created', 'created_at')
        ->update();
    }
}
