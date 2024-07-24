<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
          content="<?= isset(configInfo()['meta_description']) ? configInfo()['meta_description'] : 'Name' ?>">
    <meta name="keywords"
          content="<?= isset(configInfo()['meta_keywords']) ? configInfo()['meta_keywords'] : 'Name' ?>">
    <meta name="author" content="IPlanet Colombia S.A.S">
    <title><?= isset(configInfo()['name_app']) ? configInfo()['name_app'] : 'Name' ?></title>
    <link rel="apple-touch-icon" href="<?= !isset(configInfo()['favicon']) ||  empty(configInfo()['favicon']) ? base_url().'/assets/img/logo.png' :  base_url().'/assets/upload/images/'.configInfo()['favicon']   ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= !isset(configInfo()['favicon']) ||  empty(configInfo()['favicon']) ? base_url().'/assets/img/logo.png' :  base_url().'/assets/img/'.configInfo()['favicon']   ?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/vendors.min.css">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/login.css">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/custom.min.css">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- END: Custom CSS-->
    <style>
        .login-bg
        {
            background-image: url(  <?= !isset(configInfo()['background_image']) ||  empty(configInfo()['background_image'])  ? 'https://image.freepik.com/foto-gratis/imagen-paisaje-urbano-parque-benchakitti-al-amanecer-bangkok-tailandia_29505-853.jpg' : base_url().'/assets/img/'.configInfo()['background_image'] ?>);
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 1-column login-bg   blank-page blank-page"
      data-open="click" data-menu="vertical-dark-menu" data-col="1-column">
<div class="row">
    <div class="col s12">
        <div class="container">
            <div id="login-page" class="row">
                <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
                    <form class="login-form" action="<?= base_url(['validation']) ?>" method="POST" onsubmit="onSubmit(event)">
                        <div class="row">
                            <div class="input-field col s12">
                                <h5 class="ml-4">Inicio de Sesion</h5>
                            </div>
                        </div>
                        <div class="row margin">
                            <?php if (session('errors')): ?>
                                <div class="col s12">
                                    <div class="card-alert card red">
                                        <div class="card-content white-text">
                                            <p><?= session('errors') ?></p>
                                        </div>
                                        <button type="button" class="close white-text" data-dismiss="alert"
                                                aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="input-field col s12">
                                <i class="material-icons prefix pt-2">person_outline</i>
                                <input id="username" type="text" name="username">
                                <label for="username" class="center-align">Nombre de Usuario</label>
                            </div>
                        </div>
                        <div class="row margin">
                            <div class="input-field col s12">
                                <i class="material-icons prefix pt-2">lock_outline</i>
                                <input id="password" type="password" name="password">
                                <label for="password">Contraseña</label>
                                <small class=""></small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <div class="g-recaptcha"
                                    data-sitekey="6LcKAxQqAAAAAG8jmv_L3-gSEuDvYOrMgbQAx7yF"
                                    data-callback="validateReCaptcha"
                                    data-expired-callback="onRecaptchaExpired"
                                ></div>
                            </div>
                        </div>
                        <!--<div class="row">
                            <div class="col s12 m12 l12 ml-2 mt-1">
                                <p>
                                    <label>
                                        <input type="checkbox"/>
                                        <span>Recuerdame</span>
                                    </label>
                                </p>
                            </div>
                        </div>-->
                        <div class="row">
                            <div class="input-field col s12">
                                <button class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">
                                    Inicio de Sesion
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <?php if(isset(configInfo()['register']) && configInfo()['register'] == 'active' ): ?>
                                <div class="input-field col s6 m6 l6">
                                    <p class="margin medium-small"><a href="<?= base_url(['register']) ?>">Registrate</a></p>
                                </div>
                            <?php endif ?>
                            <div class="input-field col s6 m6 l6">
                                <p class="margin right-align medium-small"><a href="<?= base_url(['reset_password']) ?>">¿Olvide
                                        mi contraseña?</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>


<script>localStorage.setItem('url', '<?= base_url() ?>')</script>

<script src="<?= base_url() ?>/assets/js/vendors.min.js"></script>
<script src="<?= base_url() ?>/assets/js/plugins.min.js"></script>
<script src="<?= base_url() ?>/assets/js/search.min.js"></script>
<script src="<?= base_url() ?>/assets/js/custom-script.min.js"></script>
<script src="<?= base_url() ?>/assets/js/ui-alerts.js"></script>
<script src="<?= base_url(["assets/js/functions/functions.js"]) ?>"></script>
<script src="<?= base_url(["assets/js/auth/login.js"]) ?>"></script>
</body>

</html>