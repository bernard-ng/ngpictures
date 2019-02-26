<?php


use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class UpdateUsersTable extends AbstractMigration
{

    public function change()
    {
        $this->table('users')
            ->addColumn('instagram_id', 'integer', ['limit' => MysqlAdapter::INT_BIG, 'null' => true])
            ->addColumn('instagram_auth_token', 'string', ['limit' => MysqlAdapter::INT_SMALL, 'null' => true])
            ->renameColumn('status', 'private')
            ->renameColumn('rank', 'role')
            ->renameColumn('phone', 'phone_number')
            ->update();
    }
}
