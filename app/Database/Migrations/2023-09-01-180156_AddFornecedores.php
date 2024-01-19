<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddFornecedores extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_fornecedor' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome_responsavel' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'cpf_responsavel' => [
                'type'       => 'VARCHAR',
                'constraint' => 190,
            ],
            'tipo_fornecedor' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],
            'razao_social' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'cnpj' => [
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
        $this->forge->addKey('id_fornecedor', true);
        $this->forge->addForeignKey('tipo_fornecedor', 'tipo_fornecedores', 'id_tipo_fornecedor');
        $this->forge->createTable('fornecedores');
    }

    public function down()
    {
        $this->forge->dropTable('fornecedores');
    }
}
