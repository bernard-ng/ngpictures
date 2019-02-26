<?php


use Phinx\Migration\AbstractMigration;

class ChangeContentFieldToDescription extends AbstractMigration
{

    public function change()
    {
        $this->table('posts')
            ->addColumn('type', 'integer', ['limit' => 64, 'default' => '1', 'null' => true])
            ->renameColumn('content', 'description')
            ->update();
    }
}
