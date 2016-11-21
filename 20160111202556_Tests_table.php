<?php

use Phinx\Migration\AbstractMigration;

class TestsTable extends AbstractMigration
{
    public function up()
    {
       
        $user_table = $this->table('users');
        $user_table->addColumn('first_name', 'string')
            ->addColumn('last_name', 'string')
            ->addColumn('email', 'string')
            ->addColumn('phone', 'string')
            ->create();


       
        $user_table->insert([
            ["first_name" => "Hamdan",
                "last_name" => "Taima",
                "email" => "ht-3@Hotmail.com",
                "phone" => "00970-597-423-133",
            ]
        ]);
        $user_table->saveData();

        $orders_table = $this->table('orders');
        $orders_table->addColumn('order_total', 'integer')
            ->addColumn('orderDate', 'datetime')
            ->addColumn('orderStatus', 'boolean')
            ->addColumn('user_id', 'integer')
            ->addForeignKey('user_id', 'users', 'id')
            ->create();

          $orders_table->insert([
            ["orderDate" => "2016-11-08 00:00:00",
                "orderStatus" => "1",
                "user_id" => "1"
            ]
        ]);
        $orders_table->saveData();      
        

    }

    public function down() {       
        $this->dropTable('orders');
         $this->dropTable('users');
    }
}
