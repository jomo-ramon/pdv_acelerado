<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\Sendmail;
use App\Models\FornecedorModel;
use App\Models\UsuarioModel;
use CodeIgniter\API\ResponseTrait;
use Exception;

class FornecedorController extends BaseController {

    use ResponseTrait;

    public function list() 
    {
        $model = new FornecedorModel();
        $fornecedores = $model->listAll();
        return $this->respond(['data' => $fornecedores], 200);
    }
    
    public function select2()
    {
        $term = $this->request->getGet('term');
        $model = new FornecedorModel();
        $fornecedores = $model->select('id_fornecedor as id, razao_social as text')->like('razao_social', $term)->findAll();
        $data['results'] = $fornecedores;
        return $this->respond($data, 200);
    }
    public function store(){
        $rules = [
            'nome_responsavel' => 'required|min_length[3]',
            'cpf_responsavel' => 'required|valid_cpf',
            'tipo_fornecedor' => 'required|integer|in_table[tipo_fornecedores,id_tipo_fornecedor]',
            'razao_social' => 'required|min_length[3]',
            'cnpj' => 'required|valid_cnpj',
            'negociacao' => 'valid_negociacao',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'senha' => 'required|min_length[8]|valid_password'
        ];
        $messages = [
            'nome_responsavel' => [
                'required' => 'Forneça o nome do responsável.',
                'min_length' => 'O nome do fornecedor deve ter no mínimo {param} caracteres'
            ],
            'cpf_responsavel' => [
                'required' => 'Forneça o CPF do responsável.',
            ],
            'tipo_fornecedor' => [
                'required' => 'Forneça o tipo de fornecedor.',
                'integer' => 'Formato de dado inválido.'
            ],
            'razao_social' => [
                'required' => 'Forneça a razão social.',
                'min_length' => 'A razão social deve ter no mínimo {param} caracteres.'
            ],
            'cnpj' => [
                'required' => 'Forneça o CNPJ',
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
        $user_data = [
            'email' => $this->request->getPost('email'),
            'senha' => password_hash(strval($this->request->getPost('senha')), PASSWORD_BCRYPT),
            'tipo_usuario' => '3',
            'token_verificacao' => auth_token_gen(strval($this->request->getPost('email')))
        ];
        try{
            $db = \Config\Database::connect();
            $db->transException(true)->transStart();
            $db->table('usuarios')->insert($user_data);
            $id_usuario = $db->insertID();
            $fornecedor_data = [
                'nome_responsavel' =>  $this->request->getPost('nome_responsavel'),
                'cpf_responsavel' =>  encrypt(strval($this->request->getPost('cpf_responsavel'))),
                'tipo_fornecedor' =>  $this->request->getPost('tipo_fornecedor'),
                'razao_social' =>  $this->request->getPost('razao_social'),
                'cnpj' =>  $this->request->getPost('cnpj'),
                'negociacao' =>  str_replace(',', '.', $this->request->getPost('negociacao')),
                'id_usuario' => $id_usuario
            ];
            $db->table('fornecedores')->insert($fornecedor_data);
            $db->transComplete();
            $user = (new UsuarioModel())->find($id_usuario);
            Sendmail::verify_email($user->email, $user->token_verificacao);
            return $this->respondCreated(['success' => true]);
        }catch(Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function update()
    {
        $rules = [
            'id_fornecedor' => 'required|integer|in_table[fornecedores,id_fornecedor]',
            'nome_responsavel' => 'required|min_length[3]',
            'cpf_responsavel' => 'required|valid_cpf',
            'tipo_fornecedor' => 'required|integer|in_table[tipo_fornecedores,id_tipo_fornecedor]',
            'razao_social' => 'required|min_length[3]',
            'cnpj' => 'required|valid_cnpj',
            'negociacao' => 'valid_negociacao',
        ];
        $messages = [
            'id_fornecedor' => [
                'required' => 'O campo id de fornecedor é obrigatório.',
                'integer' => 'O campo id de fornecedor não é valido.'
            ],
            'nome_responsavel' => [
                'required' => 'Forneça o nome do responsável.',
                'min_length' => 'O nome do administrador deve ter no mínimo {param} caracteres'
            ],
            'cpf_responsavel' => [
                'required' => 'Forneça o CPF do responsável.',
            ],
            'tipo_fornecedor' => [
                'required' => 'Forneça o tipo de fornecedor.',
                'integer' => 'Formato de dado inválido.'
            ],
            'razao_social' => [
                'required' => 'Forneça a razão social.',
                'min_length' => 'A razão social deve ter no mínimo {param} caracteres.'
            ],
            'cnpj' => [
                'required' => 'Forneça o CNPJ',
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try {
            $fornecedor_id = $this->request->getPost('id_fornecedor');
            $fornecedor_data = [
                'nome_responsavel'  => strval($this->request->getPost('nome_responsavel')),
                'cpf_responsavel'   => encrypt(strval($this->request->getPost('cpf_responsavel'))),
                'tipo_fornecedor'   => strval($this->request->getPost('tipo_fornecedor')),
                'razao_social'      => strval($this->request->getPost('razao_social')),
                'cnpj'              => strval($this->request->getPost('cnpj')),
                'negociacao' =>  str_replace(',', '.', $this->request->getPost('negociacao')),
            ];
            $fornecedor_model = new FornecedorModel();
            $fornecedor_model->update($fornecedor_id, $fornecedor_data);
            return $this->respond(['success' => true], 200);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }

    }

    public function destroy()
    {
        $rules = [
            'id_fornecedor' => 'required|integer|in_table[fornecedores,id_fornecedor]',
        ];
        $messages = [
            'id_fornecedor' => [
                'required' => 'Forneça o nome do responsável.',
                'integer' => 'O campo id de fornecedor não é valido.'
            ]
        ];
        if(!$this->validate($rules, $messages)){
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $id_forn = $this->request->getPost('id_fornecedor');
            $adm_model = new FornecedorModel();
            $user_model = new UsuarioModel();
            $user_id = $adm_model->find($id_forn)->id_usuario;
            $adm_model->delete($id_forn);
            $user_model->delete($user_id);
            return $this->respondDeleted(['success' => true]);
        }catch(Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function block()
    {
        $rules = [
            'id_fornecedor' => 'required|integer|in_table[fornecedores,id_fornecedor]',
            'acao' => 'required|integer|in_list[0,1]'
        ];
        $messages = [
            'id_fornecedor' => [
                'required' => 'Forneça o id de fornecedor',
                'integer' => 'O campo id de fornecedor não é valido.',
                'in_table' => 'O campo id de fornecedor não é valido.'
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
            $id_fornecedor = $this->request->getPost('id_fornecedor');
            $fornecedor_model = new FornecedorModel();
            $user_model = new UsuarioModel();
            $id_usuario = $fornecedor_model->find($id_fornecedor)->id_usuario;
            $action = boolval($this->request->getPost('acao'));
            $user_model->ban($id_usuario, $action);
            return $this->respondDeleted(['success' => true]);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }

    }
}
