<?php

namespace App\Models;

use CodeIgniter\Model;

class CampanhaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'campanhas';
    protected $primaryKey       = 'id_campanha';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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

    public function listAllByUser(){
        $id_usuario = auth_data('id_usuario');
        $sql = <<<EOQ
        SELECT 
	        c.id_campanha, c.descricao, c.nome_campanha, 
	        c.data_inicio, c.data_final, c.observacao, c.`status`	 
        FROM campanhas AS c 
        WHERE c.id_criador=? ORDER BY id_campanha DESC;
EOQ;
        $results = $this->db->query($sql, [$id_usuario])->getResultObject();
        return $results;
    }

    public function listAll(){
        $sql = <<<EOQ
        SELECT 
	        c.id_campanha, c.descricao, c.nome_campanha, 
	        c.data_inicio, c.data_final, c.`status`, c.tipo_campanha as tipo	 
        FROM campanhas AS c ORDER BY id_campanha DESC;
EOQ;
        $results = $this->db->query($sql)->getResultObject();
        return $results;
    }
}
