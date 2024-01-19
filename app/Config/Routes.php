<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

/* Rotas de login e de verificação */
$routes->get('/', 'LoginController::form', ['as' => 'login.form']);
$routes->post('/login', 'LoginController::login', ['as' => 'login.do']);
$routes->get('/logout', 'LoginController::logout', ['as' => 'logout', 'filter' => 'auth']);
/* Esqueceu a Senha */
$routes->get('/reset', 'LoginController::forgot_form', ['as' => 'login.reset']);
$routes->post('/reset/do', 'LoginController::forgot', ['as' => 'login.reset.do']);
$routes->get('/recover/(:alphanum)', 'LoginController::recover_form/$1', ['as' => 'login.recover.form']);
$routes->post('/recover/do', 'LoginController::recover/$1', ['as' => 'login.recover.do']);
/* Bloqueio e Validação de Email */
$routes->get('/ban', 'LoginController::ban', ['as' => 'ban', 'filter' => 'auth']);
$routes->get('/block', 'LoginController::block', ['as' => 'block', 'filter' => 'auth']);
$routes->post('/resend', 'LoginController::resend_validation', ['as' => 'block.resend', 'filter' => 'auth']);
$routes->get('/unlock/(:alphanum)', 'LoginController::unlock/$1', ['as' => 'block.unlock']);


/* Rotas do dashboard */
$routes->get('/dashboard', 'DashboardController::index', ['as' => 'dashboard']);
$routes->get('/campanhas', 'DashboardController::campanhas', ['as' => 'campanhas']);

/* Administradores */
$routes->get('/administradores', 'AdministradorController::index', ['as' => 'administrador.list']);

/* Fornecedores */
$routes->get('/fornecedores', 'FornecedorController::index', ['as' => 'fornecedor.list']);

/* Representantes */
$routes->get('/representantes', 'RepresentanteController::index', ['as' => 'representante.list']);

/* Bandeiras */
$routes->get('/bandeiras', 'BandeiraController::index', ['as' => 'bandeira.list']);

/* Lojas */
$routes->get('/lojas', 'LojaController::index', ['as' => 'loja.list']);

/* Colaboradores */
$routes->get('/colaboradores', 'ColaboradorController::index', ['as' => 'colaborador.list']);

/* Rotas para o Ajax (API) */
$routes->group('api', static function ($routes) {

    $routes->group('administracao', static function ($routes) {
        /* Rotas Ajax administradores */
        $routes->get('administradores/list', 'Api\AdministradorController::list');
        $routes->post('administradores/store', 'Api\AdministradorController::store');
        $routes->post('administradores/update', 'Api\AdministradorController::update');
        $routes->post('administradores/destroy', 'Api\AdministradorController::destroy');
        $routes->post('administradores/block', 'Api\AdministradorController::block');
        /* Rotas Ajax fornecedores */
        $routes->get('fornecedores/list', 'Api\FornecedorController::list');
        $routes->get('fornecedores/select2', 'Api\FornecedorController::select2');
        $routes->post('fornecedores/store', 'Api\FornecedorController::store');
        $routes->post('fornecedores/update', 'Api\FornecedorController::update');
        $routes->post('fornecedores/destroy', 'Api\FornecedorController::destroy');
        $routes->post('fornecedores/block', 'Api\FornecedorController::block');
        /* Rotas Ajax representantes */
        $routes->get('representantes/list', 'Api\RepresentanteController::listAll');
        $routes->post('representantes/store', 'Api\RepresentanteController::store');
        $routes->post('representantes/update', 'Api\RepresentanteController::update');
        $routes->post('representantes/fornecedores', 'Api\RepresentanteController::listFornecedores');
        $routes->post('representantes/vincular', 'Api\RepresentanteController::vincularFornecedores');
        $routes->post('representantes/desvincular', 'Api\RepresentanteController::desvincularFornecedores');
        $routes->post('representantes/destroy', 'Api\RepresentanteController::destroy');
        $routes->post('representantes/block', 'Api\RepresentanteController::block');
        /* Rotas Ajax bandeiras */
        $routes->get('bandeiras/list', 'Api\BandeiraController::list');
        $routes->post('bandeiras/store', 'Api\BandeiraController::store');
        $routes->post('bandeiras/update', 'Api\BandeiraController::update');
        $routes->post('bandeiras/block', 'Api\BandeiraController::block');
        $routes->post('bandeiras/destroy', 'Api\BandeiraController::destroy');
        /* Rotas Ajax lijas */
        $routes->get('lojas/list', 'Api\LojaController::list');
        $routes->get('lojas/select2', 'Api\LojaController::select2');
        $routes->post('lojas/store', 'Api\LojaController::store');
        $routes->post('lojas/update', 'Api\LojaController::update');
        $routes->post('lojas/emails', 'Api\LojaController::listEmails');
        $routes->post('lojas/telefones', 'Api\LojaController::listTelefones');
        $routes->post('lojas/block', 'Api\LojaController::block');
        $routes->post('lojas/destroy', 'Api\LojaController::destroy');
        $routes->post('lojas/emails/add', 'Api\LojaController::addEmail');
        $routes->post('lojas/emails/remove', 'Api\LojaController::removeEmail');
        $routes->post('lojas/telefones/add', 'Api\LojaController::addTelefone');
        $routes->post('lojas/telefones/remove', 'Api\LojaController::removeTelefone');

        /* Rotas Ajax colaboradores */
        $routes->get('colaboradores/list', 'Api\ColaboradorController::list');
        $routes->get('colaboradores/select2', 'Api\ColaboradorController::select2');
        $routes->post('colaboradores/store', 'Api\ColaboradorController::store');
        $routes->post('colaboradores/update', 'Api\ColaboradorController::update');
        $routes->post('colaboradores/block', 'Api\ColaboradorController::block');
        $routes->post('colaboradores/destroy', 'Api\ColaboradorController::destroy');

        /* Campanhas */
        $routes->get('campanhas/list', 'Api\CampanhaController::listAll');
    });
    
});

$routes->group('loja', static function ($routes) {
    $routes->get('campanhas', 'LojaController::campanhas', ['as' => 'loja.campanhas']);
    $routes->get('campanha/list', 'Api\CampanhaController::list', ['as' => 'loja.campanhas.list']);
    $routes->get('campanha/nova', 'LojaController::nova_campanha', ['as' => 'loja.campanha.nova']);
    $routes->post('campanha/store', 'Api\CampanhaController::store_loja', ['as' => 'loja.campanha.store']);
    $routes->get('pesquisa/produtos', 'Api\ProdutoController::search');
    $routes->post('produto/store', 'Api\ProdutoController::store', ['as' => 'loja.produtos.store']);
});

$routes->group('bandeira', static function ($routes) {
    $routes->get('campanhas', 'BandeiraController::campanhas', ['as' => 'bandeira.campanhas']);
    $routes->get('campanha/list', 'Api\CampanhaController::list', ['as' => 'bandeira.campanhas.list']);
    $routes->get('campanha/nova', 'BandeiraController::nova_campanha', ['as' => 'bandeira.campanha.nova']);
    $routes->post('campanha/store', 'Api\CampanhaController::store_bandeira');
    $routes->get('pesquisa/produtos', 'Api\ProdutoController::search');
    $routes->post('produto/store', 'Api\ProdutoController::store');

    $routes->get('lojas/list', 'BandeiraController::select2');
});


/* ROTA DE TESTES APAGAR DEPOIS !!!!!!!!!!!!!!!!!!!! */
$routes->get('/teste', 'TesteController::index');
$routes->post('/teste', 'TesteController::index');
/* APAGARRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR */

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}