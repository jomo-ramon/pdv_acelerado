<?php

namespace App\Libraries;
use App\Libraries\AccessAlias;

class AccessTable
{
    /**
     * 1 - SuperAdmin
     * 2 - Admin
     * 3 - Fornecedor
     * 4 - Representante
     * 5 - Loja
     * 6 - Bandeira
     * 7 - Colaborador
     */
    private array $table = [
        '1' => [
            ...AccessAlias::ADM_ADMINISTRADORES, 
            ...AccessAlias::ADM_FORNECEDORES,
            ...AccessAlias::ADM_REPRESENTANTES,
            ...AccessAlias::ADM_BANDEIRAS,
            ...AccessAlias::ADM_LOJAS,
            ...AccessAlias::ADM_COLABORADORES,
            ...AccessAlias::ADM_CAMPANHAS
        ],
        '2' => [
            ...AccessAlias::ADM_FORNECEDORES,
            ...AccessAlias::ADM_REPRESENTANTES,
            ...AccessAlias::ADM_BANDEIRAS,
            ...AccessAlias::ADM_LOJAS,
            ...AccessAlias::ADM_COLABORADORES,
        ],
        '3' => [],
        '4' => [],
        '5' => [
            ...AccessAlias::LOJAS
        ],
        '6' => [
            ...AccessAlias::BANDEIRAS
        ],
        '7' => []
    ];

    private array $menu = [
        '1' => [
            'administradores', 
            'campanhas',
            'fornecedores', 
            'representantes',
            'bandeiras',
            'lojas',
            'colaboradores'
        ],
        '2' => [
            'fornecedores',
            'representantes',
            'bandeiras',
            'lojas'
        ],
        '3' => [
            'fornecedores',
        ],
        '4' => [],
        '5' => [
            'menu_lojas'
        ],
        '6' => [
            'menu_bandeiras'
        ],
        '7' => [],
     ];

    public function canAccess(int $id_tipo, string $uri)
    {
        /* Rotas permitidas por padrão */
        /* RETIRAR A ROTA DE TESTES ANTES DE FAZER O DEPLOY */
        $default = ['dashboard', 'logout','block', 'resend', 'teste', 'ban'];
        if(in_array($uri, $default)){
            return true;
        }
        /* Rotas dinâmicas */
        $dinamic = [
            '/^unlock\/[a-z0-9]{64}/',
        ];
        foreach($dinamic as $regex){
            if(preg_match($regex, $uri)){
                return true;
            }
        }
        /* Verifica se a uri está na lista permitida */
        foreach($this->table[$id_tipo] as $route){
            if($route === $uri){
                return true;
            }
        }
        return false;
    }

    public function renderMenu(string $item)
    {
        $id_tipo = auth_data('tipo_usuario');
        if(in_array($item, $this->menu[$id_tipo])){
            return true;
        }
        return false;
    }
}