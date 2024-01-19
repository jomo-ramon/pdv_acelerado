<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddTelefoneLoja extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_telefone_loja' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'num_telefone' => [
                'type'       => 'VARCHAR',
                'constraint' => '45',
            ],
            'is_whats' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
            ],
            'id_loja' => [
                'type' => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'created_at'  => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id_telefone_loja', true);
        $this->forge->addForeignKey('id_loja', 'lojas', 'id_loja');
        $this->forge->createTable('telefone_loja');
    }

    public function down()
    {
        $this->forge->dropTable('telefone_loja');
    }
}
