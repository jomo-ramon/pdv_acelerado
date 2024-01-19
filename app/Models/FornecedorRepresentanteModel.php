<?php

namespace App\Models;

use CodeIgniter\Model;

class FornecedorRepresentanteModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'fornecedor_representante';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_representante', 'id_fornecedor'
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

    public function hasData(int $id_fornecedor, int $id_representante)
    {
        $sql = "SELECT * FROM fornecedor_representante WHERE id_fornecedor = ? AND id_representante = ?";
        $data = $this->db->query($sql, [$id_fornecedor, $id_representante])->getResultArray();
        if(count($data) > 0){
            return true;
        }
        return false;
    }
}
