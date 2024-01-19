<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddTipoFornecedores extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tipo_fornecedor' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'descricao_tipo_fornecedor' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
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
        $this->forge->addKey('id_tipo_fornecedor', true);
        $this->forge->createTable('tipo_fornecedores');
    }

    public function down()
    {
        $this->forge->dropTable('tipo_fornecedores');
    }
}
