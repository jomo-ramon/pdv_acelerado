<?= $this->extend('layouts/layout-default') ?>
<!-- Page Title -->
<?= $this->section('page-title') ?> Representantes
<?= $this->endSection() ?>

<!-- Page Header (Title and Subtitle) -->
<?= $this->section('header') ?>
<?= render_header('Representantes') ?>
<?= $this->endSection() ?>

<!-- Page Header Breadcumb -->
<?= $this->section('breadcumb') ?>
<?=
    render_breadcumb([
        'Administração' => '',
        'Fornecedores' => '',
        'Representantes' => ''
    ])
    ?>
<?= $this->endSection() ?>

<!-- Content -->
<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <div class="d-grid gap-2 d-md-flex justify-content-md-between" id="header-wrapper">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#modalAdd">
                <i class="bi bi-plus"></i>
                Adicionar
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table" id="tableRepresentantes">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Representante</th>
                    <th>Forecedores</th>
                    <th>Opções</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal Adicionar -->
<div class="modal fade" id="modalAdd" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="modalAdd" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Adicionar Representante</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/representantes/store', ['id' => 'formAddRepresentante', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addNomeRep" name="nome_representante"
                        placeholder="Nome Completo" required>
                    <label for="addNomeRep" class="form-label">Nome Completo</label>
                    <div class="invalid-feedback" data-field="nome_representante">
                        Forneça o nome do representante.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addCpfRep" name="cpf_responsavel" placeholder="CPFF"
                        required>
                    <label for="addCpfRep" class="form-label">CPF</label>
                    <div class="invalid-feedback" data-field='cpf_responsavel'>
                        Forneça o CPF.
                    </div>
                </div>
                <div class="mb-3">
                    <select class="form-control select2" id="select-one" multiple aria-label="multiple select example"
                        name="fornecedores[]" placeholder="Escolha os fornecedores">
                        <option>Escolha os fornecedores</option>
                    </select>
                    <div id="fornecedorHelp" class="form-text">Para representante autônomo deixe esse campo em branco.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="addEmailUserRep" name="email"
                        placeholder="name@example.com">
                    <label for="addEmailUserRep">E-mail</label>
                    <div class="invalid-feedback" data-field="email">
                        Forneça o e-mail
                    </div>
                </div>
                <div class="input-group is-invalid mb-3">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="addSenhaUserRep" name="senha"
                            placeholder="Senha" required>
                        <label for="addSenhaUserRep">Senha</label>
                    </div>
                    <button class="btn btn-outline-secondary" type="button" id="button-password"><i
                            class="bi bi-eye-fill"></i></button>
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="popover"
                        data-bs-title="Critérios para a senha" data-bs-html="true" data-bs-placement="top"
                        data-bs-content="A senha deve ter no mínimo 8 caracteres.<br/>
                            A senha precisa ter no mínimo:<br/>
                            <ul><li>um número.</li><li>um caracter minúsculo.</li><li>um caracter maiúsculo</li><li>um caracter especial</li></ul>">
                        <i class="bi bi-info-circle-fill"></i></button>
                    <div class="invalid-feedback" data-field="senha">
                        Forneça a senha
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" form="formAddRepresentante" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEdit" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="modalEdit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditLabel">Editar Representante</h1>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills" id="tabEdit">
                    <li class="nav-item">
                        <button data-bs-target="#tab11" class="nav-link active text-decoration-none" data-bs-toggle="tab">Dados
                            Pessoais</button>
                    </li>
                    <li class="nav-item">
                        <button data-bs-target="#tab12" class="nav-link text-decoration-none" data-bs-toggle="tab">Fornecedores</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active p-2 pt-4" id="tab11">
                        <?= form_open('/api/administracao/representantes/update', ['id' => 'formEditRepresentante', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                        <input type="hidden" name="id_representante">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="editNomeRep" name="nome_representante"
                                placeholder="Nome Completo" required>
                            <label for="editNomeRep" class="form-label">Nome Completo</label>
                            <div class="invalid-feedback" data-field="nome_representante">
                                Forneça o nome do representante.
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="editCpfRep" name="cpf_responsavel"
                                placeholder="CPFF" required>
                            <label for="editCpfRep" class="form-label">CPF</label>
                            <div class="invalid-feedback" data-field='cpf_responsavel'>
                                Forneça o CPF.
                            </div>
                        </div>
                        <?= form_close() ?>
                    </div>
                    <div class="tab-pane fade p-2 pt-4 position-relative" id="tab12">
                        <div class="loader d-flex justify-content-center align-items-center position-absolute w-100 h-100 top-0 start-0" style="z-index:100">
                            <div class="spinner-border text-secondary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <?= form_open('/api/administracao/representantes/fornecedores', ['id' => 'formFornecedorRepresentante', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                            <input type="hidden" name="id_representante">
                        <?= form_close() ?>
                        <?= form_open('/api/administracao/representantes/vincular', ['id' => 'formVincularRepresentante', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                        <input type="hidden" name="id_representante">
                        <div class="mb-3 row px-1">
                            <div class="col-10">
                                <select class="form-control select2 flex-grow-1 w-100" id="select-single"
                                    name="id_fornecedor"
                                    aria-label="Vincular Fornecedor" name="fornecedore"
                                    placeholder="Vincular Fornecedor">
                                </select>
                            </div>
                            <div class="col-2 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary btn-add-fornecedor mb-1 ml-1"><i
                                        class="bi bi-plus"></i></button>
                            </div>
                        </div>
                        <?= form_close() ?>
                        <div class="alert-area"></div>
                        <div class="result">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Fechar
                </button>
                <button type="submit" form="formEditRepresentante" class="btn btn-primary">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Excluir -->
<div class="modal fade" id="modalRemove" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalRemove"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalRemoveLabel">Excluir Representante</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/representantes/destroy', ['id' => 'formRemoveRepresentante', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_representante">
                <div class="row modal-message-delete">
                    <div class="col-2 text-danger text-center fs-1">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="col-10 d-flex justify-content-center">
                        <p class="">Deseja realmente excluir o representante <strong></strong>?</p>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Não
                </button>
                <button type="submit" form="formRemoveRepresentante" class="btn btn-primary">
                    Excluir
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bloquear -->
<div class="modal fade" id="modalBlock" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalBlock"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalBlockLabel">Bloquear Representante</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/representantes/block', ['id' => 'formBlockRepresentante', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_representante">
                <input type="hidden" name="acao">
                <div class="row modal-message-block">
                    <div class="col-2 text-danger text-center fs-1">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="col-10 d-flex justify-content-center">
                        <p class="">Deseja realmente <span>bloquear</span> o representante <strong></strong>?</p>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Não
                </button>
                <button type="submit" form="formBlockRepresentante" class="btn btn-primary">
                    Bloquear
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detalhe -->
<div class="modal fade" id="modalDetalheRepresentante" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="modalDetalheRepresentante" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleDetalheLabel">Fornecedores</h1>
            </div>
            <div class="modal-body">
                <div class="loader d-flex justify-content-center align-items-center">
                    <div class="spinner-border text-secondary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <?= form_open('/api/administracao/representantes/fornecedores', ['id' => 'formDetalhesRepresentante', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_representante">
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- Scripts -->
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/utils.js') ?>"></script>
<script src="<?= base_url('assets/js/representantes/list.js') ?>"></script>
<?= $this->endSection() ?>