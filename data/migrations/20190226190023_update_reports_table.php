<?php


use Phinx\Migration\AbstractMigration;

class UpdateReportsTable extends AbstractMigration
{
    public function change()
    {
        $this->execute("DELETE FROM reports");
        $this->table('reports')
            ->renameColumn('date_created', 'created_at')
            ->renameColumn('publication_id', 'posts_id')
            ->removeColumn('type')
            ->renameColumn('content', 'report')
            ->update();
    }
}
