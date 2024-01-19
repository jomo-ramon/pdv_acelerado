<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDV Acelerado | Verifique seu email</title>
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
                    <?php if(isset($success)): ?>
                        <?= show_alert($success, 'success', true) ?>
                    <?php endif; ?>
                    <div class="text-center mt-5 text-lg fs-4">
                        <?= form_open('resend') ?>
                        <input type="hidden" name="token" value="<?= $token ?>">
                        <p class="text-gray-600">Uma mensagem com um link de validação de conta foi enviado para seu email. Caso não tenha recebido, verifique a caixa de spam ou clique no botão reenviar email de validação.</p>
                        <button type="submit" class="btn btn-info my-2 inline-block"><i class="bi bi-arrow-clockwise"></i> Renviar email de validação</button><br />
                        <a href="<?= route_to('logout') ?>" class="btn btn-danger my-2"><i class="bi bi-box-arrow-right"></i> Sair</a>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>
</body>

</html>