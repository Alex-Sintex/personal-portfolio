<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Author: Kevin Alexis">
    <title>
        <?php echo LOGIN; ?>
    </title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="<?= BASE_URL; ?>img/favicon/favicon.ico" rel="icon">
    <link href="<?= BASE_URL; ?>img/favicon/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Bootstrap CSS Files -->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>css/bootstrap.min.css">
    <!-- Template Main CSS File -->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>bower_components/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>css/DropdownReg.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>css/custom_dropdown.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>css/sweetalert2.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>css/responsive-login.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>css/modal.css">
    <!-- ======================================================= -->
</head>

<body>
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <!-- container div -->
                <div class="container-log">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center" style="width: 100%;">
                            <div class="d-flex justify-content-center py-4">
                                <!-- Upper button section to select
                              the login, signup or student tab -->
                                <div class="slider"></div>
                                <div class="btn-log">
                                    <button class="login">Login</button>
                                    <button class="student">Student</button>
                                </div>
                            </div>
                            <!-- Form section for login -->
                            <div class="form-section">
                                <!-- Login form -->
                                <div class="login-box">
                                    <!-- End Logo -->
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="pt-4 pb-2">
                                                <h5 class="card-title text-center pb-0 fs-4">Login to your account
                                                </h5>
                                                <p class="text-center small">Enter your username & password to login
                                                </p>
                                            </div>
                                            <form id="loginForm" class="row g-3" method="POST">
                                                <div class="col-12">
                                                    <label for="username" class="form-label">Username</label>
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text" id="inputGroupPrepend">
                                                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                                                        </span>
                                                        <input type="text" name="username" class="form-control" id="username" placeholder="Enter your username">
                                                        <div class="invalid-feedback">Please enter your username
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label for="password" class="form-label">Password</label>
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text" id="inputGroupPrepend">
                                                            <i class="fa fa-key" aria-hidden="true"></i>
                                                        </span>
                                                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password">
                                                        <span class="input-group-text" id="inputGroupPrepend">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                        <div class="invalid-feedback">Please enter your password
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <label for="remember" class="form-check-label">Remember
                                                            me</label>
                                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" value="off">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button id="spin" class="btn btn-primary w-100" type="submit">
                                                        <i class="spinner"></i>
                                                        <span class="state">Login</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-12 log">
                                        <p class="small mb-0"><a href="#" data-toggle="modal" data-target="#forgotPasswd">Forgot password?</a></p>
                                        <p class="small mb-0"><a href="#stud">Are you student?</a></p>
                                    </div>
                                </div>
                                <!-- End login form -->
                                <!-- Student form -->
                                <div class="student-box">
                                    <!-- End Logo -->
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="pt-4 pb-2">
                                                <h5 class="card-title text-center pb-0 fs-4">Student account
                                                </h5>
                                                <p class="text-center small">Enter your username & password to login
                                                </p>
                                            </div>
                                            <form id="studForm" class="row g-3" method="POST">
                                                <div class="col-12">
                                                    <label for="usernameStud" class="form-label">Username</label>
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text" id="inputGroupPrepend">
                                                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                                                        </span>
                                                        <input type="text" name="usernameStud" class="form-control" id="usernameStud" placeholder="Enter your No. Control">
                                                        <div class="invalid-feedback">Please enter your username
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label for="passwordStud" class="form-label">Password</label>
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text" id="inputGroupPrepend">
                                                            <i class="fa fa-key" aria-hidden="true"></i>
                                                        </span>
                                                        <input type="password" name="passwordStud" class="form-control" id="passwordStud" placeholder="Enter your password">
                                                        <span class="input-group-text" id="inputGroupPrepend">
                                                            <i id="stud_showP" class="fas fa-eye"></i>
                                                        </span>
                                                        <div class="invalid-feedback">Please enter your password
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button id="spinS" class="btn btn-primary w-100" type="submit">
                                                        <i class="spinnerS"></i>
                                                        <span class="stateS">Login</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-12 log">
                                        <p class="small mb-0">You're not student?
                                            <a href="#log2">Login</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- End student form -->
                            <div class="credits">
                                Designed by <a href="#"><b>Kevin Alexis</b></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <!-- Modal -->
    <div class="modal fade" id="forgotPasswd">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Password recovery</h4>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                        <h2 class="text-center">Forgot Password?</h2>
                        <p>You can reset your password here. <br><b>(Only for personal of university as a professors)</b></p>
                        <div class="panel-body">
                            <form id="forgotPasswd" autocomplete="off" class="form" method="POST">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" style="width: -webkit-fit-content;"><i class="fa fa-envelope"></i></span>
                                        <input class="form-control" type="email" id="recovery_email" name="recovery_email" placeholder="Enter your email" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End #main -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="fa fa-arrow-up"></i>
    </a>
    <!-- Vendor JS Files -->
    <script src="<?= BASE_URL; ?>js/tinymce.min.js"></script>
    <!-- Template Main JS File -->
    <script type="text/javascript" src="<?= BASE_URL; ?>js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>bower_components/bootstrap/dist/js/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/main.js"></script>
    <!-- AJAX -->
    <script type="text/javascript" src="<?= BASE_URL; ?>ajax/login.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>ajax/forgotPasswd.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>ajax/stud_log.js"></script>
    <!-- --- -->
    <script type="text/javascript" src="<?= BASE_URL; ?>js/responsive-login.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/sweetalert2.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/dropdown-menu.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/custom_dropdown.js"></script>
    <script type="text/javascript" src="<?= BASE_URL; ?>js/toggle_show_passwd.js"></script>

</body>

</html>