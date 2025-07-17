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
                    <form id="accountForm" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <!-- account-area profile -->
                            <div class="d-flex align-items-start py-3 border-bottom">
                                <?php
                                $user = $data['user'] ?? null;
                                $userId = $_SESSION['user_id'] ?? 'default';
                                $profileImg = (!empty($user->img))
                                    ? "/uploads/$userId/" . htmlspecialchars($user->img)
                                    : "https://images.pexels.com/photos/1037995/pexels-photo-1037995.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500";
                                ?>
                                <!-- Profile preview image -->
                                <img id="profilePreview"
                                    src="<?= ($user->img) ? "/uploads/users/{$user->id}/{$user->img}" : 'https://images.pexels.com/photos/1037995/pexels-photo-1037995.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500' ?>"
                                    alt="Foto de perfil"
                                    class="img"
                                    style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">

                                <!-- Hidden file input -->
                                <input type="file" id="profileImgInput" name="profile_img" accept="image/png, image/jpeg" hidden>

                                <!-- Button to trigger file input -->
                                <div class="pl-sm-4 pl-2" id="img-section">
                                    <b>Foto de perfil</b>
                                    <p>Archivos permitidos: .png, .jpg (menos de 1MB)</p>
                                    <button type="button" id="selectImgBtn" class="btn button border"><b>Seleccionar</b></button>
                                </div>
                            </div>

                            <!-- Form inputs -->
                            <div class="py-2">
                                <div class="row py-2">
                                    <div class="col-md-6">
                                        <label for="firstname" class="form-label">Nombre(s)</label>
                                        <input id="firstname" name="firstname" type="text" class="bg-light form-control"
                                            placeholder="Ingrese su nombre"
                                            value="<?= htmlspecialchars(ucwords(strtolower($user->fname ?? ''))) ?>">
                                    </div>
                                    <div class="col-md-6 pt-md-0 pt-3">
                                        <label for="lastname" class="form-label">Apellido(s)</label>
                                        <input id="lastname" name="lastname" type="text" class="bg-light form-control"
                                            placeholder="Ingrese sus apellidos"
                                            value="<?= htmlspecialchars(ucwords(strtolower($user->lname ?? ''))) ?>">
                                    </div>
                                </div>

                                <div class="row py-2">
                                    <?php $isVerified = (int)($user->is_email_verified ?? 0); ?>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Correo electrónico</label>
                                        <input id="email" name="email" type="text" class="bg-light form-control"
                                            placeholder="Ingresa un correo"
                                            value="<?= htmlspecialchars(strtolower($user->email ?? '')) ?>">

                                        <?php if (!$isVerified): ?>
                                            <div class="alert alert-warning mt-3">
                                                Tu correo no está verificado. Por favor revisa tu bandeja de entrada.<br>
                                                <a href="javascript:void(0)">Reenviar confirmación</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-6 pt-md-0 pt-3">
                                        <label for="phone" class="form-label">Número</label>
                                        <input id="phone" name="phone" type="tel" class="bg-light form-control"
                                            placeholder="Número de teléfono"
                                            value="<?= htmlspecialchars($user->phone ?? '') ?>">
                                    </div>
                                </div>

                                <div class="row py-2">
                                    <div class="col-md-6">
                                        <label for="username" class="form-label">Nombre de usuario</label>
                                        <input id="username" name="username" type="text" class="bg-light form-control"
                                            placeholder="Ingresa un nuevo usuario"
                                            value="<?= htmlspecialchars($user->username ?? '') ?>" maxlength="20">
                                    </div>

                                    <div class="col-md-6 pt-md-0 pt-3">
                                        <label for="currentPass" class="form-label">Contraseña actual</label>
                                        <input id="currentPass" name="currentPass" type="password" class="bg-light form-control"
                                            placeholder="Ingresa contraseña actual">
                                    </div>
                                </div>

                                <div class="row py-2">
                                    <div class="col-md-6">
                                        <label for="newPass" class="form-label">Nueva contraseña</label>
                                        <input id="newPass" name="newPass" type="password" class="bg-light form-control"
                                            placeholder="Ingresa la nueva contraseña">
                                    </div>

                                    <div class="col-md-6 pt-md-0 pt-3">
                                        <label for="confirmPass" class="form-label">Confirmación nueva contraseña</label>
                                        <input id="confirmPass" name="confirmPass" type="password" class="bg-light form-control"
                                            placeholder="Repite la nueva contraseña">
                                    </div>
                                </div>

                                <div class="py-3 pb-4 border-bottom">
                                    <span data-bs-toggle="tooltip" title="Contraseña necesaria">
                                        <button class="btn btn-primary" id="saveAccountBtn" disabled>Guardar</button>
                                    </span>
                                </div>

                                <div class="d-sm-flex align-items-center pt-3" id="deactivate">
                                    <div>
                                        <b>Eliminar cuenta</b>
                                        <p>Se eliminará la información de la cuenta, esta acción no se puede deshacer</p>
                                    </div>
                                    <div class="ml-auto">
                                        <!-- Botón para abrir el modal -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">¿Estás seguro?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Esta acción eliminará tu cuenta permanentemente.</p>

                        <div class="form-group">
                            <label for="confirmPassword">Confirma tu contraseña:</label>
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Contraseña actual" required>
                        </div>

                        <div id="response" style="overflow: hidden; transition: height 0.3s ease;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Sí, eliminar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php require PATH_APP . '/views/footer/footer.php'; ?>