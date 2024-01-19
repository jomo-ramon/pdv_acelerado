<?php

namespace App\Models;

use CodeIgniter\Model;

class RepresentanteModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'representantes';
    protected $primaryKey = 'id_representante';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'nome_representante',
        'id_usuario',
        'cpf'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function listAll()
    {
        $sql = <<<EOQ
        SELECT 
            r.id_representante, r.nome_representante,
            r.cpf_responsavel,
            u.blocked,
        CASE 
            when u.token_verificacao IS NULL 
	    THEN 'sim'
        ELSE 'não'
        END verificado,
        (
	        SELECT COUNT(fr.id_representante) 
            FROM fornecedor_representante AS fr
	        WHERE fr.id_representante=r.id_representante
        ) 
        AS fornecedores
        FROM representantes AS r
        JOIN usuarios AS u 
        ON r.id_usuario=u.id_usuario 
        WHERE r.deleted_at IS NULL;
EOQ;
        $results = $this->db->query($sql)->getResultArray();
        for ($i = 0; $i < count($results); $i++) {
            $results[$i]['cpf_responsavel'] = decrypt($results[$i]['cpf_responsavel']);
        }
        return $results;
    }
}