<?php


use Phinx\Migration\AbstractMigration;

class UpdateSavesTable extends AbstractMigration
{

    public function change()
    {
        $this->execute("DELETE FROM saves WHERE saves.posts_id IS NULL");
        $this->table('saves')
            ->renameColumn('date_created', 'created_at')
            ->removeColumn('blog_id')
            ->removeColumn('gallery_id')
            ->update();
    }
}
