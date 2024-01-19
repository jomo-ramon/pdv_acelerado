<?= $this->extend('layouts/layout-default') ?>
<!-- Page Title -->
<?= $this->section('page-title') ?> Nova Campanha
<?= $this->endSection() ?>

<!-- Page Header (Title and Subtitle) -->
<?= $this->section('header') ?>
<?= render_header('Nova Campanha') ?>
<?= $this->endSection() ?>

<!-- Page Header Breadcumb -->
<?= $this->section('breadcumb') ?>
<?=
    render_breadcumb([
        'Loja' => '',
        'Campanhas' => '',
        'Nova Campanha' => ''
    ])
    ?>
<?= $this->endSection() ?>

<!-- Content -->
<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <!-- <div class="d-grid gap-2 d-md-flex justify-content-md-between" id="header-wrapper">
            <a href="#" class="btn btn-primary">
                <i class="bi bi-plus"></i>
                Adicionar
            </a>
        </div> -->
    </div>
    <div class="card-body">
        <?= form_open('/loja/campanha/store', ['id' => 'formAddCampanha', 'class' => 'needs-validation', 'novalidate' => true]) ?>
        <input type="hidden" name="percent" value="<?= $sistema->lucro ?>">
        <input type="hidden" name="negociacao" value="<?= $negociacao ?>">
        <div id="inputsProducts"></div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="addNomeCampanha" name="nome_campanha"
                placeholder="Nome da Campanha" required>
            <label for="addNomeCampanha" class="form-label">Nome da Campanha</label>
            <div class="invalid-feedback" data-field="nome_campanha">
                Forneça o nome fantasia.
            </div>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="addDescricaoCampanha" name="descricao"
                placeholder="Descrição da Campanha" required style="height: 100px"></textarea>
            <label for="addDescricaoCampanha" class="form-label">Descrição da Campanha</label>
            <div class="invalid-feedback" data-field="descricao">
                Forneça a descrição da campanha.
            </div>
        </div>
        <div class="row g-2">
            <div class="col-md">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addDataInicio" name="data_inicio"
                        placeholder="Data de Início" required>
                    <label for="addDataInicio" class="form-label">Data de Início</label>
                    <div class="invalid-feedback" data-field="data_inicio">
                        Forneça a data de início.
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addDataFinal" name="data_final" placeholder="Data Final"
                        required disabled>
                    <label for="addDataFinal" class="form-label">Data Final</label>
                    <div class="invalid-feedback" data-field="data_final">
                        Forneça a data final.
                    </div>
                </div>
            </div>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" id="addObservacaoCampanha" name="observacao" placeholder="Observações"
                required style="height: 100px"></textarea>
            <label for="addObservacaoCampanha" class="form-label">Observações</label>
            <div class="invalid-feedback" data-field="observacao">
                Forneça uma observação.
            </div>
        </div>
        <div class="row g-2 mb-3">
            <div class="col-md">
                <input type="text" class="form-control-plaintext" id="addQtdProdutos" name="qtd_produtos"
                    value="Quantidade de produtos: 0" readonly>
                <div class="invalid-feedback" data-field="produtos">
                    Forneça os produtos para a campanha.
                </div>
            </div>
            <div class="col-md">
                <input type="text" class="form-control-plaintext" id="addTotalCampanha" name="total_campanha"
                    value="Total da campanha: R$ 0,00" readonly>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                data-bs-target="#modalProdutos">Adicionar
                Produtos</button>
            <button class="btn btn-primary ms-auto" type="submit" form="formAddCampanha">Submeter Campanha</button>
        </div>
        <?= form_close() ?>
    </div>
</div>

<!-- Modal Produtos -->
<div class="modal modal-xl fade" id="modalProdutos" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="modalProdutos" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalProdutosLabel">Adicionar Produtos</h1>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="nav nav-pills" id="tabProduto">
                            <li class="nav-item">
                                <button data-bs-target="#tab11" class="nav-link active text-decoration-none"
                                    data-bs-toggle="tab">Adicionar Produto</button>
                            </li>
                            <li class="nav-item">
                                <button data-bs-target="#tab12" class="nav-link text-decoration-none"
                                    data-bs-toggle="tab">Cadastrar Produto</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active p-2 pt-4" id="tab11">
                                <div class="d-flex gap-2 my-2">
                                    <div class="form-floating flex-fill">
                                        <input type="text" class="form-control" id="eanSearch" placeholder="EAN">
                                        <label for="eanSearch">EAN</label>
                                    </div>
                                    <div class="form-floating w-25">
                                        <input type="text" class="form-control" id="eanQtd" placeholder="Quantidade">
                                        <label for="eanQtd">Quantidade</label>
                                    </div>
                                    <div class="form-floating w-25">
                                        <input type="text" class="form-control" id="eanValue" placeholder="Valor">
                                        <label for="eanValue">Valor R$</label>
                                    </div>
                                </div>
                                <div id="searchResultArea">
                                    <p class="m-2 d-none">Nenhum produto encontrado</p>
                                    <table class="d-none table table-striped" id="tableSearch">
                                        <thead>
                                            <tr>
                                                <th>EAN</th>
                                                <th>Descrição</th>
                                                <th style="width:32px"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>9795450563300</td>
                                                <td>Hederaflux Xarope 100ml</td>
                                                <td><button class="btn btn-primary"><i class="bi bi-plus"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade show p-2 pt-4 position-relative" id="tab12">
                                <?= form_open('/loja/produto/store', ['id' => 'formAddProduto', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="addEanProduto" name="ean"
                                        placeholder="EAN" required>
                                    <label for="addEanProduto" class="form-label">EAN</label>
                                    <div class="invalid-feedback" data-field="ean">
                                        Forneça o ean do produto.
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" id="addDesricaoProduto" name="descricao_produto"
                                        placeholder="Descrição" required style="height: 100px"></textarea>
                                    <label for="addDesricaoProduto" class="form-label">Descrição</label>
                                    <div class="invalid-feedback" data-field="descricao_produto">
                                        Forneça uma descrição.
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="addIndustriaProduto"
                                        name="nome_industria" placeholder="Indústria" required>
                                    <label for="addIndustriaProduto" class="form-label">Indústria</label>
                                    <div class="invalid-feedback" data-field="nome_industria">
                                        Forneça a industria.
                                    </div>
                                </div>
                                <button class="btn btn-primary" form="formAddProduto">Salvar</button>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        Lista de Produtos
                        <div id="listaProdutosArea">
                            <p class="m-2">Nenhum produto adicionado</p>
                            <table class="d-none table table-striped" id="tableProducts">
                                <thead>
                                    <tr>
                                        <th>EAN</th>
                                        <th>Descrição</th>
                                        <th>Valor</th>
                                        <th>Quantia</th>
                                        <th style="width:32px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>9795450563300</td>
                                        <td>Hederaflux Xarope 100ml</td>
                                        <td>R$ 1,50</td>
                                        <td><button class="btn btn-danger"><i class="bi bi-trash"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sucesso -->
<div class="modal fade" id="modalInfo" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalInfo"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalInfoLabel">Sucesso!</h1>
            </div>
            <div class="modal-body">
                <p>A campanha foi enviada para a revisão e entrará no ar após a confirmação do pagamento!</p>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="pix"
                        placeholder="Pix de Pagamento" readonly><?= $sistema->chave_pix ?></textarea>
                    <label for="pix" class="form-label">Pix de Pagamento</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- Scripts -->
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/utils.js') ?>"></script>
<script src="<?= base_url('assets/js/lojas/nova-campanha.js') ?>"></script>
<?= $this->endSection() ?>