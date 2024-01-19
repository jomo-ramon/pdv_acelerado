<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSaldo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_saldo' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'saldo' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => FALSE,
                'default' => 0.00
            ],
        ]);
        $this->forge->addKey('id_saldo', true);
        $this->forge->createTable('saldo');
    }

    public function down()
    {
        $this->forge->dropTable('saldo');
    }
}
