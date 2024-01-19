<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddRepresentantes extends Migration
{
    public function up()
    {
          $this->forge->addField([
            'id_representante' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome_representante' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'cpf_responsavel' => [
                'type'       => 'VARCHAR',
                'constraint' => '190',
            ],
            'id_usuario' => [
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
        $this->forge->addKey('id_representante', true);
        $this->forge->addForeignKey('id_usuario', 'usuarios', 'id_usuario');
        $this->forge->createTable('representantes');
    }

    public function down()
    {
        $this->forge->dropTable('representantes');
    }
}
