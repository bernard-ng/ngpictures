<?php


use Phinx\Migration\AbstractMigration;

class UpdateFollowingTable extends AbstractMigration
{

    public function change()
    {
        $this->table('following')
            ->renameColumn('date_created', 'created_at')
            ->update();
    }
}
