<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BandeiraModel;
use App\Models\LojaModel;
use App\Models\SistemaModel;
use CodeIgniter\API\ResponseTrait;

class BandeiraController extends BaseController
{
    use ResponseTrait;
    public function index(): string
    {
        $data['datatables'] = true;
        $data['mask'] = true;
        return view('bandeira/list', $data);
    }

    public function campanhas() {
        $data['datatables'] = true;
        $data['mask'] = true; 
        $data['select2'] = true;
        return view('bandeira/campanhas', $data);
    }

    public function nova_campanha() {
        $data['mask'] = true; 
        $data['select2'] = true;
        $model = new SistemaModel();
        $sistema = $model->getData();
        $data['sistema'] = $sistema;
        $bandeira = new BandeiraModel();
        $data['negociacao'] = $bandeira->getNegociacao();
        return view('bandeira/nova-campanha', $data);
    }
    
    public function select2()
    {
        $term = $this->request->getGet('term');
        $model = new BandeiraModel();
        $fornecedores = $model->listLojas();
        $data['results'] = $fornecedores;
        return $this->respond($data, 200);
    }
}
