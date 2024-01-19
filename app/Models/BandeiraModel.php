<?php

namespace App\Models;

use CodeIgniter\Model;

class BandeiraModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'bandeiras';
    protected $primaryKey       = 'id_bandeira';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome_bandeira', 'nome_responsavel', 'cpf', 'razao_social', 'ie', 'cnpj', 'telefone', 'negociacao',
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
            b.id_bandeira, b.nome_bandeira, b.nome_responsavel, b.cpf,
            b.razao_social, b.cnpj, b.ie, b.telefone, b.negociacao,
            u.blocked,
        case 
            when u.token_verificacao IS NULL then 'sim'
            ELSE 'não'
        END verificado
        FROM bandeiras AS b 
        LEFT JOIN usuarios AS u ON b.id_usuario=u.id_usuario
        WHERE b.deleted_at IS NULL;
        EOQ;
        $results = $this->db->query($sql)->getResultArray();
        for($i = 0; $i < count($results); $i++){
            $results[$i]['cpf'] = decrypt($results[$i]['cpf']);
        }
        return $results;
    }

    public function getNegociacao(){
        $id_usuario = auth_data('id_usuario');
        $bandeira = $this->where('id_usuario', $id_usuario)->first();
        return $bandeira->negociacao;
    }

    public function listLojas(){
        $id_usuario = auth_data('id_usuario');
        $bandeira = $this->where('id_usuario', $id_usuario)->first();
        $sql = <<<EOQ
        SELECT l.id_loja as id, l.nome_fantasia as text FROM lojas AS l
        Left JOIN loja_bandeira AS lb ON l.id_loja=lb.id_loja
        Left JOIN bandeiras AS b ON b.id_bandeira=lb.id_bandeira
        Where b.id_bandeira =?
        EOQ;
        $results = $this->db->query($sql, [$bandeira->id_bandeira])->getResultArray();
        return $results;
    }
}
