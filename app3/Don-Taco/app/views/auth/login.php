<?php require PATH_APP . '/views/header/header.php'; ?>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4 title">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form id="loginForm" method="POST" novalidate>
                                        <div class="form-floating mb-3">
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="login" id="login" placeholder="Usuario o correo" />
                                            </div>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <div class="form-group">
                                                <input class="form-control" type="password" name="password" id="password" placeholder="Contraseña" />
                                            </div>
                                            <div class="password-icon">
                                                <i data-feather="eye"></i>
                                                <i data-feather="eye-off"></i>
                                            </div>
                                        </div>

                                        <div id="generalError" class="text-danger small mb-3"></div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" class="button btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <a href="#" id="forgotPasswordLink" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">¿Olvidaste la contraseña?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <!-- Password Reset Modal -->
            <div class="modal fade" id="resetPasswordModal" role="dialog" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="resetPasswordModalLabel">Recuperar contraseña</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Step 1: Request code -->
                            <form id="resetRequestForm">
                                <div class="mb-3">
                                    <label for="reset-email" class="form-label">Correo o usuario</label>
                                    <input type="text" class="form-control" id="reset-email" name="email" required />
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Enviar código</button>
                            </form>

                            <!-- Step 2: Verify code & change password -->
                            <form id="codeVerificationForm" class="d-none mt-3">
                                <input type="hidden" name="email" id="hiddenEmail" />
                                <div class="mb-3">
                                    <label for="reset-code" class="form-label">Código</label>
                                    <div id="code-input-container" style="display:flex; gap:10px; justify-content:center;">

                                        <input type="text" inputmode="numeric" maxlength="1" pattern="\d" class="code-circle" />
                                        <input type="text" inputmode="numeric" maxlength="1" pattern="\d" class="code-circle" />
                                        <input type="text" inputmode="numeric" maxlength="1" pattern="\d" class="code-circle" />
                                        <input type="text" inputmode="numeric" maxlength="1" pattern="\d" class="code-circle" />
                                        <input type="text" inputmode="numeric" maxlength="1" pattern="\d" class="code-circle" />
                                        <input type="text" inputmode="numeric" maxlength="1" pattern="\d" class="code-circle" />

                                    </div>

                                    <!-- Hidden input to hold the combined code for form submission -->
                                    <input type="hidden" name="code" id="reset-code" required>
                                </div>
                                <div class="mb-3">
                                    <label for="reset-password" class="form-label">Nueva contraseña</label>
                                    <input type="password" class="form-control" id="reset-password" name="password" required />
                                </div>
                                <div class="text-center mt-2">
                                    <button type="submit" class="btn btn-success w-100">Cambiar contraseña</button>
                                </div>
                                <div class="text-center mt-2">
                                    <button type="button" class="btn btn-link" id="resendCode">Reenviar código</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php require PATH_APP . '/views/footer/footer.php'; ?>
        </div>
    </div>