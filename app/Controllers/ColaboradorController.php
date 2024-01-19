<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ColaboradorController extends BaseController
{
    public function index(): string
    {
        $data['datatables'] = true;
        $data['mask'] = true;
        $data['select2'] = true;
        return view('colaborador/list', $data);
    }
}
