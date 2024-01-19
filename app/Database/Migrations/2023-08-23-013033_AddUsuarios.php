<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddUsuario extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_usuario' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '80',
            ],
            'senha' => [
                'type'       => 'CHAR',
                'constraint' => '60',
            ],
            'tipo_usuario' => [
                'type' => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'token_verificacao' => [
                'type' => 'CHAR',
                'constraint' => '64',
                'null' => true,
            ],
            'token_recuperacao' => [
                'type' => 'CHAR',
                'constraint' => '64',
                'null' => true,
                'default' => null
            ],
            'blocked' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'saldo' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
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
        $this->forge->addKey('id_usuario', true);
        $this->forge->addForeignKey('tipo_usuario', 'tipos_usuario', 'id_tipo');
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}
