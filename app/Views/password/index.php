<?= $this->extend('layouts/page'); ?>

<?= $this->section('content'); ?>

<div class="breadcrumbs-inline pt-2 pb-1" id="breadcrumbs-wrapper">
    <div class="container">
        <div class="row">
            <div class="col s12 breadcrumbs-left">
                <h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down ">
                <span>Renovación de contraseña</span>
                </h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="<?= base_url(['dashboard']) ?>">Home</a></li>
                    <li class="breadcrumb-item active"><a href="#"> Renovar contraseña</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="col s12"  style="margin-bottom: 40px">
    <div class="contanier">
        <div class="section">
            <div class="container">
                <div class="card">
                    <div class="col s12">
                        <?= view('layouts/alerts') ?>
                    </div>
                    
                    <div class="card-content">
                        <h2 class="card-title">
                            Requisitos de la Nueva Contraseña
                        </h2>

                        <ul class="list">
                            <li class="">Validez de la contraseña: 90 dias.</li>
                            <li class="">Debe de tener un mínimo de 6 caracteres.</li>
                            <li class="">Debe introducir al menos 1 letra mayúscula.</li>
                            <li class="">Debe introducir al menos 1 letra minúscula.</li>
                            <li class="">Debe introducir al menos 1 carácter especial minúscula.</li>
                            <li class="">Incluir un cáracter especial que no sea una letra o un número</li>
                        </ul>

                        
                        <div class="row">
                            <form class="col s12" method="POST" action="<?= base_url(['password/updated']) ?>">
                                <div class="row">
                                    <div class="input-field col s12 m4">
                                        <input id="password_now" name="password_now" type="password" class="validate">
                                        <label for="password_now">Contraseña Actual</label>
                                        <small class="red-text text-darken-4">
                                        </small>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input id="password" name="password" type="password" class="validate">
                                        <label for="password">Nueva contraseña</label>
                                        <small class="red-text text-darken-4">
                                        </small>
                                    </div>
                                    <div class="input-field col s12 m4">
                                        <input id="password_confirm" name="password_confirm" type="password" class="validate">
                                        <label for="password_confirm">Confirmar contraseña</label>
                                        <small class="red-text text-darken-4">
                                        </small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">
                                            Renovar contraseña
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>