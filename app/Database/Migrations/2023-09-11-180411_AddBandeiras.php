<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddBandeiras extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bandeira' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome_bandeira' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'nome_responsavel' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'cpf' => [
                'type'       => 'VARCHAR',
                'constraint' => '190',
            ],
            'id_usuario' => [
                'type' => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'razao_social' => [
                'type' => 'VARCHAR',
                'constraint'     => "100",
            ],
            'ie' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'cnpj' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'telefone' => [
                'type'       => 'VARCHAR',
                'constraint' => '45',
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
        $this->forge->addKey('id_bandeira', true);
        $this->forge->addForeignKey('id_usuario', 'usuarios', 'id_usuario');
        $this->forge->createTable('bandeiras');
    }

    public function down()
    {
        $this->forge->dropTable('bandeiras');
    }
}
