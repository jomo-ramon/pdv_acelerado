<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDV Acelerado | <?= $this->renderSection('page-title') ?></title>

    <link rel="stylesheet" href="<?= base_url('assets/css/main/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/main/app-dark.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo/favicon.svg') ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo/favicon.png') ?>" type="image/png">
    <?php if (isset($datatables) && $datatables) : ?>
        <link href="<?= base_url('assets/extensions/datatables/css/dataTables.bootstrap5.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/extensions/datatables/css/buttons.bootstrap5.min.css') ?>" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
        <link href="<?= base_url('assets/extensions/datatables/css/responsive.bootstrap5.min.css') ?>" rel="stylesheet">
    <?php endif ?>
    <?php if (isset($select2) && $select2) : ?>
        <link href="<?= base_url('assets/extensions/select2/css/select2.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/extensions/select2/css/select2-bootstrap-5-theme.css') ?>" rel="stylesheet">
    <?php endif; ?>
    </head>

<body>
    <div id="app">
        <?= $this->include('layouts/partials/sidebar') ?>
        <div id="main" class='layout-navbar'>
            <?= $this->include('layouts/partials/navbar') ?>
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <?= $this->renderSection('header') ?>
                            <?= $this->renderSection('breadcumb') ?>
                        </div>
                    </div>
                    <section class="section">
                        <?= $this->renderSection('content') ?>
                    </section>
                </div>

                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2023 &copy; Sistemas Inteligentes</p>
                        </div>
                        <div class="float-end">
                            <p>Duvidas e ajuda <span class="text-success"><i class="bi bi-award"></i></span> entre em <a href="https://sistemasinteligentes.com.br">contato</a></p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?= base_url('assets/js/app.js'); ?>"></script>
    <?php if (isset($datatables) && $datatables) : ?>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

        <script src="<?= base_url('assets/extensions/datatables/js/jquery.dataTables.min.js') ?>"></script>
        <script src="<?= base_url('assets/extensions/datatables/js/dataTables.bootstrap5.min.js') ?>"></script>
        <script src="<?= base_url('assets/extensions/datatables/js/dataTables.buttons.min.js') ?>"></script>
        <script src="<?= base_url('assets/extensions/datatables/js/buttons.bootstrap5.min.js') ?>"></script>

        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

        <script src="<?= base_url('assets/extensions/datatables/js/dataTables.responsive.min.js') ?>"></script>
        <script src="<?= base_url('assets/extensions/datatables/js/responsive.bootstrap5.js') ?>"></script>
    <?php endif ?>
    <?php if (isset($mask) && $mask) : ?>
        <script src="<?= base_url('assets/extensions/jquery-mask/jquery.mask.min.js') ?>"></script>
    <?php endif ?>
    <?php if (isset($select2) && $select2) : ?>
        <script src="<?= base_url('assets/extensions/select2/js/select2.full.min.js') ?>"></script>
    <?php endif ?>
    <?= $this->renderSection('scripts') ?>
</body>

</html>