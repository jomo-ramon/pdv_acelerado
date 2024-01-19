<?php

namespace App\Libraries;

abstract class AccessAlias
{
    
    const ADM_ADMINISTRADORES = [
        'administradores',
        'campanhas',
        'api/administracao/administradores/list',
        'api/administracao/administradores/store',
        'api/administracao/administradores/update',
        'api/administracao/administradores/block',
        'api/administracao/administradores/destroy',
    ];
    const ADM_FORNECEDORES = [
        'fornecedores',
        'api/administracao/fornecedores/list',
        'api/administracao/fornecedores/store',
        'api/administracao/fornecedores/update',
        'api/administracao/fornecedores/block',
        'api/administracao/fornecedores/destroy',
    ];
    const ADM_REPRESENTANTES = [
        'representantes',
        'api/administracao/representantes/list',
        'api/administracao/representantes/store',
        'api/administracao/representantes/update',
        'api/administracao/representantes/block',
        'api/administracao/representantes/destroy',
        'api/administracao/fornecedores/select2',
        'api/administracao/representantes/fornecedores',
        'api/administracao/representantes/vincular',
        'api/administracao/representantes/desvincular',
    ];
    const ADM_BANDEIRAS = [
        'bandeiras',
        'api/administracao/bandeiras/list',
        'api/administracao/bandeiras/store',
        'api/administracao/bandeiras/update',
        'api/administracao/bandeiras/block',
        'api/administracao/bandeiras/destroy',
    ];
    const ADM_LOJAS = [
        'lojas',
        'api/administracao/lojas/list',
        'api/administracao/lojas/store',
        'api/administracao/lojas/select2',
        'api/administracao/lojas/update',
        'api/administracao/lojas/block',
        'api/administracao/lojas/destroy',
        'api/administracao/lojas/emails',
        'api/administracao/lojas/telefones',
        'api/administracao/lojas/emails/add',
        'api/administracao/lojas/emails/remove',
        'api/administracao/lojas/telefones/add',
        'api/administracao/lojas/telefones/remove',
    ];

    const ADM_COLABORADORES = [
        'colaboradores',
        'api/administracao/colaboradores/list',
        'api/administracao/colaboradores/store',
        'api/administracao/colaboradores/update',
        'api/administracao/colaboradores/block',
        'api/administracao/colaboradores/destroy',
        'api/administracao/colaboradores/select2',
    ];

    const ADM_CAMPANHAS = [
        'api/administracao/campanhas/list'
    ];

    const LOJAS = [
        'loja/campanhas',
        'loja/campanha/nova',
        'loja/pesquisa/produtos',
        'loja/produto/store',
        'loja/campanha/store',
        'loja/campanha/list'
    ];

    const BANDEIRAS = [
        'bandeira/campanhas',
        'bandeira/campanha/nova',
        'bandeira/pesquisa/produtos',
        'bandeira/produto/store',
        'bandeira/campanha/store',
        'bandeira/campanha/list',
        'bandeira/lojas/list',
    ];
}