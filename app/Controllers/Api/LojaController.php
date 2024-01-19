<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\Sendmail;
use App\Models\BandeiraModel;
use App\Models\EmailLojaModel;
use App\Models\LojaModel;
use App\Models\TelefoneLojaModel;
use App\Models\UsuarioModel;
use CodeIgniter\API\ResponseTrait;

class LojaController extends BaseController
{ 
    use ResponseTrait;
    public function list() 
    {
        $model = new LojaModel();
        $lojas = $model->listAll();
        return $this->respond(['data' => $lojas], 200);
    }

    public function select2()
    {
        $term = $this->request->getGet('term');
        $model = new BandeiraModel();
        $bandeiras = $model->select('id_bandeira as id, nome_bandeira as text')->like('nome_bandeira', $term)->findAll();
        $data['results'] = $bandeiras;
        return $this->respond($data, 200);
    }

    public function list_bandeira()
    {
        // $term = $this->request->getGet('term');
        // $model = new BandeiraModel();
        // $bandeiras = $model->select('id_bandeira as id, nome_bandeira as text')->like('nome_bandeira', $term)->findAll();
        // $data['results'] = $bandeiras;
        // return $this->respond($data, 200);
    }

    public function listEmails()
    {
        $rules = [
            'id_loja' => 'required|is_natural|in_table[lojas,id_loja]'
        ];
        $messages = [
            'id_loja' => [
                'required' => 'Forneça o id da loja.',
                'is_natural' => 'Id da loja inválido',
            ],
        ];
        if(!$this->validate($rules, $messages)){
            return $this->fail($this->validator->getErrors(), 400);
        }     
        try{
            $id_loja = strval($this->request->getPost('id_loja'));
            $model = new LojaModel();
            $emails = $model->listEmails($id_loja);
            return $this->respond($emails, 200);
        }catch(\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function listTelefones()
    {
        $rules = [
            'id_loja' => 'required|is_natural|in_table[lojas,id_loja]'
        ];
        $messages = [
            'id_loja' => [
                'required' => 'Forneça o id da loja.',
                'is_natural' => 'Id da loja inválido',
            ],
        ];
        if(!$this->validate($rules, $messages)){
            return $this->fail($this->validator->getErrors(), 400);
        }     
        try{
            $id_loja = strval($this->request->getPost('id_loja'));
            $model = new LojaModel();
            $emails = $model->listTelefones($id_loja);
            return $this->respond($emails, 200);
        }catch(\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function addEmail()
    {
        $rules = [
            'id_loja' => 'required|integer|in_table[lojas,id_loja]',
            'email_loja' => 'required|valid_email',
        ];
        $messages = [
            'id_loja' => [
                'required' => 'Forneça o id da loja.',
                'integer' => 'O campo id da loja não é valido.'
            ],
            'email_loja' => [
                'required' => 'Forneça o email.',
                'valid_email' => 'O campo email da loja não é um email válido.'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $id_loja = strval($this->request->getPost('id_loja'));
            $email_loja = strval($this->request->getPost('email_loja'));
            $el_model = new EmailLojaModel();
            $el_model->insert([
                'id_loja' => $id_loja,
                'email_loja' => $email_loja
            ]);
            return $this->respond(['success' => true]);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function addTelefone()
    {
        $rules = [
            'id_loja' => 'required|integer|in_table[lojas,id_loja]',
            'num_telefone' => 'required|integer',
            'is_whats' => 'required|in_list[0,1]',
        ];
        $messages = [
            'id_loja' => [
                'required' => 'Forneça o id da loja.',
                'integer' => 'O campo id da loja não é valido.'
            ],
            'num_telefone' => [
                'required' => 'Forneça o email.',
                'integer' => 'O campo telefone não é válido.'
            ],
            'is_whats' => [
                'required' => 'Forneça o campo whatsapp/telefone.',
                'in_list' => 'O campo whatsapp/telefone não é válido'
            ],
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $id_loja = strval($this->request->getPost('id_loja'));
            $num_telefone = strval($this->request->getPost('num_telefone'));
            $is_whats = strval($this->request->getPost('is_whats'));
            $tl_model = new TelefoneLojaModel();
            $tl_model->insert([
                'id_loja' => $id_loja,
                'num_telefone' => $num_telefone,
                'is_whats' => $is_whats
            ]);
            return $this->respond(['success' => true]);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function removeEmail()
    {
        $rules = [
            'id_loja' => 'required|integer|in_table[lojas,id_loja]',
            'id_email_loja' => 'required|integer|in_table[email_loja,id_email_loja]',
        ];
        $messages = [
            'id_loja' => [
                'required' => 'Forneça o id da loja.',
                'integer' => 'O campo id da loja não é valido.'
            ],
            'id_email_loja' => [
                'required' => 'Forneça o id do email.',
                'integer' => 'O campo id do email não é válido.'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $id_loja = $this->request->getPost('id_loja');
            $id_email_loja = $this->request->getPost('id_email_loja');
            $email_loja_model = new EmailLojaModel();
            $email_loja_model->delete($id_email_loja);
            return $this->respondDeleted(['success' => true]);
        }catch(\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }
    
    public function removeTelefone()
    {
        $rules = [
            'id_loja' => 'required|integer|in_table[lojas,id_loja]',
            'id_telefone_loja' => 'required|integer|in_table[telefone_loja,id_telefone_loja]',
        ];
        $messages = [
            'id_loja' => [
                'required' => 'Forneça o id da loja.',
                'integer' => 'O campo id da loja não é valido.'
            ],
            'id_telefone_loja' => [
                'required' => 'Forneça o id do telefone.',
                'integer' => 'O campo id do telefone não é válido.'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $id_loja = $this->request->getPost('id_loja');
            $id_telefone_loja = $this->request->getPost('id_telefone_loja');
            $telefone_loja_model = new TelefoneLojaModel();
            $telefone_loja_model->delete($id_telefone_loja);
            return $this->respondDeleted(['success' => true]);
        }catch(\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function store(){
        $rules = [
            'nome_fantasia' => 'required|min_length[3]',
            'razao_social' => 'required|min_length[3]',
            'nome_responsavel' => 'required|min_length[3]',
            'id_bandeira' => 'permit_empty|integer|in_table[bandeiras,id_bandeira]',
            'cnpj_loja' => 'required|valid_cnpj',
            'ie_loja' => 'required|decimal',
            'negociacao' => 'valid_negociacao',
            'emails' => 'is_email_list',
            'telefones' => 'is_telefone_list',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'senha' => 'required|min_length[8]|valid_password'
        ];
        $messages = [
            'nome_fantasia' => [
                'required' => 'Forneça o nome fantasia.',
                'min_length' => 'O nome fantasia deve ter no mínimo {param} caracteres'
            ],
            'razao_social' => [
                'required' => 'Forneça a razão social.',
                'min_length' => 'A razão social deve ter no mínimo {param} caracteres'
            ],
            'nome_responsavel' => [
                'required' => 'Forneça o nome do responsável.',
                'min_length' => 'O nome do responsável deve ter no mínimo {param} caracteres'
            ],
            'id_bandeira' => [
                'integer' => 'Id da bandeira inválido.',
            ],
            'cnpj_loja' => [
                'required' => 'Forneça o CNPJ.',
            ],
            'ie_loja' => [
                'required' => 'Forneça a inscrição estadual.',
                'decimal' => 'O formato da inscrição estadual é inválido.'
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
                'tipo_usuario' => '5',
                'token_verificacao' => auth_token_gen(strval($this->request->getPost('email')))
            ];
            $db = \Config\Database::connect();
            $db->transException(true)->transStart();
            $db->table('usuarios')->insert($user_data);
            $id_usuario = $db->insertID();
            $loja_data = [
                'nome_fantasia' =>  $this->request->getPost('nome_fantasia'),
                'razao_social' =>  $this->request->getPost('razao_social'),
                'nome_responsavel' =>  $this->request->getPost('nome_responsavel'),
                'cnpj_loja' =>  $this->request->getPost('cnpj_loja'),//encrypt(strval($this->request->getPost('cnpj_loja'))),
                'ie_loja' =>  $this->request->getPost('ie_loja'),
                'negociacao' =>  str_replace(',', '.', $this->request->getPost('negociacao')),
                'id_usuario' => $id_usuario
            ];
            $db->table('lojas')->insert($loja_data);
            $id_loja = $db->insertID();
            $emails = $this->request->getPost('emails');
            if(!is_null($emails)){
                foreach($emails as $address){
                    $emails_data = [
                        'email_loja' => $address,
                        'id_loja' => $id_loja
                    ];
                    $db->table('email_loja')->insert($emails_data);
                }
            }
            $phones = $this->request->getPost('telefones'); 
            if(!is_null($phones)){
                foreach($phones as $list_phones){
                    $phone = explode(',',$list_phones);
                    $phones_data = [
                        'num_telefone' => $phone[0],
                        'is_whats' => $phone[1],
                        'id_loja' => $id_loja,
                    ];
                    $db->table('telefone_loja')->insert($phones_data);
                }
            }
            if(!is_null($this->request->getPost('id_bandeira'))){
                $bandeira_data = [
                    'id_loja' => $id_loja,
                    'id_bandeira' => $this->request->getPost('id_bandeira')
                ];
                $db->table('loja_bandeira')->insert($bandeira_data);
            }
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
            'id_loja' => 'required|integer|in_table[lojas,id_loja]',
            'nome_fantasia' => 'required|min_length[3]',
            'razao_social' => 'required|min_length[3]',
            'nome_responsavel' => 'required|min_length[3]',
            'cnpj_loja' => 'required|valid_cnpj',
            'ie_loja' => 'required|decimal',
            'negociacao' => 'valid_negociacao',
        ];
        $messages = [
            'id_loja' => [
                'required' => 'O campo id de loja é obrigatório.',
                'integer' => 'O campo id de loja não é valido.'
            ],
            'razao_social' => [
                'required' => 'Forneça a razão social.',
                'min_length' => 'A razão social deve ter no mínimo {param} caracteres'
            ],
            'nome_responsavel' => [
                'required' => 'Forneça o nome do responsável.',
                'min_length' => 'O nome do responsável deve ter no mínimo {param} caracteres'
            ],
            'cnpj_loja' => [
                'required' => 'Forneça o CNPJ.',
            ],
            'ie_loja' => [
                'required' => 'Forneça a inscrição estadual.',
                'decimal' => 'O formato da inscrição estadual é inválido.'
            ],
        ];
        if (!$this->validate($rules, $messages)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        try {
            $loja_id = $this->request->getPost('id_loja');
            $loja_data = [
                'nome_fantasia' =>  $this->request->getPost('nome_fantasia'),
                'razao_social' =>  $this->request->getPost('razao_social'),
                'nome_responsavel' =>  $this->request->getPost('nome_responsavel'),
                'cnpj_loja' =>  $this->request->getPost('cnpj_loja'),//encrypt(strval($this->request->getPost('cnpj_loja'))),
                'ie_loja' =>  $this->request->getPost('ie_loja'),
                'negociacao' =>  str_replace(',', '.', $this->request->getPost('negociacao')),
            ];
            $loja_model = new LojaModel();
            $loja_model->update($loja_id, $loja_data);
            return $this->respond(['success' => true], 200);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }

    }

    public function destroy()
    {
        $rules = [
            'id_loja' => 'required|integer|in_table[lojas,id_loja]',
        ];
        $messages = [
            'id_loja' => [
                'required' => 'Forneça o id da loja.',
                'integer' => 'O campo id da loja não é valido.'
            ]
        ];
        if(!$this->validate($rules, $messages)){
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $id_loja = $this->request->getPost('id_loja');
            $loja_model = new LojaModel();
            $user_model = new UsuarioModel();
            $user_id = $loja_model->find($id_loja)->id_usuario;
            $loja_model->delete($id_loja);
            $user_model->delete($user_id);
            return $this->respondDeleted(['success' => true]);
        }catch(\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }

    ///api/administracao/lojas/destroy/email
    public function emailDestroy()
    {
        // $rules = [
        //     'id_email_loja' => 'required|integer|in_table[email_loja,id_email_loja]',
        // ];
        // $messages = [
        //     'id_loja' => [
        //         'required' => 'Forneça o id do email.',
        //         'integer' => 'O campo id do email não é valido.'
        //     ]
        // ];
        // if(!$this->validate($rules, $messages)){
        //     return $this->fail($this->validator->getErrors(), 400);
        // }
        // try{
        //     $id_email_loja = $this->request->getPost('id_email_loja');
        //     //$email_loja_model = new;
        //     $user_model = new UsuarioModel();
        //     $user_id = $loja_model->find($id_loja)->id_usuario;
        //     $loja_model->delete($id_loja);
        //     $user_model->delete($user_id);
        //     return $this->respondDeleted(['success' => true]);
        // }catch(\Exception $e){
        //     return $this->fail($e->getMessage(), 400);
        // }
    }

    public function block()
    {
        $rules = [
            'id_loja' => 'required|integer|in_table[lojas,id_loja]',
            'acao' => 'required|integer|in_list[0,1]'
        ];
        $messages = [
            'id_loja' => [
                'required' => 'Forneça o id da loja',
                'integer' => 'O campo id da loja não é valido.',
                'in_table' => 'O campo id da loja não é valido.'
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
            $id_loja = $this->request->getPost('id_loja');
            $loja_model = new LojaModel;
            $user_model = new UsuarioModel();
            $id_usuario = $loja_model->find($id_loja)->id_usuario;
            $action = boolval($this->request->getPost('acao'));
            $user_model->ban($id_usuario, $action);
            return $this->respondDeleted(['success' => true]);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }

    }
}
