<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class RepresentanteController extends BaseController {

    public function index() {
        //GET DADOS BANCO
        $data['datatables'] = true;
        $data['mask'] = true;
        $data['select2'] = true;
        return view('representante/list', $data);
    }
}
