<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php echo WEBSITE; ?></title>
    <link rel="icon" href="<?= PATH_URL; ?>img/favicon/favicon.ico" type="image/x-icon">
    <!-- Optional: for Apple devices -->
    <link rel="apple-touch-icon" href="<?= PATH_URL; ?>img/favicon/apple-touch-icon.png">
    <link href="<?= PATH_URL; ?>css/Main/style.css" rel="stylesheet" />
    <link href="<?= PATH_URL; ?>css/Main/error.css" rel="stylesheet" />
</head>

<body class="bg-primary">
    <div id="layoutError">
        <div id="layoutError_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="text-center mt-4">
                                <header>
                                    <div class="logo">
                                        <img id="image" src="<?= PATH_URL; ?>img/favicon/apple-touch-icon.png" class="class=" mb-4 img-error"" alt="Logo" />
                                    </div>
                                </header>
                                <div class="content">
                                    <h1>404</h1>
                                    <h2>Página no encontrada</h2>
                                    <a class="back" href="<?= PATH_URL; ?>">
                                        Regresar a inicio
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <div id="layoutError_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">
                            <script>
                                document.querySelector('.text-muted').innerHTML = `Copyright &copy; Don-Taco ${new Date().getFullYear()}`
                            </script>
                        </div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?php echo PATH_URL; ?>js/Main/jquery-3.7.1.min.js"></script>
    <script src="<?php echo PATH_URL; ?>js/Main/all.js"></script>
    <script src="<?php echo PATH_URL; ?>js/Main/bootstrap.bundle.min.js"></script>
    <script src="<?php echo PATH_URL; ?>js/Main/scripts.js"></script>
    <script src="<?php echo PATH_URL; ?>js/error/error.js"></script>
</body>

</html>