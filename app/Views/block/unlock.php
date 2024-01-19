<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDV Acelerado | Sucesso</title>
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo/favicon.svg'); ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo/favicon.png'); ?>" type="image/png">
    <link rel="stylesheet" href="<?= base_url('assets/css/pages/auth.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/main/app.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/main/app-dark.css'); ?>">
</head>

<body>
    <script src="<?= base_url('assets/js/static/initTheme.js') ?>"></script>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-8 offset-lg-2 col-12">
                <div id="auth-left">
                    <div class="mb-4 text-center">
                        <a href="/"><img class="img-fluid img-drop" style="max-width: 150px" src="<?= base_url('assets/images/logo/logo-680.png'); ?>" alt="Logo"></a>
                    </div>
                    <p class="auth-subtitle mb-5">Sucesso!</p>
                    <?= show_alert('Sua conta foi ativada com sucesso! Realize o login para acessar sua conta.', 'success') ?>
                    <p class="text-center">
                        <a href="<?= route_to('login.form') ?>" class="btn btn-info">Ir para o login</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
    <script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>
</body>

</html>