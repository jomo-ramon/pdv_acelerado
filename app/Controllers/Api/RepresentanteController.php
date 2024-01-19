<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\Sendmail;
use App\Models\FornecedorModel;
use App\Models\FornecedorRepresentanteModel;
use App\Models\RepresentanteModel;
use App\Models\UsuarioModel;
use CodeIgniter\API\ResponseTrait;
use Exception;

class RepresentanteController extends BaseController
{
    use ResponseTrait;

    public function listAll()
    {
        $model = new RepresentanteModel();
        $representantes = $model->listAll();
        return $this->respond(['data' => $representantes], 200);
    }

    public function listFornecedores()
    {
        $rules = [
            'id_representante' => 'required|is_natural|in_table[representantes,id_representante]'
        ];
        $messages = [
            'id_representante' => [
                'required' => 'Forneça o id do representante.',
                'is_natural' => 'Id do representante inválido',
            ],
        ];
        if(!$this->validate($rules, $messages)){
            return $this->fail($this->validator->getErrors(), 400);
        }     
        try{
            $id_representante = strval($this->request->getPost('id_representante'));
            $model = new FornecedorModel();
            $fornecedores = $model->listByRepresentante($id_representante);
            return $this->respond($fornecedores, 200);
        }catch(Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function store()
    {
        //return $this->respond($this->request->getVar(), 200);
        /* Verifica se usuario logado pode fazer a operação (se é superadmin, admin ou fornecedor) */
        $rules = [
            'nome_representante' => 'required|min_length[3]',
            'cpf_responsavel' => 'required|valid_cpf',
            'fornecedores' => 'valid_fornecedor',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'senha' => 'required|min_length[8]|valid_password'
        ];
        $messages = [
            'nome_representante' => [
                'required' => 'Forneça o nome do responsável.',
                'min_length' => 'O nome do representante deve ter no mínimo {param} caracteres'
            ],
            'cpf_responsavel' => [
                'required' => 'Forneça o CPF do responsável.',
            ],
            'id_fornecedor' => [
                'required' => 'Forneça o id do fornecedor.',
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
            'tipo_usuario' => '4',
            'token_verificacao' => auth_token_gen(strval($this->request->getPost('email')))
        ];
        try{
            $db = \Config\Database::connect();
            $db->transException(true)->transStart();
            $db->table('usuarios')->insert($user_data);
            $id_usuario = $db->insertID();
            $representante_data = [
                'nome_representante' =>  $this->request->getPost('nome_representante'),
                'cpf_responsavel' =>  encrypt(strval($this->request->getPost('cpf_responsavel'))),
                'id_usuario' => $id_usuario,
            ];
            $db->table('representantes')->insert($representante_data);
            $id_representante = $db->insertID();
            $fornecedores = $this->request->getPost('fornecedores');
            if(!is_null($fornecedores) && is_array($fornecedores)){
                $fornecedor_representante_data = [];
                $fnModel = new FornecedorRepresentanteModel();
                foreach($fornecedores as $id_fornecedor){
                    if(!$fnModel->hasData($id_fornecedor, $id_representante)){
                        $fornecedor_representante_data[] = [
                            'id_fornecedor' => $id_fornecedor,
                            'id_representante' => $id_representante
                        ];
                    }
                }
                $db->table('fornecedor_representante')->insertBatch($fornecedor_representante_data);
            }
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
            'id_representante' => 'required|integer|in_table[representantes,id_representante]',
            'nome_representante' => 'required|min_length[3]',
            'cpf_responsavel' => 'required|valid_cpf',
        ];
        $messages = [
            'id_representante' => [
                'required' => 'O campo id de representante é obrigatório.',
                'integer' => 'O campo id de representante não é valido.'
            ],
            'nome_representante' => [
                'required' => 'Forneça o nome do responsável.',
                'min_length' => 'O nome do representante deve ter no mínimo {param} caracteres'
            ],
            'cpf_responsavel' => [
                'required' => 'Forneça o CPF do responsável.',
            ],
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try {
            $representante_id = $this->request->getPost('id_representante');
            $representante_data = [
                'nome_representante'  => strval($this->request->getPost('nome_representante')),
                'cpf_responsavel'   => encrypt(strval($this->request->getPost('cpf_responsavel'))),
            ];
            $representante_model = new RepresentanteModel();
            $representante_model->update($representante_id, $representante_data);
            return $this->respond(['success' => true], 200);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }

    }

    public function destroy()
    {
        $rules = [
            'id_representante' => 'required|integer|in_table[representantes,id_representante]',
        ];
        $messages = [
            'id_representante' => [
                'required' => 'Forneça o id do representante.',
                'integer' => 'O campo id de representante não é valido.'
            ]
        ];
        if(!$this->validate($rules, $messages)){
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $id_representante = $this->request->getPost('id_representante');
            $fr_model = new FornecedorRepresentanteModel();
            $fr_list = $fr_model->where('id_representante', $id_representante)->findAll();
            $representante_model = new RepresentanteModel();
            $user_model = new UsuarioModel();
            $user_id = $representante_model->find($id_representante)->id_usuario;
            $representante_model->delete($id_representante);
            $user_model->delete($user_id);
            $fr_model = new FornecedorRepresentanteModel();
            $fr_list = $fr_model->where('id_representante', $id_representante)->findAll();
            foreach($fr_list as $data){
                $fr_model->delete($data->id);
            }
            return $this->respondDeleted(['success' => true]);
        }catch(Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function block()
    {
        $rules = [
            'id_representante' => 'required|integer|in_table[representantes,id_representante]',
            'acao' => 'required|integer|in_list[0,1]'
        ];
        $messages = [
            'id_representante' => [
                'required' => 'Forneça o id de representante',
                'integer' => 'O campo id de representante não é valido.',
                'in_table' => 'O campo id de representante não é valido.'
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
            $id_representante = $this->request->getPost('id_representante');
            $representante_model = new RepresentanteModel();
            $user_model = new UsuarioModel();
            $id_usuario = $representante_model->find($id_representante)->id_usuario;
            $action = boolval($this->request->getPost('acao'));
            $user_model->ban($id_usuario, $action);
            return $this->respondDeleted(['success' => true]);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }

    }

    public function vincularFornecedores()
    {
        $rules = [
            'id_representante' => 'required|integer|in_table[representantes,id_representante]',
            'id_fornecedor' => 'required|integer|in_table[fornecedores,id_fornecedor]',
        ];
        $messages = [
            'id_representante' => [
                'required' => 'Forneça o id do representante.',
                'integer' => 'O campo id de representante não é valido.'
            ],
            'id_fornecedor' => [
                'required' => 'Forneça o id do fornecedor.',
                'integer' => 'O campo id de fornecedor não é valido.'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $id_representante = strval($this->request->getPost('id_representante'));
            $id_fornecedor = strval($this->request->getPost('id_fornecedor'));
            $fr_model = new FornecedorRepresentanteModel();
            $exists = $fr_model->where('id_representante', $id_representante)->where('id_fornecedor', $id_fornecedor)->findAll();
            if($exists){
                return $this->fail(['error' => 'Este vínculo já existe.'], 400);
            }
            $fr_model->insert([
                'id_representante' => $id_representante,
                'id_fornecedor' => $id_fornecedor
            ]);
            return $this->respond(['success' => true]);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }
    public function desvincularFornecedores()
    {
        $rules = [
            'id_representante' => 'required|integer|in_table[representantes,id_representante]',
            'id_fornecedor' => 'required|integer|in_table[fornecedores,id_fornecedor]',
        ];
        $messages = [
            'id_representante' => [
                'required' => 'Forneça o id do representante.',
                'integer' => 'O campo id de representante não é valido.'
            ],
            'id_fornecedor' => [
                'required' => 'Forneça o id do fornecedor.',
                'integer' => 'O campo id de fornecedor não é valido.'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $id_representante = strval($this->request->getPost('id_representante'));
            $id_fornecedor = strval($this->request->getPost('id_fornecedor'));
            $fr_model = new FornecedorRepresentanteModel();
            $exists = $fr_model->where('id_representante', $id_representante)->where('id_fornecedor', $id_fornecedor)->findAll();
            if(!$exists){
                return $this->fail(['error' => 'Este vínculo não existe.'], 400);
            }
            foreach($exists as $fr){
                $fr_model->delete($fr->id);
            }
            return $this->respond(['success' => true]);
        } catch (Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }
}
