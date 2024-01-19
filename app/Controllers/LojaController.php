<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\LojaModel;
use App\Models\SistemaModel;

class LojaController extends BaseController {

    public function index() {
        $data['datatables'] = true;
        $data['mask'] = true; 
        $data['select2'] = true;
        return view('loja/list', $data);
    }

    public function campanhas() {
        $data['datatables'] = true;
        $data['mask'] = true; 
        $data['select2'] = true;
        return view('loja/campanhas', $data);
    }

    public function nova_campanha() {
        $data['mask'] = true; 
        $data['select2'] = true;
        $model = new SistemaModel();
        $sistema = $model->getData();
        $data['sistema'] = $sistema;
        $loja = new LojaModel();
        $data['negociacao'] = $loja->getNegociacao();
        return view('loja/nova-campanha', $data);
    }
}
