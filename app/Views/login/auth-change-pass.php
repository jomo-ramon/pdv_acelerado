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
                    <?php if(isset($success)): ?>
                        <p class="auth-subtitle mb-5 text-center">Sucesso!</p>
                        <?= show_alert('Sua senha foi alterada com sucesso! Realize o login para acessar sua conta.', 'success') ?>
                        <p class="text-center">
                            <a href="<?= route_to('login.form') ?>" class="btn btn-info">Ir para o login</a>
                        </p>
                    <?php else: ?>
                        <p class="auth-subtitle mb-5 text-center">Crie uma nova senha para sua conta:</p>

                        <?= form_open('recover/do', ['novalidate' => true]) ?>
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <div class="form-group position-relative has-icon-left mb-4 <?= valid_field_bs($errors, 'password') ?>">
                                <input type="password" name="password" class="form-control form-control-xl " placeholder="Senha" value="<?= old('password', '') ?>">
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                <?= valid_field_bs($errors, 'password', false) ?>
                            </div>
                            <div class="form-group position-relative has-icon-left mb-4 <?= valid_field_bs($errors, 'repeat') ?>">
                                <input type="password" name="repeat" class="form-control form-control-xl " placeholder="Confirmação de senha" value="<?= old('repeat', '') ?>">
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                <?= valid_field_bs($errors, 'repeat', false) ?>
                            </div>
                            <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Salvar</button>
                        <?= form_close() ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
    <script src="<?= base_url('assets/js/bootstrap.js') ?>"></script>
</body>

</html>