<?php

namespace App\Models;

use CodeIgniter\Model;

class LojaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'lojas';
    protected $primaryKey       = 'id_loja';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome_fantasia', 'razao_social', 'nome_responsavel', 'cnpj_loja', 'ie_loja', 'negociacao'
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
            l.id_loja, l.razao_social, l.nome_responsavel, l.nome_fantasia,
            l.cnpj_loja, l.ie_loja, l.negociacao,
            u.blocked,
        case 
            when u.token_verificacao IS NULL then 'sim'
            ELSE 'não'
        END verificado
        FROM lojas AS l 
        LEFT JOIN usuarios AS u ON l.id_usuario=u.id_usuario
        WHERE l.deleted_at IS NULL;
        EOQ;
        $results = $this->db->query($sql)->getResultArray();
        // for($i = 0; $i < count($results); $i++){
        //     $results[$i]['cpf_responsavel'] = decrypt($results[$i]['cpf_responsavel']);
        // }
        return $results;
    }

    public function listEmails(int $id_loja)
    {
        $sql = <<<EOQ
        SELECT el.id_email_loja, el.email_loja 
        FROM email_loja AS el 
        WHERE el.id_loja = ?;
        EOQ;
        $results = $this->db->query($sql, [$id_loja])->getResultArray();
        return $results;
    }

    public function listTelefones(int $id_loja)
    {
        $sql = <<<EOQ
        SELECT tl.id_telefone_loja, tl.num_telefone, tl.is_whats 
        FROM telefone_loja AS tl 
        WHERE tl.id_loja = ?;
        EOQ;
        $results = $this->db->query($sql, [$id_loja])->getResultArray();
        return $results;
    }

    public function getColaboradoresFromLoja(){
        $id_usuario = auth_data('id_usuario');
        // Pegar o Id da loja logada
        $id_loja = $this->select('id_loja')->where('id_usuario', $id_usuario)->first();
        $colaboradores_model = new ColaboradorModel();
        $colaboradores_result = $colaboradores_model->select('id_usuario')->where('id_loja', $id_loja->id_loja)->findAll();
        $colaboradores = [];
        foreach ($colaboradores_result as $colaborador) {
            $colaboradores[] = $colaborador->id_usuario;
        }
        return $colaboradores;
    }

    public function getColaboradoresFromLojaById($id_loja){
        $colaboradores_model = new ColaboradorModel();
        $colaboradores_result = $colaboradores_model->select('id_usuario')->where('id_loja', $id_loja)->findAll();
        $colaboradores = [];
        foreach ($colaboradores_result as $colaborador) {
            $colaboradores[] = $colaborador->id_usuario;
        }
        return $colaboradores;
    }

    public function getNegociacao(){
        $id_usuario = auth_data('id_usuario');
        $loja = $this->where('id_usuario', $id_usuario)->first();
        return $loja->negociacao;
    }
}
