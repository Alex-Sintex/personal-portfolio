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
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
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
                                            <a class="small" href="forgotPassword">Forgot Password?</a>
                                            <button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="register">Need an account? Sign up!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <?php require PATH_APP . '/views/footer/footer.php'; ?>
        </div>
    </div>