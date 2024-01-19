<?php

function auth_data(string $key): string{
    $auth = session()->get('login');
    if(property_exists($auth, $key)){
        return $auth->{$key};
    }
    return '';
}

function auth_token_gen(string $email){
    $key = "KbRbhHRrMwgMhvka7LvQMyznPItVNXbr";
    $now = date("Y-m-d H:i:s");
    $to_encript = $email . $now . $key;
    $enc = \Config\Services::encrypter();
    return substr(bin2hex($enc->encrypt($to_encript)), 0, 64);
}

function encrypt(string $value){
    $encrypter = \Config\Services::encrypter();
    return bin2hex($encrypter->encrypt($value));
}

function decrypt(string $value){
    $encrypter = \Config\Services::encrypter();
    return $encrypter->decrypt(hex2bin($value));
}

function can_render(string $item){
    $table = new App\Libraries\AccessTable();
    if($table->renderMenu($item)){
        return true;
    }
    return false;
}