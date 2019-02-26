<?php


use Phinx\Migration\AbstractMigration;

class DeleteVersesTable extends AbstractMigration
{

    public function change()
    {
        $this->execute("DROP TABLE IF EXISTS verses");
    }
}
