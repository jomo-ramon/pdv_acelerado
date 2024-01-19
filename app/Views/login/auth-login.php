<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDV Acelerado | Login</title>
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
                    <?= form_open('login', ['novalidate' => true]) ?>
                    <div class="form-group position-relative has-icon-left mb-4 <?= valid_field_bs($errors, 'email') ?>">
                        <input type="text" class="form-control form-control-xl" name="email" placeholder="E-mail" value="<?= old('email', '') ?>">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        <?= valid_field_bs($errors, 'email', false) ?>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4 <?= valid_field_bs($errors, 'password') ?>">
                        <input type="password" class="form-control form-control-xl" name="password" placeholder="Senha" value="<?= old('password', '') ?>">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <?= valid_field_bs($errors, 'password', false) ?>
                    </div>
                    <?= show_alert_if_error($errors, 'default', true) ?>
                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Entrar</button>
                    <?= form_close(); ?>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Não possui uma conta? <a href="auth-register.html" class="font-bold">Registre-se</a>.</p>
                        <p><a class="font-bold" href="<?= route_to('login.reset') ?>">Esqueceu a senha?</a></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>
</body>

</html>