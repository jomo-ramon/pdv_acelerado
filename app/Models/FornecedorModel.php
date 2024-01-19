<?php

namespace App\Models;

use CodeIgniter\Model;

class FornecedorModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'fornecedores';
    protected $primaryKey       = 'id_fornecedor';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_fornecedor', 'nome_responsavel', 'cpf_responsavel', 'tipo_fornecedor',
        'razao_social', 'cnpj' , 'negociacao'
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
    protected $beforeInsert   = ['encrypt_cpf'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    protected function encrypt_cpf(array $data)
    {
        if (! isset($data['data']['cpf_responsavel'])) {
            return $data;
        }
        $data['data']['cpf_responsavel'] = encrypt($data['data']['cpf_responsavel']);
        return $data;
    }

    public function listAll(){
        $sql = <<<EOQ
        SELECT 
            f.id_fornecedor, f.nome_responsavel, f.cpf_responsavel,
            tf.descricao_tipo_fornecedor AS descricao, f.razao_social, 
            f.cnpj, u.blocked, f.negociacao,
        case 
            when u.token_verificacao IS NULL then 'sim'
            ELSE 'não'
        END verificado
        FROM fornecedores AS f 
        LEFT JOIN tipo_fornecedores AS tf ON f.tipo_fornecedor=tf.id_tipo_fornecedor
        LEFT JOIN usuarios AS u ON f.id_usuario=u.id_usuario
        WHERE f.deleted_at IS NULL;
        EOQ;
        $results = $this->db->query($sql)->getResultArray();
        for($i = 0; $i < count($results); $i++){
            $results[$i]['cpf_responsavel'] = decrypt($results[$i]['cpf_responsavel']);
        }
        return $results;
    }

    public function listByRepresentante(int $id_representante)
    {
        $sql = <<<EOQ
        SELECT 
            f.id_fornecedor, f.razao_social 
        FROM
            fornecedores AS f, fornecedor_representante AS fr
        WHERE
            fr.id_fornecedor=f.id_fornecedor AND
            fr.id_representante=?;
        EOQ;
        $results = $this->db->query($sql, [$id_representante])->getResultObject();
        return $results;
    }
}
