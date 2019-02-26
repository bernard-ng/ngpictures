<?php


use Phinx\Migration\AbstractMigration;

class DeleteBugsTable extends AbstractMigration
{

    public function change()
    {
        $this->execute("DROP TABLE IF EXISTS bugs");
    }
}
