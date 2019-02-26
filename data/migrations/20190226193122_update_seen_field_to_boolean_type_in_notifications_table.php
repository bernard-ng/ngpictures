<?php


use Phinx\Migration\AbstractMigration;

class UpdateSeenFieldToBooleanTypeInNotificationsTable extends AbstractMigration
{
    public function change()
    {
        $this->execute("UPDATE notifications  SET notifications.seen = 0 ");
        $this->table('notifications')
            ->changeColumn('seen', 'boolean', ['default' => '0'])
            ->update();
    }
}
