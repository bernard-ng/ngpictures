<?php


use Phinx\Migration\AbstractMigration;

class RenameAlbumsToCollectionInPostsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('posts')
            ->renameColumn('albums_id', 'collections_id')
            ->update();
    }
}
