<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\Sendmail;
use App\Models\ColaboradorModel;
use App\Models\LojaModel;
use App\Models\UsuarioModel;
use CodeIgniter\API\ResponseTrait;

class ColaboradorController extends BaseController
{
    use ResponseTrait;

    public function list() 
    {
        $model = new ColaboradorModel();
        $colaboradores = $model->listAll();
        return $this->respond(['data' => $colaboradores], 200);
    }

    public function select2()
    {
        $term = $this->request->getGet('term');
        $model = new LojaModel();
        #$lojas = $model->select('id_loja as id, nome_fantasia as text')->like('nome_fantasia', $term)->findAll();
        $lojas = $model->select('id_loja as id, CONCAT(cnpj_loja, " - ", nome_fantasia) as text')->like('cnpj_loja', $term)->findAll();
        $data['results'] = $lojas;
        return $this->respond($data, 200);
    }

    public function store(){
        $rules = [
            'nome_colaborador' => 'required|min_length[3]',
            'cpf_responsavel' => 'required|valid_cpf',
            'tipo_pix' => 'required|in_list[cpf,cnpj,telefone,email,aleatorio]',
            'chave_pix' => 'required|min_length[3]|valid_pix[tipo_pix]',
            'telefone' => 'required|numeric',
            'id_loja' => 'required|integer|in_table[lojas,id_loja]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'senha' => 'required|min_length[8]|valid_password'
        ];
        $messages = [
            'nome_colaborador' => [
                'required' => 'Forneça o nome do colaborador.',
                'min_length' => 'O nome do colaborador deve ter no mínimo {param} caracteres.'
            ],
            'cpf_responsavel' => [
                'required' => 'Forneça o CPF do responsável.',
            ],
            'tipo_pix' => [
                'required' => 'Forneça o tipo de pix.',
                'in_list' => 'Tipo de pix inválido.'
            ],
            'chave_pix' => [
                'required' => 'Forneça a chave pix.',
                'min_length' => 'A chave pix deve ter no mínimo {param} caracteres.'
            ],
            'telefone' => [
                'required' => 'Forneça o telefone.',
                'integer' => 'Formato de dado inválido.'
            ],
            'id_loja' => [
                'required' => 'Forneça o id da loja.',
            ],
            'email' => [
                'required' => 'Forneça o email.',
                'valid_email' => 'O email informado não é valido.',
                'is_unique' => 'O email informado está em uso.'
            ],
            'senha' => [
                'required' => 'Forneça a senha.',
                'min_length' => 'A senha deve ter no mínimo {param} caracteres.'
            ],
            
        ];
        if(!$this->validate($rules, $messages)){
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $user_data = [
                'email' => $this->request->getPost('email'),
                'senha' => password_hash(strval($this->request->getPost('senha')), PASSWORD_BCRYPT),
                'tipo_usuario' => '7',
                'token_verificacao' => auth_token_gen(strval($this->request->getPost('email')))
            ];
            $db = \Config\Database::connect();
            $db->transException(true)->transStart();
            $db->table('usuarios')->insert($user_data);
            $id_usuario = $db->insertID();
            $saldo_data = [
                'saldo' => 0
            ];
            $db->table('saldo')->insert($saldo_data);
            $id_saldo = $db->insertID();
            $colaborador_data = [
                'nome_colaborador' =>  $this->request->getPost('nome_colaborador'),
                'cpf_responsavel' =>  encrypt(strval($this->request->getPost('cpf_responsavel'))),
                'chave_pix' =>  $this->request->getPost('chave_pix'),
                'tipo_pix' =>  $this->request->getPost('tipo_pix'),
                'telefone' =>  $this->request->getPost('telefone'),
                'id_loja' =>  $this->request->getPost('id_loja'),
                'id_usuario' => $id_usuario,
                'id_saldo' => $id_saldo,
            ];
            $db->table('colaboradores')->insert($colaborador_data);
            $db->transComplete();
            $user = (new UsuarioModel())->find($id_usuario);
            Sendmail::verify_email($user->email, $user->token_verificacao);
            return $this->respondCreated(['success' => true]);
        }catch(\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function update()
    {
        $rules = [
            'id_colaborador' => 'required|integer|in_table[colaboradores,id_colaborador]',
            'nome_colaborador' => 'required|min_length[3]',
            'cpf_responsavel' => 'required|valid_cpf',
            'tipo_pix' => 'required|in_list[cpf,cnpj,telefone,email,aleatorio]',
            'chave_pix' => 'required|min_length[3]|valid_pix[tipo_pix]',
            'telefone' => 'required|numeric',
        ];
        $messages = [
            'id_colaborador' => [
                'required' => 'O campo id do colaborador é obrigatório.',
                'integer' => 'O campo id do colaborador não é valido.'
            ],
            'nome_colaborador' => [
                'required' => 'Forneça o nome do colaborador.',
                'min_length' => 'O nome do colaborador deve ter no mínimo {param} caracteres.'
            ],
            'cpf_responsavel' => [
                'required' => 'Forneça o CPF do responsável.',
            ],
            'tipo_pix' => [
                'required' => 'Forneça o tipo de pix.',
                'in_list' => 'Tipo de pix inválido.'
            ],
            'chave_pix' => [
                'required' => 'Forneça a chave pix.',
                'min_length' => 'A chave pix deve ter no mínimo {param} caracteres.'
            ],
            'telefone' => [
                'required' => 'Forneça o telefone.',
                'integer' => 'Formato de dado inválido.'
            ],
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try {
            $colaborador_id = $this->request->getPost('id_colaborador');
            $colaborador_data = [
                'nome_colaborador'  => strval($this->request->getPost('nome_colaborador')),
                'cpf_responsavel'  => encrypt(strval($this->request->getPost('cpf_responsavel'))),
                'tipo_pix' =>  strval($this->request->getPost('tipo_pix')),
                'chave_pix'  => strval($this->request->getPost('chave_pix')),
                'telefone'   => strval($this->request->getPost('telefone')),
            ];
            $colaborador_model = new ColaboradorModel();
            $colaborador_model->update($colaborador_id, $colaborador_data);
            return $this->respond(['success' => true], 200);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function block()
    {
        $rules = [
            'id_colaborador' => 'required|integer|in_table[colaboradores,id_colaborador]',
            'acao' => 'required|integer|in_list[0,1]'
        ];
        $messages = [
            'id_colaborador' => [
                'required' => 'Forneça o id do colaborador',
                'integer' => 'O campo id do colaborador não é valido.',
                'in_table' => 'O campo id do colaborador não é valido.'
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
            $id_colaborador = $this->request->getPost('id_colaborador');
            $colaborador_model = new ColaboradorModel();
            $user_model = new UsuarioModel();
            $id_usuario = $colaborador_model->find($id_colaborador)->id_usuario;
            $action = boolval($this->request->getPost('acao'));
            $user_model->ban($id_usuario, $action);
            return $this->respondDeleted(['success' => true]);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }

    }


    public function destroy()
    {
        $rules = [
            'id_colaborador' => 'required|integer|in_table[colaboradores,id_colaborador]',
        ];
        $messages = [
            'id_colaborador' => [
                'required' => 'Forneça o id do colaborador.',
                'integer' => 'O campo id do colaborador não é valido.'
            ]
        ];
        if(!$this->validate($rules, $messages)){
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $id_colaborador = $this->request->getPost('id_colaborador');
            $colaborador_model = new ColaboradorModel();
            $user_model = new UsuarioModel();
            $user_id = $colaborador_model->find($id_colaborador)->id_usuario;
            $colaborador_model->delete($id_colaborador);
            $user_model->delete($user_id);
            return $this->respondDeleted(['success' => true]);
        }catch(\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }
}
