<?php

namespace App\Models;

use CodeIgniter\Model;

class ColaboradorModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'colaboradores';
    protected $primaryKey       = 'id_colaborador';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome_colaborador', 'cpf_responsavel', 'telefone', 'chave_pix', 
        'id_loja', 'id_saldo', 'id_usuario'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function listAll(){
        $sql = <<<EOQ
        SELECT 
            c.id_colaborador, c.nome_colaborador, c.cpf_responsavel,
            c.telefone, c.tipo_pix, c.chave_pix, l.nome_fantasia,
            u.blocked,
        case 
            when u.token_verificacao IS NULL then 'sim'
            ELSE 'não'
        END verificado
        FROM colaboradores AS c 
        LEFT JOIN lojas AS l ON c.id_loja=l.id_loja
        LEFT JOIN usuarios AS u ON c.id_usuario=u.id_usuario
        WHERE c.deleted_at IS NULL;
        EOQ;
        $results = $this->db->query($sql)->getResultArray();
        for($i = 0; $i < count($results); $i++){
            $results[$i]['cpf_responsavel'] = decrypt($results[$i]['cpf_responsavel']);
        }
        return $results;
    }

}
