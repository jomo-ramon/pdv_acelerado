<?= $this->extend('layouts/layout-default') ?>
<!-- Page Title -->
<?= $this->section('page-title') ?> Fornecedores
<?= $this->endSection() ?>

<!-- Page Header (Title and Subtitle) -->
<?= $this->section('header') ?>
<?= render_header('Fornecedores') ?>
<?= $this->endSection() ?>

<!-- Page Header Breadcumb -->
<?= $this->section('breadcumb') ?>
<?=
    render_breadcumb([
        'Administração' => '',
        'Fornecedores' => ''
    ])
    ?>
<?= $this->endSection() ?>

<!-- Content -->
<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <div class="d-grid gap-2 d-md-flex justify-content-md-between" id="header-wrapper">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
                <i class="bi bi-plus"></i>
                Adicionar
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table" id="tableFornecedores">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Razão Social</th>
                    <th>Responsável</th>
                    <th>Tipo</th>
                    <th>CNPJ</th>
                    <th>Opções</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!-- Modal Adicionar -->
<div class="modal fade" id="modalAdd" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalAddFornecedor"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Adicionar Fornecedor</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/fornecedores/store', ['id' => 'formAddFornecedor', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addNomeForn" name="nome_responsavel"
                        placeholder="Nome Completo" required>
                    <label for="addNomeForn" class="form-label">Nome Completo</label>
                    <div class="invalid-feedback" data-field="nome_responsavel">
                        Forneça o nome do responsável.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addCpfForn" name="cpf_responsavel" placeholder="CPFF"
                        required>
                    <label for="addCpfForn" class="form-label">CPF</label>
                    <div class="invalid-feedback" data-field='cpf_responsavel'>
                        Forneça o CPF.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="addTipoFornecedor" name="tipo_fornecedor" required>
                        <option selected disabled>Selecione um tipo</option>
                        <?php foreach ($tipo_fornecedor as $tipo): ?>
                            <option value="<?= $tipo->id_tipo_fornecedor ?>">
                                <?= $tipo->descricao_tipo_fornecedor ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <label for="addTipoFornecedor" class="form-label">Tipo</label>
                    <div class="invalid-feedback" data-field="tipo_fornecedor">
                        Escolha um tipo válido.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addRazaoSocialForn" name="razao_social"
                        placeholder="Razão Social" required>
                    <label for="addRazaoSocialForn" class="form-label">Razão Social</label>
                    <div class="invalid-feedback" data-field="razao_social">
                        Forneça a sua Razão Social.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addCnpjForn" name="cnpj" placeholder="CNPJ" required>
                    <label for="addCnpjForn">CNPJ</label>
                    <div class="invalid-feedback" data-field="cnpj">
                        Forneça o seu CNPJ.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="addEmailUserForn" name="email"
                        placeholder="name@example.com">
                    <label for="addEmailUserForn">E-mail</label>
                    <div class="invalid-feedback" data-field="email">
                        Forneça o e-mail
                    </div>
                </div>
                <div class="input-group is-invalid mb-3">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="addSenhaUserForn" name="senha"
                            placeholder="Senha" required>
                        <label for="addSenhaUserForn">Senha</label>
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
                <button type="submit" form="formAddFornecedor" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Editar -->
<div class="modal fade" id="modalEdit" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalEdit"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditLabel">Editar Fornecedor</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/fornecedores/update', ['id' => 'formEditFornecedor', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_fornecedor">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editNomeForn" name="nome_responsavel"
                        placeholder="Nome Completo" required>
                    <label for="editNomeForn" class="form-label">Nome Completo</label>
                    <div class="invalid-feedback" data-field="nome_responsavel">
                        Forneça o nome do responsável.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editCpfForn" name="cpf_responsavel" placeholder="CPFF"
                        required>
                    <label for="editCpfForn" class="form-label">CPF</label>
                    <div class="invalid-feedback" data-field='cpf_responsavel'>
                        Forneça o CPF.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="editTipoFornecedor" name="tipo_fornecedor" required>
                        <option selected disabled>Selecione um tipo</option>
                        <?php foreach ($tipo_fornecedor as $tipo): ?>
                            <option value="<?= $tipo->id_tipo_fornecedor ?>">
                                <?= $tipo->descricao_tipo_fornecedor ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <label for="editTipoFornecedor" class="form-label">Tipo</label>
                    <div class="invalid-feedback" data-field="tipo_fornecedor">
                        Escolha um tipo válido.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editRazaoSocialForn" name="razao_social"
                        placeholder="Razão Social" required>
                    <label for="editRazaoSocialForn" class="form-label">Razão Social</label>
                    <div class="invalid-feedback" data-field="razao_social">
                        Forneça a sua Razão Social.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editCnpjForn" name="cnpj" placeholder="CNPJ" required>
                    <label for="editCnpjForn">CNPJ</label>
                    <div class="invalid-feedback" data-field="cnpj">
                        Forneça o seu CNPJ.
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="negociacao" id="editNegociacaoFornecedor"
                            placeholder="Negociação">
                        <label for="editNegociacaoFornecedor">Negociação</label>
                    </div>
                    <span class="input-group-text">%</span>
                    <div class="invalid-feedback" data-field="negociacao">
                        Forneça um valor de negociação.
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Fechar
                </button>
                <button type="submit" form="formEditFornecedor" class="btn btn-primary">
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
                <h1 class="modal-title fs-5" id="modalRemoveLabel">Excluir Fornecedor</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/fornecedores/destroy', ['id' => 'formRemoveFornecedor', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_fornecedor">
                <div class="row modal-message-delete">
                    <div class="col-2 text-danger text-center fs-1">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="col-10 d-flex justify-content-center">
                        <p class="">Deseja realmente excluir o fornecedor <strong></strong>?</p>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Não
                </button>
                <button type="submit" form="formRemoveFornecedor" class="btn btn-primary">
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
                <h1 class="modal-title fs-5" id="modalBlockLabel">Bloquear Fornecedor</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/fornecedores/block', ['id' => 'formBlockFornecedor', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_fornecedor">
                <input type="hidden" name="acao">
                <div class="row modal-message-block">
                    <div class="col-2 text-danger text-center fs-1">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="col-10 d-flex justify-content-center">
                        <p class="">Deseja realmente <span>bloquear</span> o fornecedor <strong></strong>?</p>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Não
                </button>
                <button type="submit" form="formBlockFornecedor" class="btn btn-primary">
                    Bloquear
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- Scripts -->
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/utils.js') ?>"></script>
<script src="<?= base_url('assets/js/fornecedores/list.js') ?>"></script>
<?= $this->endSection() ?>