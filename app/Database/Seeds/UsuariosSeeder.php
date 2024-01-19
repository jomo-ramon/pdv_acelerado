<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        $dataTiposUsuarios = [
            ['decricao_tipo_usuario' => 'SuperAdmin'],
            ['decricao_tipo_usuario' => 'Admin'],
            ['decricao_tipo_usuario' => 'Fornecedor'],
            ['decricao_tipo_usuario' => 'Representante'],
            ['decricao_tipo_usuario' => 'Loja'],
            ['decricao_tipo_usuario' => 'Bandeira'],
            ['decricao_tipo_usuario' => 'Colaborador'],
        ];
        $this->db->table('tipos_usuario')->insertBatch($dataTiposUsuarios);
        $dataTiposFornecedores = [
            ['descricao_tipo_fornecedor' => 'Distribuidor'],
            ['descricao_tipo_fornecedor' => 'Indústria'],
            ['descricao_tipo_fornecedor' => 'Representante'],
        ];
        $this->db->table('tipo_fornecedores')->insertBatch($dataTiposFornecedores);
        $dataUsuarios = [
            [
                'email' => 'superadmin@gmail.com',
                'senha' => password_hash('Abc123@12', PASSWORD_BCRYPT),
                'tipo_usuario' => '1',
            ],
            [
                'email' => 'admin@gmail.com',
                'senha' => password_hash('Abc123@12', PASSWORD_BCRYPT),
                'tipo_usuario' => '2',
            ],
            // [
            //     'email' => 'fornecedor@gmail.com',
            //     'senha' => password_hash('Abc123@12', PASSWORD_BCRYPT),
            //     'tipo_usuario' => '3',
            // ],
            // [
            //     'email' => 'representante@gmail.com',
            //     'senha' => password_hash('Abc123@12', PASSWORD_BCRYPT),
            //     'tipo_usuario' => '4',
            // ],
            // [
            //     'email' => 'loja@gmail.com',
            //     'senha' => password_hash('Abc123@12', PASSWORD_BCRYPT),
            //     'tipo_usuario' => '5',
            // ],
            // [
            //     'email' => 'bandeira@gmail.com',
            //     'senha' => password_hash('Abc123@12', PASSWORD_BCRYPT),
            //     'tipo_usuario' => '6',
            // ],
            // [
            //     'email' => 'colaborador@gmail.com',
            //     'senha' => password_hash('Abc123@12', PASSWORD_BCRYPT),
            //     'tipo_usuario' => '7',
            // ],
        ];
        $this->db->table('usuarios')->insertBatch($dataUsuarios);
    }
}
