<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\Sendmail;
use App\Models\BandeiraModel;
use App\Models\UsuarioModel;
use CodeIgniter\API\ResponseTrait;

class BandeiraController extends BaseController
{
    use ResponseTrait;

    public function list() 
    {
        $model = new BandeiraModel();
        $bandeiras = $model->listAll();
        return $this->respond(['data' => $bandeiras], 200);
    }

    public function store(){
        $rules = [
            'nome_bandeira' => 'required|min_length[3]',
            'nome_responsavel' => 'required|min_length[3]',
            'cpf' => 'required|valid_cpf',
            'razao_social' => 'required|min_length[3]',
            'cnpj' => 'required|valid_cnpj',
            'ie' => 'required|decimal',
            'telefone' => 'required|numeric',
            'negociacao' => 'valid_negociacao',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'senha' => 'required|min_length[8]|valid_password'
        ];
        $messages = [
            'nome_bandeira' => [
                'required' => 'Forneça o nome da bandeira.',
                'min_length' => 'O nome da bandeira deve ter no mínimo {param} caracteres'
            ],
            'nome_responsavel' => [
                'required' => 'Forneça o nome do responsável.',
                'min_length' => 'O nome do fornecedor deve ter no mínimo {param} caracteres'
            ],
            'cpf' => [
                'required' => 'Forneça o CPF do responsável.',
            ],
            'razao_social' => [
                'required' => 'Forneça a razão social.',
                'min_length' => 'A razão social deve ter no mínimo {param} caracteres.'
            ],
            'cnpj' => [
                'required' => 'Forneça o CNPJ',
            ],
            'ie' => [
                'required' => 'Forneça a inscrição estadual.',
                'decimal' => 'O formato da inscrição estadual é inválido.'
            ],
            'telefone' => [
                'required' => 'Forneça o Telefone.',
                'numeric' => 'Formato de Telefone inválido.'
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
                'tipo_usuario' => '6',
                'token_verificacao' => auth_token_gen(strval($this->request->getPost('email')))
            ];
            $db = \Config\Database::connect();
            $db->transException(true)->transStart();
            $db->table('usuarios')->insert($user_data);
            $id_usuario = $db->insertID();
            $bandeira_data = [
                'nome_bandeira' =>  $this->request->getPost('nome_bandeira'),
                'nome_responsavel' =>  $this->request->getPost('nome_responsavel'),
                'cpf' =>  encrypt(strval($this->request->getPost('cpf'))),
                'razao_social' =>  $this->request->getPost('razao_social'),
                'cnpj' =>  $this->request->getPost('cnpj'),
                'ie' =>  $this->request->getPost('ie'),
                'telefone' => $this->request->getPost('telefone'),
                'negociacao' =>  str_replace(',', '.', $this->request->getPost('negociacao')),
                'id_usuario' => $id_usuario
            ];
            $db->table('bandeiras')->insert($bandeira_data);
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
            'id_bandeira' => 'required|integer|in_table[bandeiras,id_bandeira]',
            'nome_bandeira' => 'required|min_length[3]',
            'nome_responsavel' => 'required|min_length[3]',
            'cpf' => 'required|valid_cpf',
            'razao_social' => 'required|min_length[3]',
            'cnpj' => 'required|valid_cnpj',
            'ie' => 'required|decimal',
            'telefone' => 'required|numeric',
            'negociacao' => 'valid_negociacao',
        ];
        $messages = [
            'id_bandeira' => [
                'required' => 'O campo id de bandeira é obrigatório.',
                'integer' => 'O campo id de bandeira não é valido.'
            ],
            'nome_bandeira' => [
                'required' => 'Forneça o nome da bandeira.',
                'min_length' => 'O nome da bandeira deve ter no mínimo {param} caracteres'
            ],
            'nome_responsavel' => [
                'required' => 'Forneça o nome do responsável.',
                'min_length' => 'O nome do administrador deve ter no mínimo {param} caracteres'
            ],
            'cpf' => [
                'required' => 'Forneça o CPF do responsável.',
            ],
            'razao_social' => [
                'required' => 'Forneça a razão social.',
                'min_length' => 'A razão social deve ter no mínimo {param} caracteres.'
            ],
            'cnpj' => [
                'required' => 'Forneça o CNPJ',
            ],
            'ie' => [
                'required' => 'Forneça a inscrição estadual.',
                'decimal' => 'O formato da inscrição estadual é inválido.'
            ],
            'telefone' => [
                'required' => 'Forneça o Telefone.',
                'numeric' => 'Formato de Telefone inválido.'
            ],
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try {
            $bandeira_id = $this->request->getPost('id_bandeira');
            $bandeira_data = [
                'nome_bandeira'  => strval($this->request->getPost('nome_bandeira')),
                'nome_responsavel'  => strval($this->request->getPost('nome_responsavel')),
                'cpf'   => encrypt(strval($this->request->getPost('cpf'))),
                'razao_social' =>  $this->request->getPost('razao_social'),
                'cnpj' =>  $this->request->getPost('cnpj'),
                'ie' =>  $this->request->getPost('ie'),
                'telefone' => $this->request->getPost('telefone'),
                'negociacao' =>  str_replace(',', '.', $this->request->getPost('negociacao')),
            ];
            $bandeira_model = new BandeiraModel();
            $bandeira_model->update($bandeira_id, $bandeira_data);
            return $this->respond(['success' => true], 200);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }

    }

    public function destroy()
    {
        $rules = [
            'id_bandeira' => 'required|integer|in_table[bandeiras,id_bandeira]',
        ];
        $messages = [
            'id_bandeira' => [
                'required' => 'Forneça o id da bandeira.',
                'integer' => 'O campo id de bandeira não é valido.'
            ]
        ];
        if(!$this->validate($rules, $messages)){
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $id_bandeira = $this->request->getPost('id_bandeira');
            $bandeira_model = new BandeiraModel();
            $user_model = new UsuarioModel();
            $user_id = $bandeira_model->find($id_bandeira)->id_usuario;
            $bandeira_model->delete($id_bandeira);
            $user_model->delete($user_id);
            return $this->respondDeleted(['success' => true]);
        }catch(\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function block()
    {
        $rules = [
            'id_bandeira' => 'required|integer|in_table[bandeiras,id_bandeira]',
            'acao' => 'required|integer|in_list[0,1]'
        ];
        $messages = [
            'id_bandeira' => [
                'required' => 'Forneça o id da bandeira',
                'integer' => 'O campo id de bandeira não é valido.',
                'in_table' => 'O campo id de bandeira não é valido.'
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
            $id_bandeira = $this->request->getPost('id_bandeira');
            $bandeira_model = new BandeiraModel();
            $user_model = new UsuarioModel();
            $id_usuario = $bandeira_model->find($id_bandeira)->id_usuario;
            $action = boolval($this->request->getPost('acao'));
            $user_model->ban($id_usuario, $action);
            return $this->respondDeleted(['success' => true]);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }

    }

    
}
