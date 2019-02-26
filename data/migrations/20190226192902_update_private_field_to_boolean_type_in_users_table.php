<?php


use Phinx\Migration\AbstractMigration;

class UpdatePrivateFieldToBooleanTypeInUsersTable extends AbstractMigration
{

    public function change()
    {
        $this->execute("UPDATE users SET users.private = 0");
        $this->table('users')
            ->changeColumn('private', 'boolean', ['default' => '0'])
            ->update();
    }
}
