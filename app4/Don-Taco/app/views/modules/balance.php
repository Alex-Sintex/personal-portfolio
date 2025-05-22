<?php require PATH_APP . '/views/header/header.php'; ?>
<div id="layoutSidenav">
    <?php require PATH_APP . '/views/navigation/navigation.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Balance</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="<?= PATH_URL; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Módulo 1</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        Control de balance
                        <br>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tabla de balance
                    </div>
                    <div class="card-body">
                        <table id="tableB" class="ui celled table hover" style="width:100%"></table>
                    </div>
                </div>
            </div>
        </main>
<?php require PATH_APP . '/views/footer/footer.php'; ?>