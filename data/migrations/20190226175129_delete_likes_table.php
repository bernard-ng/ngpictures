<?php


use Phinx\Migration\AbstractMigration;

class DeleteLikesTable extends AbstractMigration
{

    public function change()
    {
        $this->execute("DELETE FROM likes WHERE likes.posts_id IS NULL");
        $this->table('likes')
            ->renameColumn('date_created', 'created_at')
            ->removeColumn('blog_id')
            ->removeColumn('gallery_id')
            ->update();
    }
}
