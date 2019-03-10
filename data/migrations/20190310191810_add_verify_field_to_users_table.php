<?php


use Phinx\Migration\AbstractMigration;

class AddVerifyFieldToUsersTable extends AbstractMigration
{
    public function change()
    {
        $this->table('users')
            ->addColumn('verified', 'boolean', [
                'default' => '0'
            ])
            ->update();
    }
}
