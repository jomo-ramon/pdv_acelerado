<?= $this->extend('layouts/layout-default') ?>
<!-- Page Title -->
<?= $this->section('page-title') ?> Administradores<?= $this->endSection() ?>

<!-- Page Header (Title and Subtitle) -->
<?= $this->section('header') ?>
<?= render_header('Administradores') ?>
<?= $this->endSection() ?>

<!-- Page Header Breadcumb -->
<?= $this->section('breadcumb') ?>
<?=
render_breadcumb([
    'Administração' => '',
    'Administradores' => ''
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
                    <th>Administrador</th>
                    <th>Email</th>
                    <th>Opções</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!-- Modal Adicionar -->
<div class="modal fade" id="modalAdd" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalAdd" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalAddLabel">Adicionar Administrador</h1>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/administradores/store', ['id' => 'formAddAdministrador', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nome_administrador" name="nome_administrador" placeholder="Nome Completo" required>
                    <label for="nome_administrador" class="form-label">Nome Completo</label>
                    <div class="invalid-feedback" data-field="nome_administrador">
                        Forneça o nome do administrador.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Nome Completo" required>
                    <label for="email" class="form-label">Email</label>
                    <div class="invalid-feedback" data-field="email">
                        Forneça o email do administrador.
                    </div>
                </div>
                <div class="input-group is-invalid mb-3">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" name="senha" placeholder="Senha" required>
                        <label for="password">Senha</label>
                    </div>
                    <button class="btn btn-outline-secondary" type="button" id="button-password"><i class="bi bi-eye-fill"></i></button>
                    <button class="btn btn-outline-secondary" type="button" 
                            data-bs-toggle="popover" 
                            data-bs-title="Critérios para a senha" 
                            data-bs-html="true" data-bs-placement="top"  
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
                <button type="submit" form="formAddAdministrador" class="btn btn-primary">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Editar -->
<div class="modal fade" id="modalEdit" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalEdit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditLabel">Editar Administrador</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/administradores/update', ['id' => 'formEditAdministrador', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_administrador">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nome_administrador" name="nome_administrador" placeholder="Nome Completo" required>
                    <label for="nome_administrador" class="form-label">Nome Completo</label>
                    <div class="invalid-feedback" data-field="nome_administrador">
                        Forneça o nome do administrador.
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Fechar
                </button>
                <button type="submit" form="formEditAdministrador" class="btn btn-primary">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Excluir -->
<div class="modal fade" id="modalRemove" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalRemove" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalRemoveLabel">Excluir Administrador</h1>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/administradores/destroy', ['id' => 'formRemoveAdministrador', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_administrador">
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
                <button type="submit" form="formRemoveAdministrador" class="btn btn-primary">
                    Excluir
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bloquear -->
<div class="modal fade" id="modalBlock" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalBlock" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalBlockLabel">Bloquear Administrador</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/administradores/block', ['id' => 'formBlockAdministrador', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_administrador">
                <input type="hidden" name="acao">
                <div class="row modal-message-block">
                    <div class="col-2 text-danger text-center fs-1">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="col-10 d-flex justify-content-center">
                        <p class="">Deseja realmente <span>bloquear</span> o administrador <strong></strong>?</p>
                    </div>
                </div> 
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Não
                </button>
                <button type="submit" form="formBlockAdministrador" class="btn btn-primary">
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
<script src="<?= base_url('assets/js/administradores/list.js') ?>"></script>
<?= $this->endSection() ?>