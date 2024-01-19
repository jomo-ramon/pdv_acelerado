<?php

namespace App\Validation;

use App\Models\FornecedorModel;
use App\Models\LojaModel;
use Exception;

class DatabaseRules
{
    public function in_table($value, $params, $data, ?string &$error = null): bool
    {
        $params = explode(',', $params);
        if(count($params) !== 2){
            $error = "Parâmetros insuficientes para in_table: use [tabela,chave_primaria].";
            return false;
        }
        $table = $params[0];
        $primary_key = $params[1];
        try{
            $db = db_connect();
            $response = $db->query("SELECT $primary_key FROM $table WHERE $primary_key=$value")->getResultArray();
            if(count($response) === 0){
                $error = "Identificador não encontrado.";
                return false;
            }
            return true;
        }catch(Exception $e){
            $error = "Erro na base de dados.";
            return false;
        }
    }

    public function is_unique_custom($value, $params, $data, ?string &$error = null): bool
    {
        $params = explode(',', $params);
        if(count($params) !== 2){
            $error = "Parâmetros insuficientes para in_table: use [tabela,campo].";
            return false;
        }
        $table = $params[0];
        $field = $params[1];
        try{
            $db = db_connect();
            $response = $db->query("SELECT $field FROM $table WHERE $field='$value' AND deleted_at IS NULL")->getResultArray();
            if(count($response) > 0){
                $error = "O email informado está em uso.";
                return false;
            }
            return true;
        }catch(Exception $e){
            $error = "Erro na base de dados.";
            return false;
        }
    }
    public function valid_fornecedor($value, ?string &$error = null): bool
    {
        try{
            if(is_null($value)) return true;
            $model = new FornecedorModel();
            foreach($value as $id){
                $response = $model->find($id);
                if(is_null($response)){
                    $error = 'Id do fornecedor inválido!';
                    return false;
                }
            }
            return true;
                
        }catch(Exception $e){
            $error = "Erro na base de dados.";
            return false;
        }
    }

    public function valid_lojas($value, ?string &$error = null): bool
    {
        if(is_null($value)){
            return true;
        }
        if(is_array($value)){
            $model = new LojaModel();
            foreach($value as $id){
                $loja = $model->find($id);
                if(is_null($loja)){
                    $error = "Formato de lojas inválido!";
                    return false;
                }
            }
            return true;
        }
        $error = "Formato de lojas inválido!";
        return false;
    }
}
