<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\Sendmail;
use App\Models\AdministradorModel;
use App\Models\UsuarioModel;
use CodeIgniter\API\ResponseTrait;
use Exception;

class AdministradorController extends BaseController
{
    use ResponseTrait;

    public function list()
    {
        $model = new AdministradorModel();
        $administradores = $model->listAll();
        return $this->respond(['data' => $administradores], 200);
    }

    public function store()
    {
        $rules = [
            'email' => 'required|valid_email|is_unique_custom[usuarios,email]',
            'senha' => 'required|min_length[8]|valid_password',
            'nome_administrador' => 'required|min_length[3]'
        ];
        $messages = [
            'email' => [
                'required' => 'Forneça o email',
                'valid_email' => 'O email informado não é valido.',
                'is_unique_custom' => 'O email informado está em uso.'
            ],
            'senha' => [
                'required' => 'Forneça a senha.',
                'min_length' => 'A senha deve ter no mínimo {param} caracteres.'
            ],
            'nome_administrador' => [
                'required' => 'Forneça o nome do administrador.',
                'min_length' => 'O nome do administrador deve ter no mínimo {param} caracteres'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        $user_data = [
            'email' => $this->request->getPost('email'),
            'senha' => password_hash(strval($this->request->getPost('senha')), PASSWORD_BCRYPT),
            'tipo_usuario' => '2',
            'token_verificacao' => auth_token_gen(strval($this->request->getPost('email')))
        ];
        try {
            $db = \Config\Database::connect();
            $db->transException(true)->transStart();
            $db->table('usuarios')->insert($user_data);
            $id_usuario = $db->insertID();
            $administrador_data = [
                'nome_administrador' =>  $this->request->getPost('nome_administrador'),
                'id_usuario' => $id_usuario
            ];
            $db->table('administradores')->insert($administrador_data);
            $db->transComplete();
            $user = (new UsuarioModel())->find($id_usuario);
            Sendmail::verify_email($user->email, $user->token_verificacao);
            return $this->respondCreated(['success' => true]);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function update()
    {
        $rules = [
            'id_administrador' => 'required|integer|in_table[administradores,id_administrador]',
            'nome_administrador' => 'required|min_length[3]'
        ];
        $messages = [
            'id_administrador' => [
                'required' => 'O campo id de administrador é obrigatório.',
                'integer' => 'O campo id de administrador não é valido.'
            ],
            'nome_administrador' => [
                'required' => 'Forneça o nome do administrador.',
                'min_length' => 'O nome do administrador deve ter no mínimo {param} caracteres'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try {
            $adm_id = $this->request->getPost('id_administrador');
            $adm_data = [
                'nome_administrador' => strval($this->request->getPost('nome_administrador'))
            ];
            $adm_model = new AdministradorModel();
            $adm_model->update($adm_id, $adm_data);
            return $this->respond(['success' => true], 200);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }

    }

    public function destroy()
    {
        $rules = [
            'id_administrador' => 'required|integer|in_table[administradores,id_administrador]',
        ];
        $messages = [
            'id_administrador' => [
                'required' => 'O campo id de administrador é obrigatório.',
                'integer' => 'O campo id de administrador não é valido.'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try {
            $id_adm = $this->request->getPost('id_administrador');
            $adm_model = new AdministradorModel();
            $user_model = new UsuarioModel();
            $user_id = $adm_model->find($id_adm)->id_usuario;
            $adm_model->delete($id_adm);
            $user_model->delete($user_id);
            return $this->respondDeleted(['success' => true]);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function block()
    {
        $rules = [
            'id_administrador' => 'required|integer|in_table[administradores,id_administrador]',
            'acao' => 'required|integer|in_list[0,1]'
        ];
        $messages = [
            'id_administrador' => [
                'required' => 'Forneça o id de administrador',
                'integer' => 'O campo id de administrador não é valido.',
                'in_table' => 'O campo id de administrador não é valido.'
            ],
            'acao' => [
                'required' => 'Forneça uma acao',
                'integer' => 'O campo acao não é valido.',
                'in_list' => 'O campo acao não é valido.'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try {
            $id_administrador = $this->request->getPost('id_administrador');
            $adm_model = new AdministradorModel();
            $user_model = new UsuarioModel();
            $id_usuario = $adm_model->find($id_administrador)->id_usuario;
            $action = boolval($this->request->getPost('acao'));
            $user_model->ban($id_usuario, $action);
            return $this->respondDeleted(['success' => true]);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }

    }
}
