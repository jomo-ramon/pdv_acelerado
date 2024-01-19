<?php

namespace App\Models;

use CodeIgniter\Model;

class AdministradorModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'administradores';
    protected $primaryKey       = 'id_administrador';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_administrador', 'nome_administrador', 'id_usuario'
    ];

    // Dates
    protected $useTimestamps = false;
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

    public function listAll()
    {
        $sql = <<<EOQ
        SELECT 
            a.id_administrador, a.nome_administrador, u.email, u.blocked,
        case 
            when u.token_verificacao IS NULL then 'sim'
            ELSE 'não'
        END verificado
        FROM administradores AS a LEFT JOIN usuarios AS u ON a.id_usuario = u.id_usuario
        WHERE a.deleted_at IS NULL;
        EOQ;
        return $this->db->query($sql)->getResultObject();
    }
}
