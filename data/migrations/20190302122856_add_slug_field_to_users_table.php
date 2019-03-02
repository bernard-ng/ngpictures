<?php


use Phinx\Migration\AbstractMigration;

class AddSlugFieldToUsersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('users')
            ->addColumn('slug', 'string', ['limit' => 300, 'null' => true])
            ->update();
    }
}
