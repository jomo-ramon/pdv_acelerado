<?= $this->extend('layouts/layout-default') ?>
<!-- Page Title -->
<?= $this->section('page-title') ?> Lojas
<?= $this->endSection() ?>

<!-- Page Header (Title and Subtitle) -->
<?= $this->section('header') ?>
<?= render_header('Lojas') ?>
<?= $this->endSection() ?>

<!-- Page Header Breadcumb -->
<?= $this->section('breadcumb') ?>
<?=
    render_breadcumb([
        'Administração' => '',
        'Lojas' => ''
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
                    <th>Loja</th>
                    <th>Razão Social</th>
                    <th>Responsável</th>
                    <th>CNPJ</th>
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
                <h1 class="modal-title fs-5" id="modalAddLabel">Adicionar Loja</h1>
            </div>
            <div class="modal-body">
                <?= form_open('/api/administracao/lojas/store', ['id' => 'formAddLoja', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addNomeFantasia" name="nome_fantasia"
                        placeholder="Nome Fantasia" required>
                    <label for="addNomeFantasia" class="form-label">Nome Fantasia</label>
                    <div class="invalid-feedback" data-field="nome_fantasia">
                        Forneça o nome fantasia.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addRazaoSocial" name="razao_social"
                        placeholder="Razão Social" required>
                    <label for="addRazaoSocial" class="form-label">Razão Social</label>
                    <div class="invalid-feedback" data-field="razao_social">
                        Forneça a razão social.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addNomeResponsavel" name="nome_responsavel"
                        placeholder="Nome Completo" required>
                    <label for="addNomerespBandeira" class="form-label">Nome do Responsável</label>
                    <div class="invalid-feedback" data-field="nome_responsavel">
                        Forneça o nome do responsável.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addCnpjLoja" name="cnpj_loja" placeholder="CNPJ"
                        required>
                    <label for="addCnpjLoja" class="form-label">CNPJ</label>
                    <div class="invalid-feedback" data-field='cnpj_loja'>
                        Forneça o CNPJ.
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="addIeLoja" name="ie_loja" maxlength="20"
                        placeholder="Inscrição Estadual" required>
                    <label for="addIeLoja" class="form-label">Inscrição Estadual</label>
                    <div class="invalid-feedback" data-field='ie_loja'>
                        Forneça a Inscrição Estadual.
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="negociacao" id="addNegociacaoLoja"
                            placeholder="Negociação" value="0,00">
                        <label for="addNegociacaoLoja">Negociação</label>
                    </div>
                    <span class="input-group-text">%</span>
                    <div class="invalid-feedback" data-field="negociacao">
                        Forneça um valor de negociação.
                    </div>
                </div>
                <div class="my-3">
                    <select class="form-control select2 flex-grow-1 w-100" id="select-single" name="id_bandeira"
                        aria-label="Vincular Bandeira" name="id_bandeira" placeholder="Vincular Bandeira">
                    </select>
                </div>
                <hr class="mt-4 mb-4" />
                <div class="d-flex gap-3 align-items-center">
                    <div class="form-floating flex-grow-1">
                        <input type="text" class="form-control" id="addEmailsLoja" placeholder="Email" required>
                        <label for="addEmailsLoja" class="form-label">Email</label>
                    </div>
                    <button type="button" class="btn btn-primary" id="buttonAddEmail"><i
                            class="bi bi-plus"></i></button>
                </div>
                <div id="emailsHelp" class="form-text mb-3">Lista com emails para contato. Digite um email e
                    aperte enter.
                </div>
                <div id="emailsList">
                    <p>Nenhum email adicionado</p>
                </div>
                <hr class="mt-4 mb-4" />
                <div class="d-flex gap-3 align-items-center">
                    <div class="form-floating flex-grow-1">
                        <input type="text" class="form-control" id="addTelefoneLoja" placeholder="Telefone" required>
                        <label for="addTelefoneLoja" class="form-label">Telefone</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkWhats">
                        <label class="form-check-label" for="checkWhats">
                            Whatsapp
                        </label>
                    </div>
                    <button type="button" class="btn btn-primary" id="buttonAddTelefone"><i
                            class="bi bi-plus"></i></button>
                </div>
                <div id="telefonesHelp" class="form-text mb-3">Lista com telefones para contato. Digite um telefone e
                    aperte enter.
                </div>
                <div id="telefoneList">
                    <p>Nenhum telefone adicionado</p>
                </div>
                <hr class="mt-4 mb-4" />
                <div class="form-floating mb-3 mt-3">
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
                <button type="submit" form="formAddLoja" class="btn btn-primary">
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
                <h1 class="modal-title fs-5" id="modalEditLabel">Editar Loja</h1>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills" id="tabEdit">
                    <li class="nav-item">
                        <button data-bs-target="#tab11" class="nav-link active text-decoration-none"
                            data-bs-toggle="tab">Dados
                            Pessoais</button>
                    </li>
                    <li class="nav-item">
                        <button data-bs-target="#tab12" class="nav-link text-decoration-none"
                            data-bs-toggle="tab">Emails</button>
                    </li>
                    <li class="nav-item">
                        <button data-bs-target="#tab13" class="nav-link text-decoration-none"
                            data-bs-toggle="tab">Telefones</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active p-2 pt-4" id="tab11">
                        <?= form_open('/api/administracao/lojas/update', ['id' => 'formEditLoja', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                        <input type="hidden" name="id_loja">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="editNomeLoja" name="nome_fantasia"
                                placeholder="Nome Fantasia" required>
                            <label for="editNomeLoja" class="form-label">Nome Fantasia</label>
                            <div class="invalid-feedback" data-field="nome_fantasia">
                                Forneça o nome da loja.
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="editRazaoSocial" name="razao_social"
                                placeholder="Razão Social" required>
                            <label for="editRazaoSocial" class="form-label">Razão Social</label>
                            <div class="invalid-feedback" data-field="razao_social">
                                Forneça o nome do representante.
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="editNomeRep" name="nome_responsavel"
                                placeholder="Nome Completo" required>
                            <label for="editNomeRep" class="form-label">Nome do Responsável</label>
                            <div class="invalid-feedback" data-field="nome_responsavel">
                                Forneça o nome do representante.
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="editCnpjLoja" name="cnpj_loja"
                                placeholder="CNPJ da Loja" required>
                            <label for="editCnpjLoja" class="form-label">CNPJ da Loja</label>
                            <div class="invalid-feedback" data-field='cnpj_loja'>
                                Forneça o CNPJ.
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="editIeLoja" name="ie_loja"
                                placeholder="CNPJ da Loja" required>
                            <label for="editIeLoja" class="form-label">Inscrição Estadual</label>
                            <div class="invalid-feedback" data-field='ie_loja'>
                                Forneça a Inscrição Estadual.
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="negociacao" id="editNegociacaoLoja"
                                    placeholder="Negociação">
                                <label for="editNegociacaoLoja">Negociação</label>
                            </div>
                            <span class="input-group-text">%</span>
                            <div class="invalid-feedback" data-field="negociacao">
                                Forneça um valor de negociação.
                            </div>
                        </div>
                        <?= form_close() ?>
                    </div>
                    <div class="tab-pane fade p-2 pt-4 position-relative" id="tab12">
                        <div class="loader d-flex justify-content-center align-items-center position-absolute w-100 h-100 top-0 start-0"
                            style="z-index:100">
                            <div class="spinner-border text-secondary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <?= form_open('/api/administracao/lojas/emails', ['id' => 'formLojasEmails', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                        <input type="hidden" name="id_loja">
                        <?= form_close() ?>
                        <?= form_open('/api/administracao/lojas/emails/add', ['id' => 'formVincularEmail', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                        <input type="hidden" name="id_loja">
                        <div class="d-flex gap-3 align-items-center mb-3">
                            <div class="form-floating flex-grow-1">
                                <input type="text" class="form-control" id="editEmailLoja" placeholder="Adicionar Email"
                                    name="email_loja" required>
                                <label for="editEmailLoja" class="form-label">Adicionar Email</label>
                            </div>
                            <button type="button" class="btn btn-primary" id="buttonEditAddEmail"><i
                                    class="bi bi-plus"></i></button>
                        </div>
                        <?= form_close() ?>
                        <div class="alert-area"></div>
                        <div class="result">
                        </div>
                    </div>
                    <div class="tab-pane fade p-2 pt-4 position-relative" id="tab13">
                        <div class="loader d-flex justify-content-center align-items-center position-absolute w-100 h-100 top-0 start-0"
                            style="z-index:100">
                            <div class="spinner-border text-secondary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <?= form_open('/api/administracao/lojas/telefones', ['id' => 'formLojasTelefones', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                        <input type="hidden" name="id_loja">
                        <?= form_close() ?>
                        <?= form_open('/api/administracao/lojas/telefones/add', ['id' => 'formVincularTelefone', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                        <input type="hidden" name="id_loja">
                        <div class="d-flex gap-3 align-items-center mb-3">
                            <div class="form-floating flex-grow-1">
                                <input type="text" class="form-control" id="editTelefoneLoja"
                                    placeholder="Adicionar Telefone" name="num_telefone" required>
                                <label for="editTelefoneLoja" class="form-label">Adicionar Telefone</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="editCheckWhats" name="is_whats">
                                <label class="form-check-label" for="editCheckWhats">
                                    Whatsapp
                                </label>
                            </div>
                            <button type="button" class="btn btn-primary" id="buttonEditAddTelefone"><i
                                    class="bi bi-plus"></i></button>
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
                <button type="submit" form="formEditLoja" class="btn btn-primary">
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
                <?= form_open('/api/administracao/lojas/destroy', ['id' => 'formRemoveLoja', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_loja">
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
                <button type="submit" form="formRemoveLoja" class="btn btn-primary">
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
                <?= form_open('/api/administracao/lojas/block', ['id' => 'formBlockLoja', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_loja">
                <input type="hidden" name="acao">
                <div class="row modal-message-block">
                    <div class="col-2 text-danger text-center fs-1">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="col-10 d-flex justify-content-center">
                        <p class="">Deseja realmente <span>bloquear</span> a loja <strong></strong>?</p>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Não
                </button>
                <button type="submit" form="formBlockLoja" class="btn btn-primary">
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
<script src="<?= base_url('assets/js/lojas/list.js') ?>"></script>
<?= $this->endSection() ?>