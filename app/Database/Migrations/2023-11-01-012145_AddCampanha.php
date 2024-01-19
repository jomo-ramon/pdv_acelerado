<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddCampanha extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_campanha' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome_campanha' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'data_inicio' => [
                'type'    => 'DATETIME',
            ],
            'data_final' => [
                'type'    => 'DATETIME',
            ],
            'descricao' => [
                'type'       => 'TEXT',
            ],
            'id_criador' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'status' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'observacao' => [
                'type'           => 'TEXT',
            ],
            'tipo_campanha' => [
                'type' => 'ENUM',
                'constraint' => ['rede', 'loja', 'fornecedor'],
            ],
            'total_campanha' => [
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
        $this->forge->addKey('id_campanha', true);
        $this->forge->createTable('campanhas');
    }

    public function down()
    {
        $this->forge->dropTable('campanhas');        
    }
}
