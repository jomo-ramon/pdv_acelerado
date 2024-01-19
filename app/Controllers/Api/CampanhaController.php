<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\BandeiraModel;
use App\Models\CampanhaModel;
use App\Models\LojaModel;
use App\Models\SistemaModel;
use CodeIgniter\API\ResponseTrait;

class CampanhaController extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        //
    }

    public function list() 
    {
        $model = new CampanhaModel();
        $campanhas = $model->listAllByUser();
        return $this->respond(['data' => $campanhas], 200);
    }

    public function listAll() 
    {
        $model = new CampanhaModel();
        $campanhas = $model->listAll();
        return $this->respond(['data' => $campanhas], 200);
    }

    public function store_loja()
    {

        $rules = [
            'nome_campanha' => 'required|min_length[3]',
            'descricao' => 'required|min_length[3]',
            'data_inicio' => 'required|valid_date[d/m/Y]',
            'data_final' => 'required|valid_date[d/m/Y]',
            'produtos' => 'required'
        ];
        $messages = [
            'nome_campanha' => [
                'required' => 'Forneça o nome da campanha.',
                'min_length' => 'O nome da campanha deve ter no mínimo {param} caracteres'
            ],
            'descricao' => [
                'required' => 'Forneça a descrição.',
                'min_length' => 'A descrição deve ter no mínimo {param} caracteres'
            ],
            'data_inicio' => [
                'required' => 'Forneça a data inicial.',
                'valid_date' => 'Forneça uma data válida.'
            ],
            'data_final' => [
                'required' => 'Forneça a data final.',
                'valid_date' => 'Forneça uma data válida.'
            ],
            'produtos' => [
                'required' => 'Forneça os produtos para a campanha.'
            ],
            
        ];
        
        if(!$this->validate($rules, $messages)){
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $user_type = auth_data('tipo_usuario');
            $type = [
                '3' => 'fornecedor',
                '5' => 'loja',
                '6' => 'rede'
            ];
            $campanha_data = [
                'id_criador' => auth_data('id_usuario'),
                'nome_campanha' => $this->request->getPost("nome_campanha"),
                'descricao' => $this->request->getPost("descricao"),
                'data_inicio' => convert_date_to_br($this->request->getPost("data_inicio")),
                'data_final' => convert_date_to_br($this->request->getPost("data_final")),
                'status' => 0,
                'tipo_campanha' => $type[$user_type]
            ];
            $sistema = (new SistemaModel)->getData();
            $db = \Config\Database::connect();
            $db->transException(true)->transStart();
            $db->table('campanhas')->insert($campanha_data);
            $id_campanha = $db->insertID();
            $produtos = $this->request->getPost('produtos'); 
            $total_campanha_sem_descontos = 0.00;
            if(!is_null($produtos)){
                foreach($produtos as $produto){
                    $info = explode(":", $produto);
                    $produto_data = [
                        'id_produto' => $info[0],
                        'id_campanha' => $id_campanha,
                        'valor_premiacao' => str_replace(",", ".", $info[1]),
                        'num_produtos' => $info[2],
                    ];
                    $db->table('produto_campanha')->insert($produto_data);
                    $total_produto = floatval($info[1]) * intval($info[2]);
                    $total_campanha_sem_descontos += $total_produto;
                }
            }
            /* Adiciona total com descontos na campanha */
            $negociacao_loja = (new LojaModel())->getNegociacao();
            $desconto = ($total_campanha_sem_descontos * $negociacao_loja) / 100;
            $total_campanha_com_desconto = $total_campanha_sem_descontos - $desconto;
            $total_capanha = $total_campanha_com_desconto + (($total_campanha_com_desconto * $sistema->lucro) / 100);
            
            $db->table('campanhas')->where('id_campanha', $id_campanha)->update([
                'total_campanha' => $total_capanha
            ]);
            /* Adicionar a campanha para cada colaborador da loja */
            $colaboradores_loja = (new LojaModel())->getColaboradoresFromLoja();
            foreach ($colaboradores_loja as $colaborador) {
                $data_campanha_usuario = [
                    'id_campanha' => $id_campanha,
                    'id_usuario' => $colaborador
                ];
                $db->table('campanha_usuario')->insert($data_campanha_usuario);
            }
            $db->transComplete();
            return $this->respondCreated(['success' => true]);
        }catch(\Exception $e){
             return $this->fail($e->getMessage(), 400);
        }
    }

    public function store_bandeira()
    {

        $rules = [
            'nome_campanha' => 'required|min_length[3]',
            'descricao' => 'required|min_length[3]',
            'data_inicio' => 'required|valid_date[d/m/Y]',
            'data_final' => 'required|valid_date[d/m/Y]',
            'lojas' => 'valid_lojas',
            'produtos' => 'required'
        ];
        $messages = [
            'nome_campanha' => [
                'required' => 'Forneça o nome da campanha.',
                'min_length' => 'O nome da campanha deve ter no mínimo {param} caracteres'
            ],
            'descricao' => [
                'required' => 'Forneça a descrição.',
                'min_length' => 'A descrição deve ter no mínimo {param} caracteres'
            ],
            'data_inicio' => [
                'required' => 'Forneça a data inicial.',
                'valid_date' => 'Forneça uma data válida.'
            ],
            'data_final' => [
                'required' => 'Forneça a data final.',
                'valid_date' => 'Forneça uma data válida.'
            ],
            'produtos' => [
                'required' => 'Forneça os produtos para a campanha.'
            ],
            
        ];
        
        if(!$this->validate($rules, $messages)){
            return $this->fail($this->validator->getErrors(), 400);
        }
        try{
            $user_type = auth_data('tipo_usuario');
            $type = [
                '3' => 'fornecedor',
                '5' => 'loja',
                '6' => 'rede'
            ];
            $campanha_data = [
                'id_criador' => auth_data('id_usuario'),
                'nome_campanha' => $this->request->getPost("nome_campanha"),
                'descricao' => $this->request->getPost("descricao"),
                'data_inicio' => convert_date_to_br($this->request->getPost("data_inicio")),
                'data_final' => convert_date_to_br($this->request->getPost("data_final")),
                'status' => 0,
                'tipo_campanha' => $type[$user_type]
            ];
            $sistema = (new SistemaModel)->getData();
            $db = \Config\Database::connect();
            $db->transException(true)->transStart();
            $db->table('campanhas')->insert($campanha_data);
            $id_campanha = $db->insertID();
            $produtos = $this->request->getPost('produtos'); 
            $total_campanha_sem_descontos = 0.00;
            if(!is_null($produtos)){
                foreach($produtos as $produto){
                    $info = explode(":", $produto);
                    $produto_data = [
                        'id_produto' => $info[0],
                        'id_campanha' => $id_campanha,
                        'valor_premiacao' => str_replace(",", ".", $info[1]),
                        'num_produtos' => $info[2],
                    ];
                    $db->table('produto_campanha')->insert($produto_data);
                    $total_produto = floatval($info[1]) * intval($info[2]);
                    $total_campanha_sem_descontos += $total_produto;
                }
            }
            /* Adiciona total com descontos na campanha */
            $negociacao_bandeira = (new BandeiraModel())->getNegociacao();
            $desconto = ($total_campanha_sem_descontos * $negociacao_bandeira) / 100;
            $total_campanha_com_desconto = $total_campanha_sem_descontos - $desconto;
            $total_capanha = $total_campanha_com_desconto + (($total_campanha_com_desconto * $sistema->lucro) / 100);
            
            $db->table('campanhas')->where('id_campanha', $id_campanha)->update([
                'total_campanha' => $total_capanha
            ]);


            /* Verifica se as lojas está vazio (seleciona todas as lojas da rede) */
            $lojas = $this->request->getPost("lojas");
            $model_bandeira = new BandeiraModel();
            $lojas_ids = [];
            if(is_null($lojas)){
                $list_lojas_obj = $model_bandeira->listLojas();
                foreach($list_lojas_obj as $obj){
                    $lojas_ids[] = $obj['id'];
                }
            }else{
                $lojas_ids = $lojas;
            }

            foreach($lojas_ids as $id_loja){
                /* Adicionar a campanha para cada colaborador da loja */
                $colaboradores_loja = (new LojaModel())->getColaboradoresFromLojaById($id_loja);
                foreach ($colaboradores_loja as $colaborador) {
                    $data_campanha_usuario = [
                        'id_campanha' => $id_campanha,
                        'id_usuario' => $colaborador
                    ];
                    $db->table('campanha_usuario')->insert($data_campanha_usuario);
                }
            }

            
            $db->transComplete();
            return $this->respondCreated(['success' => true]);
        }catch(\Exception $e){
             return $this->fail($e->getMessage(), 400);
        }
    }
}
