<?php

namespace App\Libraries;

class Sendmail
{
    private static string $team_email = "admin@pdvacelerado.com";
    private static array $config = [
        'protocol' => 'smtp',
        'SMTPHost' => '',
        'SMTPPort' => '2525',
        'SMTPUser' => '',
        'SMTPPass' => '',
        'wordWrap' => true,
        'charset'  => 'utf-8',
        'mailType' => 'html',
    ]; 

    public static function change_password(string $address, string $token): bool
    {
        $email = \Config\Services::email();
        $email->initialize(self::$config);
        $email->setFrom(self::$team_email, 'Equipe PDV');
        $email->setTo($address);

        $email->setSubject('Alteração de Senha');
        $message = view('emails/redefinir', ['link' => base_url('recover/' . $token)]);
        $email->setMessage($message);
        $send = $email->send();
        if($send){
            return true;
        }
        return false;
    }

    public static function verify_email(string $address, string $token): bool
    {
        $email = \Config\Services::email();
        $email->initialize(self::$config);
        $email->setFrom(self::$team_email, 'Equipe PDV');
        $email->setTo($address);

        $email->setSubject('Verificação de Email');
        $message = view('emails/verificar', ['link' => base_url('unlock/' . $token)]);
        $email->setMessage($message);
        $send = $email->send();
        if($send){
            return true;
        }
        return false;
    }
}