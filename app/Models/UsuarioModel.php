<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_usuario', 'email', 'tipo_usuario', 'blocked',
        'senha', 'token_verificacao', 'token_recuperacao'
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
    protected $beforeInsert   = ['hash_password', 'add_auth_token'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['hash_password'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /* Criptografa a senha antes de salvar - beforeInsert */
    protected function hash_password(array $data)
    {
        if (! isset($data['data']['senha'])) {
            return $data;
        }
        $data['data']['senha'] = password_hash($data['data']['senha'], PASSWORD_BCRYPT);
        return $data;
    }
    /* Cria um token de verificacao ao criar usuario */
    protected function add_auth_token(array $data)
    {
        $email = $data['data']['email'];
        $data['data']['token_verificacao'] = auth_token_gen($email);
        return $data;
    }

    /* Pega apenas os dados necessários para salvar na sessão */
    public function getAuthData(int $id)
    {
        $sql = "SELECT u.id_usuario, u.email, t.decricao_tipo_usuario as tipo, u.tipo_usuario as tipo_usuario, u.created_at, u.updated_at, u.token_verificacao, u.blocked FROM usuarios u JOIN tipos_usuario t ON u.tipo_usuario=t.id_tipo WHERE u.id_usuario = ?";
        return $this->db->query($sql, [$id])->getResultObject();
    }

    /* Banir(bloquear) usuário */
    public function ban(int $id, bool $action = false)
    {
        $data = ['blocked' => ($action) ? 1 : 0];
        $this->update($id, $data);
    }
}
