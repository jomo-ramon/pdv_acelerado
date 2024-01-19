<?php

namespace App\Validation;

class CustomRules
{
    public function valid_cpf($value, ?string &$error = null): bool
    {
        if(preg_match('/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/', $value)){
            return true;
        }
        $error = "Formato de CPF inválido.";
        return false;
    }

    public function valid_cnpj($value, ?string &$error = null): bool
    {
        if(preg_match('/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}$/', $value)){
            return true;
        }
        $error = "Formato de CNPJ inválido.";
        return false;
    }

    public function is_email_list($value, ?string &$error = null): bool
    {
        if(is_null($value)){
            return true;
        }
        if(!is_array($value)){
            $error = "O campo emails não contém uma lista de emails válidos.";
            return false;
        }
        $errors = [];
        foreach($value as $email){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors[$email] = "O email $email não é válido.";
            }
        }
        if(count($errors) > 0){
            $error = [$errors];
            return false;
        }
        return true;
    }
    public function is_telefone_list($value, ?string &$error = null): bool
    {
        if(is_null($value)){
            return true;
        }
        if(!is_array($value)){
            $error = "O campo telefones não contém uma lista de emails válidos.";
            return false;
        }
        $errors = [];
        foreach($value as $phone){
            if(!preg_match('/^[0-9]+\,[0,1]{1}$/', $phone)){
                $errors[$phone] = "O telefone $phone não é válido.";
            }
        }
        if(count($errors) > 0){
            $error = [$errors];
            return false;
        }
        return true;
    }

    public function valid_pix($value, $params, $data,  ?string &$error = null): bool
    {
        if(array_key_exists($params, $data)){
            $type_pix = $data[$params];
            switch ($type_pix) {
                case 'cpf':
                    if(preg_match('/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/', $value)){
                        return true;
                    }
                    break;
                case 'cnpj':
                    if(preg_match('/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}$/', $value)){
                        return true;
                    }
                    break;
                case 'telefone':
                    if(preg_match('/^[0-9]{11}$/', $value)){
                        return true;
                    }
                    break;
                case 'email':
                    if(preg_match('/^[a-zA-Z0-9\.]+\@[a-zA-Z0-9]+\.[a-zA-Z0-9]+[a-zA-Z0-9\.]*$/', $value)){
                        return true;
                    }
                    break;
                case 'aleatorio':
                    if(preg_match('/^[a-zA-Z0-9]{8}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{4}\-[a-zA-Z0-9]{12}$/', $value)){
                        return true;
                    }
                    break;
                default:
                    break;
            }
        }
        $error = "O formato da chave pix é inválido.";
        return false;
    }

    public function valid_negociacao($value, ?string &$error = null): bool
    {
        if(preg_match('/^[0-9]+[,]?[0-9]*$/', $value)){
            return true;
        }
        $error = "Formato de negociação inválido.";
        return false;
    }
}
