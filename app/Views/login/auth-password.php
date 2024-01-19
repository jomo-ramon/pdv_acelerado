<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDV Acelerado | Recuperação de Senha</title>
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
                    <?php endif ?>
                    <?php if(isset($send_error)): ?>
                        <?= show_alert($send_error, 'danger', true) ?>
                    <?php endif ?>
                    <p class="auth-subtitle mb-5">Insira seu e-mail e enviaremos um link de redefinição de senha.</p>

                    <?= form_open('reset/do', ['novalidate' => true]) ?>
                        <div class="form-group position-relative has-icon-left mb-4 <?= valid_field_bs($errors, 'email') ?>">
                            <input type="email" name="email" class="form-control form-control-xl " placeholder="Email" value="<?= old('email', '') ?>">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <?= valid_field_bs($errors, 'email', false) ?>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Enviar</button>
                    <?= form_close() ?>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Lembrou da sua conta? <a href="<?= route_to('login.form') ?>" class="font-bold">Login</a>.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>
    <script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>
</body>

</html>