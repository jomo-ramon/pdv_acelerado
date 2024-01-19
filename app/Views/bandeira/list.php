<?= $this->extend('layouts/layout-default') ?>
<!-- Page Title -->
<?= $this->section('page-title') ?> Bandeiras
<?= $this->endSection() ?>

<!-- Page Header (Title and Subtitle) -->
<?= $this->section('header') ?>
<?= render_header('Bandeiras') ?>
<?= $this->endSection() ?>

<!-- Page Header Breadcumb -->
<?= $this->section('breadcumb') ?>
<?=
    render_breadcumb([
        'Administração' => '',
        'Bandeiras' => ''
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
        <table class="table" id="table1">
            <thead>
                <tr>
                    <th data-priority="-1"></th>
                    <th>ID</th>
                    <th>Bandeira</th>
                    <th>Responsável</th>
                    <th>Opções</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!-- Modal Adicionar -->
<div class="modal fade" id="modalAdd" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalAdd"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalAddLabel">Adicionar Bandeira</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/bandeiras/store', ['id' => 'formAddBandeira', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addNomeBandeira" name="nome_bandeira"
                        placeholder="Nome da Bandeira" required>
                    <label for="addNomeBandeira" class="form-label">Nome da Bandeira</label>
                    <div class="invalid-feedback" data-field="nome_bandeira">
                        Forneça o nome da bandeira.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addRazaoSocialBandeira" name="razao_social"
                        placeholder="Razão Social" required>
                    <label for="addRazaoSocialBandeira" class="form-label">Razão Social</label>
                    <div class="invalid-feedback" data-field="razao_social">
                        Forneça a sua Razão Social.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addCnpjBandeira" name="cnpj" placeholder="CNPJ"
                        required>
                    <label for="addCnpjBandeira">CNPJ</label>
                    <div class="invalid-feedback" data-field="cnpj">
                        Forneça o seu CNPJ.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addIeBandeira" name="ie" maxlength="20"
                        placeholder="Inscrição Estadual" required>
                    <label for="addIeBandeira" class="form-label">Inscrição Estadual</label>
                    <div class="invalid-feedback" data-field='ie'>
                        Forneça a Inscrição Estadual.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addNomeRespBandeira" name="nome_responsavel"
                        placeholder="Nome Completo" required>
                    <label for="addNomerespBandeira" class="form-label">Nome do Responsável</label>
                    <div class="invalid-feedback" data-field="nome_responsavel">
                        Forneça o nome do responsável.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addCpfBandeira" name="cpf" placeholder="CPFF" required>
                    <label for="addCpfBandeira" class="form-label">CPF</label>
                    <div class="invalid-feedback" data-field='cpf'>
                        Forneça o CPF.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addTelefoneBandeira" name="telefone" placeholder="CNPJ"
                        required>
                    <label for="addTelefoneBandeira">Telefone</label>
                    <div class="invalid-feedback" data-field="telefone">
                        Forneça o seu Telefone.
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="negociacao" id="addNegociacaoBandeira"
                            placeholder="Negociação" value="0,00">
                        <label for="addNegociacaoBandeira">Negociação</label>
                    </div>
                    <span class="input-group-text">%</span>
                    <div class="invalid-feedback" data-field="negociacao">
                        Forneça um valor de negociação.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Nome Completo"
                        required>
                    <label for="email" class="form-label">Email</label>
                    <div class="invalid-feedback" data-field="email">
                        Forneça o email do responsável.
                    </div>
                </div>
                <div class="input-group is-invalid mb-3">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" name="senha" placeholder="Senha"
                            required>
                        <label for="password">Senha</label>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Fechar
                </button>
                <button type="submit" form="formAddBandeira" class="btn btn-primary">
                    Salvar
                </button>
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
                <h1 class="modal-title fs-5" id="modalEditLabel">Editar Bandeira</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/bandeiras/update', ['id' => 'formEditBandeira', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_bandeira">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editNomeBandeira" name="nome_bandeira"
                        placeholder="Nome Completo" required>
                    <label for="editNomeBandeira" class="form-label">Nome da Bandeira</label>
                    <div class="invalid-feedback" data-field="nome_bandeira">
                        Forneça o nome da bandeira.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editRazaoSocialBandeira" name="razao_social"
                        placeholder="Razão Social" required>
                    <label for="editRazaoSocialBandeira" class="form-label">Razão Social</label>
                    <div class="invalid-feedback" data-field="razao_social">
                        Forneça a sua Razão Social.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editCnpjBandeira" name="cnpj" placeholder="CNPJ"
                        required>
                    <label for="editCnpjBandeira">CNPJ</label>
                    <div class="invalid-feedback" data-field="cnpj">
                        Forneça o seu CNPJ.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editIeBandeira" name="ie" maxlength="20"
                        placeholder="Inscrição Estadual" required>
                    <label for="editIeBandeira" class="form-label">Inscrição Estadual</label>
                    <div class="invalid-feedback" data-field='ie'>
                        Forneça a Inscrição Estadual.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editNomeRespBandeira" name="nome_responsavel"
                        placeholder="Nome Completo" required>
                    <label for="editNomerespBandeira" class="form-label">Nome do Responsável</label>
                    <div class="invalid-feedback" data-field="nome_responsavel">
                        Forneça o nome do responsável.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editCpfBandeira" name="cpf" placeholder="CPF" required>
                    <label for="editCpfBandeira" class="form-label">CPF</label>
                    <div class="invalid-feedback" data-field='cpf'>
                        Forneça o CPF.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editTelefoneBandeira" name="telefone" placeholder="CPF"
                        required>
                    <label for="editTelefoneBandeira" class="form-label">Telefone</label>
                    <div class="invalid-feedback" data-field='telefone'>
                        Forneça o Telefone.
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="negociacao" id="editNegociacaoBandeira"
                            placeholder="Negociação" value="0,00">
                        <label for="editNegociacaoBandeira">Negociação</label>
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
                <button type="submit" form="formEditBandeira" class="btn btn-primary">
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
                <h1 class="modal-title fs-5" id="modalRemoveLabel">Excluir Bandeira</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/bandeiras/destroy', ['id' => 'formRemoveBandeira', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_bandeira">
                <div class="row modal-message-delete">
                    <div class="col-2 text-danger text-center fs-1">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="col-10 d-flex justify-content-center">
                        <p class="">Deseja realmente excluir o usuário <strong></strong>?</p>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Não
                </button>
                <button type="submit" form="formRemoveBandeira" class="btn btn-primary">
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
                <h1 class="modal-title fs-5" id="modalBlockLabel">Bloquear Bandeira</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/bandeiras/block', ['id' => 'formBlockBandeira', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_bandeira">
                <input type="hidden" name="acao">
                <div class="row modal-message-block">
                    <div class="col-2 text-danger text-center fs-1">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="col-10 d-flex justify-content-center">
                        <p class="">Deseja realmente <span>bloquear</span> o usuário <strong></strong>?</p>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Não
                </button>
                <button type="submit" form="formBlockBandeira" class="btn btn-primary">
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
<script src="<?= base_url('assets/js/bandeiras/list.js') ?>"></script>
<?= $this->endSection() ?>