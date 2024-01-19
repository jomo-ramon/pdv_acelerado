<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;
use CodeIgniter\API\ResponseTrait;

class ProdutoController extends BaseController
{

    use ResponseTrait;
    public function index()
    {
        //
    }

    public function search()
    {
        $ean = $this->request->getGet("ean");
        $model = new ProdutoModel();
        $produtos = $model->select('id_produto as id, ean, descricao_produto')->like('ean', $ean)->findAll();
        $data['results'] = $produtos;
        return $this->respond($data, 200);
    }

    public function store(){
        $rules = [
            'ean' => 'required|numeric|is_unique[produtos.ean]',
            'descricao_produto' => 'required|min_length[3]',
            'nome_industria' => 'required|min_length[3]',
        ];
        $messages = [
            'ean' => [
                'required' => 'Forneça o EAN.',
                'numeric' => 'Formato de EAN inválido.',
                'is_unique' => 'EAN de produto já cadastrado.'
            ],
            'descricao_produto' => [
                'required' => 'Forneça a descrição do produto.',
                'min_length' => 'A descrição deve ter no mínimo {param} caracteres'
            ],
            'nome_industria' => [
                'required' => 'Forneça a indústria.',
                'min_length' => 'A indústria deve ter no mínimo {param} caracteres.'
            ],
        ];
        if(!$this->validate($rules, $messages)){
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $model = new ProdutoModel();
            $model->insert([
                'ean' => $this->request->getPost('ean'),
                'descricao_produto' => $this->request->getPost('descricao_produto'),
                'nome_industria' => $this->request->getPost('nome_industria'),
            ]);
            return $this->respondCreated(['success' => true]);
        }catch(\Exception $e){
             return $this->fail($e->getMessage(), 400);
        }
    }
}
