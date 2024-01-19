<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddLojas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_loja' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome_responsavel' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'razao_social' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nome_fantasia' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'cnpj_loja' => [
                'type' => 'VARCHAR',
                'constraint' => 190,
            ],
            'ie_loja' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'id_usuario' => [
                'type' => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'negociacao' => [
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
        $this->forge->addKey('id_loja', true);
        $this->forge->addForeignKey('id_usuario', 'usuarios', 'id_usuario');
        $this->forge->createTable('lojas');
    }

    public function down()
    {
        $this->forge->dropTable('lojas');
    }
}
