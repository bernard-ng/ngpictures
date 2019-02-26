<?php


use Phinx\Migration\AbstractMigration;

class DeleteIdeasTable extends AbstractMigration
{

    public function change()
    {
        $this->execute("DROP TABLE IF EXISTS ideas");
    }
}
