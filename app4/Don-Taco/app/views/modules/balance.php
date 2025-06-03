<?php require PATH_APP . '/views/header/header.php'; ?>
<div id="layoutSidenav">
    <?php require PATH_APP . '/views/navigation/navigation.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <!-- CALCULATIONS TABLE -->
            <div class="container-fluid px-4">
                <h1 class="mt-4">Balance</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="<?= PATH_URL; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Módulo 2</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        CÁLCULOS AUTOMÁTICOS
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        TABLA DE CÁLCULOS
                    </div>
                    <div class="card-body">
                        <table id="calTableB" class="content-table" style="width:100%"></table>
                    </div>
                </div>

                <!-- INPUT TABLE -->
                <div class="card mb-4">
                    <div class="card-body">
                        CONTROL DE REGISTROS
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        TABLA DE REGISTROS
                    </div>
                    <div class="card-body">
                        <table id="inTableB" class="content-table" style="width:100%"></table>
                    </div>
                </div>
            </div>
        </main>
        <?php require PATH_APP . '/views/footer/footer.php'; ?>