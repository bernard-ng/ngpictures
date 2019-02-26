<?php


use Phinx\Migration\AbstractMigration;

class UpdateBookingTable extends AbstractMigration
{

    public function change()
    {
        $this->table('booking')
            ->addColumn('users_id', 'integer', ['default' => '1'])
            ->addColumn('created_at', 'datetime')
            ->renameColumn('date', 'booking_date')
            ->renameColumn('time', 'booking_time')
            ->addColumn('phone_number', 'string')
            ->update();
    }
}
