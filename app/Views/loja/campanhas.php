<?= $this->extend('layouts/layout-default') ?>
<!-- Page Title -->
<?= $this->section('page-title') ?> Campanhas
<?= $this->endSection() ?>

<!-- Page Header (Title and Subtitle) -->
<?= $this->section('header') ?>
<?= render_header('Campanhas') ?>
<?= $this->endSection() ?>

<!-- Page Header Breadcumb -->
<?= $this->section('breadcumb') ?>
<?=
    render_breadcumb([
        'Loja' => '',
        'Campanhas' => ''
    ])
    ?>
<?= $this->endSection() ?>

<!-- Content -->
<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <div class="d-grid gap-2 d-md-flex justify-content-md-between" id="header-wrapper">
            <a href="<?= url_to('loja.campanha.nova') ?>" class="btn btn-primary">
                <i class="bi bi-plus"></i>
                Adicionar
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table" id="table1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Data de Início</th>
                    <th>Data de Término</th>
                    <th>Status</th>
                    <th>Observação</th>
                    <th>Opções</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal Comprovante -->
<div class="modal fade" id="modalComprovante" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modalComprovante"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalComprovanteLabel">Enviar comprovante</h1>
            </div>
            <div class="modal-body">
                <?= form_open('', ['id' => 'formAddComprovante', 'class' => 'needs-validation', 'novalidate' => true]) ?>
                <input type="hidden" name="id_bandeira">
                
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="submit" form="formAddComprovante" class="btn btn-primary">
                    Enviar
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- Scripts -->
<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/utils.js') ?>"></script>
<script src="<?= base_url('assets/js/lojas/campanha-list.js') ?>"></script>
<?= $this->endSection() ?>