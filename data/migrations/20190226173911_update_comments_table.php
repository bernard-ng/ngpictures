<?php


use Phinx\Migration\AbstractMigration;

class UpdateCommentsTable extends AbstractMigration
{

    public function change()
    {
        $this->execute("DELETE FROM comments WHERE comments.posts_id IS NULL");
        $this->table('comments')
            ->renameColumn('date_created', 'created_at')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->removeColumn('blog_id')
            ->removeColumn('gallery_id')
            ->update();
    }
}
