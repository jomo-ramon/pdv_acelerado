<?php

namespace App\Validation;

class PasswordRules
{
    public function valid_password($value, ?string &$error = null): bool
    {
        $messages = [];
        if(!preg_match('/.*[0-9].*/', $value)){
            $messages[] = "A senha precisa ter no mínimo um número.";
        }
        if(!preg_match('/.*[a-z].*/', $value)){
            $messages[] = "A senha precisa ter no mínimo um caracter minúsculo.";
        }
        if(!preg_match('/.*[A-Z].*/', $value)){
            $messages[] = "A senha precisa ter no mínimo um caracter maiúsculo.";
        }
        if(!preg_match('/.*[^a-zA-Z0-9].*/', $value)){
            $messages[] = "A senha precisa ter no mínimo um caracter especial.";
        }
        if(preg_match('/^ .*|.* $/', $value)){
            $messages[] = "A senha não pode conter espaços em branco no começo ou no final.";
        }
        if(!empty($messages)){
            $error = $messages;
            return false;
        }
        return true;
    }
}
