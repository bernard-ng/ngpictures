<?php


use Phinx\Migration\AbstractMigration;

class DeleteOnlineTable extends AbstractMigration
{

    public function change()
    {
        $this->execute("DROP TABLE IF EXISTS online");
    }
}
