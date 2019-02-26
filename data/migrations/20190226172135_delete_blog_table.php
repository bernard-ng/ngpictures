<?php


use Phinx\Migration\AbstractMigration;

class DeleteBlogTable extends AbstractMigration
{

    public function change()
    {
        $this->execute("DROP TABLE IF EXISTS blog");
    }
}
