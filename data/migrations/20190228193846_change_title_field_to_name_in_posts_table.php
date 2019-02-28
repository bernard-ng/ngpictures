<?php


use Phinx\Migration\AbstractMigration;

class ChangeTitleFieldToNameInPostsTable extends AbstractMigration
{

    public function change()
    {
        $this->table('posts')
            ->renameColumn('title', 'name')
            ->update();
    }
}
