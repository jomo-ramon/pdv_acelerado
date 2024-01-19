<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSistema extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'chave_pix' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'lucro' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sistema');
    }

    public function down()
    {
        $this->forge->dropTable('sistema');   
    }
}
