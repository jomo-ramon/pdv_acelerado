<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddEmailLoja extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_email_loja' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'email_loja' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->addKey('id_email_loja', true);
        $this->forge->addForeignKey('id_loja', 'lojas', 'id_loja');
        $this->forge->createTable('email_loja');
    }

    public function down()
    {
        $this->forge->dropTable('email_loja');
    }
}
