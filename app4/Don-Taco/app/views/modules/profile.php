<?php require PATH_APP . '/views/header/header.php'; ?>
<div id="layoutSidenav">
    <?php require PATH_APP . '/views/navigation/navigation.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">PERFIL DE USUARIO</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="<?= PATH_URL; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Perfil</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        AJUSTES
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fa fa-user"></i>
                        CONFIGURACIÓN DE LA CUENTA
                    </div>
                    <div class="card-body">
                        <!-- account-area -->
                        <div class="d-flex align-items-start py-3 border-bottom">
                            <img src="https://images.pexels.com/photos/1037995/pexels-photo-1037995.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
                                class="img" alt="">
                            <div class="pl-sm-4 pl-2" id="img-section">
                                <b>Foto de perfil</b>
                                <p>Archivos permitidos: .png. Menos de un 1MB</p>
                                <button class="btn button border"><b>Seleccionar</b></button>
                            </div>
                        </div>
                        <div class="py-2">
                            <div class="row py-2">
                                <div class="col-md-6">
                                    <label for="firstname" class="form-label">Nombre(s)</label>
                                    <input type="text" class="bg-light form-control" placeholder="Steve">
                                </div>
                                <div class="col-md-6 pt-md-0 pt-3">
                                    <label for="lastname" class="form-label">Apellido(s)</label>
                                    <input type="text" class="bg-light form-control" placeholder="Jobs">
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input type="text" class="bg-light form-control" placeholder="steve@email.com">
                                    <div class="alert alert-warning mt-3">
                                        Your email is not confirmed. Please check your inbox.<br>
                                        <a href="javascript:void(0)">Resend confirmation</a>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-md-0 pt-3">
                                    <label for="phone" class="form-label">Número</label>
                                    <input type="tel" class="bg-light form-control" placeholder="+1 213-548-6015">
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-md-6">
                                    <label for="currentPas" class="form-label">Contraseña actual</label>
                                    <input type="password" class="bg-light form-control" placeholder="Ingresa contraseña actual">
                                </div>
                                <div class="col-md-6 pt-md-0 pt-3">
                                    <label for="new_passwd" class="form-label">Nueva contraseña</label>
                                    <input type="password" class="bg-light form-control" placeholder="Ingresa la nueva contraseña">
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-md-6">
                                    <label for="confirm_passwd" class="form-label">Confirmación nueva contraseña</label>
                                    <input type="password" class="bg-light form-control" placeholder="Repite la nueva contraseña">
                                </div>
                            </div>
                            <div class="py-3 pb-4 border-bottom">
                                <button class="btn btn-primary mr-3">Guardar</button>
                            </div>
                            <div class="d-sm-flex align-items-center pt-3" id="deactivate">
                                <div>
                                    <b>Eliminar cuenta</b>
                                    <p>Se eliminará la información de la cuenta, esta acción no se puede deshacer</p>
                                </div>
                                <div class="ml-auto">
                                    <button class="btn danger">Eliminar</button>
                                </div>
                            </div>
                        </div>
                        <!-- account-area -->
                    </div>
                </div>
            </div>
        </main>
        <?php require PATH_APP . '/views/footer/footer.php'; ?>