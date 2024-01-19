<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddColaborador extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_colaborador' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome_colaborador' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'cpf_responsavel' => [
                'type'       => 'VARCHAR',
                'constraint' => '190',
            ],
            'telefone' => [
                'type'       => 'VARCHAR',
                'constraint' => '45',
            ],
            'tipo_pix' => [
                'type' => 'ENUM',
                'constraint' => ['cpf', 'cnpj', 'telefone', 'email', 'aleatorio'],
                'default' => 'cpf',
            ],
            'chave_pix' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'id_usuario' => [
                'type' => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_saldo' => [
                'type' => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
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
        $this->forge->addKey('id_colaborador', true);
        $this->forge->addForeignKey('id_usuario', 'usuarios', 'id_usuario');
        $this->forge->addForeignKey('id_saldo', 'saldo', 'id_saldo');
        $this->forge->addForeignKey('id_loja', 'lojas', 'id_loja', '', '', 'fk_loja_colaborador');
        $this->forge->createTable('colaboradores');
    }

    public function down()
    {
        $this->forge->dropTable('colaboradores');
    }
}
