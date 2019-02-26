<?php


use Phinx\Migration\AbstractMigration;

class UpdateNotificationsTable extends AbstractMigration
{

    public function change()
    {
        $this->execute("DELETE FROM notifications");
        $this->table('notifications')
            ->renameColumn('date_created', 'created_at')
            ->renameColumn('status', 'seen')
            ->renameColumn('publication_id', 'posts_id')
            ->removeColumn('type')
            ->addColumn('action_link', 'string', ['null' => true])
            ->update();
    }
}