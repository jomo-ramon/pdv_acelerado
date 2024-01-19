<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SistemaSeeder extends Seeder
{
    public function run()
    {
        $dataSistema = [
            'id' => 1,
            'chave_pix' => '',
            'lucro' => 10.00,
        ];
        $this->db->table('sistema')->insert($dataSistema);
    }
}
