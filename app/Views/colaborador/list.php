<?= $this->extend('layouts/layout-default') ?>
<!-- Page Title -->
<?= $this->section('page-title') ?> Colaboradores
<?= $this->endSection() ?>

<!-- Page Header (Title and Subtitle) -->
<?= $this->section('header') ?>
<?= render_header('Colaboradores') ?>
<?= $this->endSection() ?>

<!-- Page Header Breadcumb -->
<?= $this->section('breadcumb') ?>
<?=
    render_breadcumb([
        'Administração' => '',
        'Colaboradores' => ''
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
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Loja</th>
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
                <h1 class="modal-title fs-5" id="modalAddLabel">Adicionar Colaborador</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/colaboradores/store', ['id' => 'formAddColaborador', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addNomeColaborador" name="nome_colaborador"
                        placeholder="Nome do Colaborador" required>
                    <label for="addNomeColaborador" class="form-label">Nome do Colaborador</label>
                    <div class="invalid-feedback" data-field="nome_colaborador">
                        Forneça o nome do colaborador.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addCpfColaborador" name="cpf_responsavel" placeholder="CPF"
                        required>
                    <label for="addCpfColaborador" class="form-label">CPF</label>
                    <div class="invalid-feedback" data-field='cpf_responsavel'>
                        Forneça o CPF.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addTelefone" name="telefone" placeholder="Telefone"
                        required>
                    <label for="addTelefone" class="form-label">Telefone</label>
                    <div class="invalid-feedback" data-field='telefone'>
                        Forneça o Telefone.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <select id="addTipoPix" name="tipo_pix" class="form-select">
                        <option value="cpf">CPF</option>
                        <option value="cnpj">CNPJ</option>
                        <option value="telefone">Telefone</option>
                        <option value="email">Email</option>
                        <option value="aleatorio">Chave Aleatória</option>
                    </select>
                    <label for="addTipoPix" class="form-label">Tipo de Pix</label>
                    <div class="invalid-feedback" data-field='tipo_pix'>
                        Forneça o Tipo de Pix.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addChavePix" name="chave_pix" placeholder="Chave Pix"
                        required>
                    <label for="addChavePix" class="form-label">Chave Pix</label>
                    <div class="invalid-feedback" data-field='chave_pix'>
                        Forneça a Chave Pix.
                    </div>
                </div>
                <div class="mb-3">
                    <select class="form-control select2 flex-grow-1 w-100" id="select-single" name="id_loja"
                        aria-label="Vincular Loja por CNPJ" name="id_loja" placeholder="Vincular Loja por CNPJ">
                    </select>
                    <div class="invalid-feedback" data-field="id_loja">
                        Forneça a loja.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Nome Completo"
                        required>
                    <label for="email" class="form-label">Email</label>
                    <div class="invalid-feedback" data-field="email">
                        Forneça o email do colaborador.
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
                        Forneça a senha.
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Fechar
                </button>
                <button type="submit" form="formAddColaborador" class="btn btn-primary">
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
                <h1 class="modal-title fs-5" id="modalEditLabel">Editar colaborador</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/colaboradores/update', ['id' => 'formEditColaborador', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_colaborador">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editNomeColaborador" name="nome_colaborador"
                        placeholder="Nome Completo" required>
                    <label for="editNomeColaborador" class="form-label">Nome Completo</label>
                    <div class="invalid-feedback" data-field="nome_colaborador">
                        Forneça o nome do colaborador.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editCpfColaborador" name="cpf_responsavel" placeholder="CPF" required>
                    <label for="editCpfResponsavel" class="form-label">CPF</label>
                    <div class="invalid-feedback" data-field='cpf_responsavel'>
                        Forneça o CPF.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editTelefone" name="telefone" placeholder="Telefone"
                        required>
                    <label for="editTelefone" class="form-label">Telefone</label>
                    <div class="invalid-feedback" data-field='telefone'>
                        Forneça o Telefone.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <select id="editTipoPix" name="tipo_pix" class="form-select">
                        <option value="cpf">CPF</option>
                        <option value="cnpj">CNPJ</option>
                        <option value="telefone">Telefone</option>
                        <option value="email">Email</option>
                        <option value="aleatorio">Chave Aleatória</option>
                    </select>
                    <label for="editTipoPix" class="form-label">Tipo de Pix</label>
                    <div class="invalid-feedback" data-field='tipo_pix'>
                        Forneça o Tipo de Pix.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="editChavePix" name="chave_pix" placeholder="Chave Pix"
                        required>
                    <label for="editChavePix" class="form-label">Chave Pix</label>
                    <div class="invalid-feedback" data-field='chave_pix'>
                        Forneça a Chave Pix.
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Fechar
                </button>
                <button type="submit" form="formEditColaborador" class="btn btn-primary">
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
                <?= form_open('/api/administracao/colaboradores/destroy', ['id' => 'formRemoveColaborador', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_colaborador">
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
                <button type="submit" form="formRemoveColaborador" class="btn btn-primary">
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
                <h1 class="modal-title fs-5" id="modalBlockLabel">Bloquear Colaborador</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/colaboradores/block', ['id' => 'formBlockColaborador', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_colaborador">
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
                <button type="submit" form="formBlockColaborador" class="btn btn-primary">
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
<script src="<?= base_url('assets/js/colaboradores/list.js') ?>"></script>
<?= $this->endSection() ?>