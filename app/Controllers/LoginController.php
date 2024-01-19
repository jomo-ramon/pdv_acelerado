<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Sendmail;
use App\Models\UsuarioModel;

class LoginController extends BaseController
{
    public function form()
    {
        if (session()->has('login')) return redirect()->route('dashboard');
        $data = [];
        $errors = session()->getFlashdata('errors');
        if ($errors) $data['errors'] = $errors;
        return view('login/auth-login', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->route('login.form');
    }

    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];
        $messages = [
            'email' => [
                'required' => 'O campo email é obrigatório.',
                'valid_email' => 'Informe um email válido.'
            ],
            'password' => [
                'required' => 'O campo senha é obrigatório.'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return redirect()->route('login.form')->withInput()->with('errors', $this->validator->getErrors());
        }
        $email = $this->request->getPost('email');
        $password = strval($this->request->getPost('password'));
        $model = new UsuarioModel();
        $user = $model->where('email', $email)->first();
        if ($user) {
            $hash = $user->senha;
            if (password_verify($password, $hash)) {
                $data = (new UsuarioModel())->getAuthData($user->id_usuario);
                session()->set('login', $data[0]);
                return redirect()->route('dashboard');
            }
        }
        return redirect()->route('login.form')->withInput()->with('errors', ['default' => 'Credenciais inválidas!']);
    }

    public function forgot_form()
    {
        $data = [];
        $errors = session()->getFlashdata('errors');
        if ($errors) $data['errors'] = $errors;
        $success = session()->getFlashdata('success');
        if ($success) $data['success'] = $success;
        $send_error = session()->getFlashdata('send_error');
        if ($send_error) $data['send_error'] = $send_error;
        return view('login/auth-password', $data);
    }

    public function forgot()
    {
        $rules = [
            'email' => 'required|valid_email'
        ];
        $messages = [
            'email' => [
                'required' => 'O campo email é obrigatório.',
                'valid_email' => 'Informe um email válido.'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return redirect()->route('login.reset')->withInput()->with('errors', $this->validator->getErrors());
        }
        $email = $this->request->getPost('email');
        $model = new UsuarioModel();
        $usuario = $model->where('email', $email)->first();
        if($usuario){
            $token = auth_token_gen($usuario->email);
            $model->update($usuario->id_usuario, ['token_recuperacao' => $token]);
            $mail_response = Sendmail::change_password($usuario->email, $token);
        }
        $success = "Um link de recuperação será enviado para seu email, caso ele esteja registrado em nosso sistema. Caso não encontre, verifique a caixa de spam.";
        return redirect()->route('login.reset')->with('success', $success);
    }

    public function recover_form(string $token)
    {
        $model = new UsuarioModel();
        $user = $model->where('token_recuperacao', $token)->first();
        if(is_null($user)){
            return redirect()->route('login.form');
        }
        $data = [];
        $errors = session()->getFlashdata('errors');
        if ($errors) $data['errors'] = $errors;
        // Mostra o formulario de trocar senha
        $data['token'] = $token;
        return view('login/auth-change-pass', $data);
    }

    public function recover()
    {
        $token = $this->request->getPost('token', FILTER_SANITIZE_SPECIAL_CHARS);
        if(!$token){
            return redirect()->route('login.form');
        }
        $model = new UsuarioModel();
        $user = $model->where('token_recuperacao', $token)->first();
        if(is_null($user)){
            return redirect()->route('login.form');
        }
        $rules = [
            'password' => 'required|min_length[8]',
            'repeat' => 'required|matches[password]'
        ];
        $messages = [
            'password' => [
                'required' => 'O campo senha é obrigatório.',
                'min_length' => 'A senha precisa ter no mínimo 8 caracteres'
            ],
            'repeat' => [
                'required' => 'O campo confimação de senha é obrigatório.',
                'matches' => 'As senhas não conferem.'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return redirect()->to("/recover/$token")->withInput()->with('errors', $this->validator->getErrors());
        }
        $password = $this->request->getPost('password');
        $model->update($user->id_usuario, ['senha' => $password, 'token_recuperacao' => null]);
        $data['success'] = true;
        return view('login/auth-change-pass', $data);
    }

    public function block()
    {
        $success = session()->getFlashdata('success');
        if ($success) $data['success'] = $success;
        $token = auth_data('token_verificacao');
        $data['token'] = $token;
        return view('block/verification', $data);
    }

    public function ban()
    {
        return view('block/ban');
    }

    public function unlock(string $token)
    {
        $model = new UsuarioModel();
        $user = $model->where('token_verificacao', $token)->first();
        if(is_null($user)){
            return redirect()->route('login.form');
        }
        $model->update($user->id_usuario, ['token_verificacao' => null]);
        session()->destroy();
        return view('block/unlock');
    }

    public function resend_validation()
    {
        $token = strval($this->request->getPost('token', FILTER_SANITIZE_SPECIAL_CHARS));
        $model = new UsuarioModel();
        $user = $model->where('token_verificacao', $token)->first();
        if(is_null($user)){
            return redirect()->route('login.form');
        }
        $email = auth_data('email');
        Sendmail::verify_email($email, $token);
        $success = "Um email com o link de verificação foi enviado para o seu email!";
        return redirect()->route('block')->with('success', $success);
    }
}
