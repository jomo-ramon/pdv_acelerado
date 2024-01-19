<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;

class TesteController extends BaseController
{
    public function index()
    {   
        dd(csrf_token(), csrf_hash());
        if($this->request->getMethod() === 'get'){
            echo form_open('/teste');
            echo <<<EOF
            <input type='text' name='email' placeholder='Email'><br/><br/>
            <input type='password' name='senha' placeholder='Senha'><br/>
            <input type='submit' value='Enviar'><br/>
            EOF;
            echo form_close();
        }else{
            $rules = [
                'email' => 'required|valid_email|is_unique[usuarios.email]',
                'senha' => 'required|min_length[8]|valid_password',
            ];
            if(!$this->validate($rules)){
                dd($this->validator->getErrors());
            }
        }
    }
}
