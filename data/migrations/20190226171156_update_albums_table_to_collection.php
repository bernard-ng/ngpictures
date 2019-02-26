<?php


use Phinx\Migration\AbstractMigration;

class UpdateAlbumsTableToCollection extends AbstractMigration
{

    public function change()
    {
        $this->table('albums')
            ->rename('collections')
            ->renameColumn('date_created', 'created_at')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addColumn('private', 'boolean', ['default' => '0'])
            ->addColumn('users_id', 'integer', ['default' => '1'])
            ->renameColumn('title', 'name')
            ->removeColumn('status')
            ->update();
    }
}
