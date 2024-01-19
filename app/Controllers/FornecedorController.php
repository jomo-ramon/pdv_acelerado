<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TipoFornecedor;

class FornecedorController extends BaseController {

    public function index() {
        $data['tipo_fornecedor'] = (new TipoFornecedor())->findAll();
        $data['datatables'] = true;
        $data['mask'] = true;
        return view('fornecedor/list',$data);
    }
}