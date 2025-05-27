<?php require PATH_APP . '/views/header/header.php'; ?>
<div id="layoutSidenav">
    <?php require PATH_APP . '/views/navigation/navigation.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Balance</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="<?= PATH_URL; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Módulo 2</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <center>Añadir nuevo registro</center>
                    </div>
                    <button class="btn btn-primary" id="addbutton" title="Add"><span class="fa fa-plus-square"></span></button>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tabla de balance
                    </div>
                    <div class="card-body">
<<<<<<< HEAD
                        <table class="dataTable responsive-table" id="tableB">
=======
                        <table id="tableB" class="content-table" style="width:100%">
>>>>>>> 680170b (Implemented all modules: Product, Balance and Gastos (all working))
                            <caption>Balance</caption>
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>FECHA</th>
                                    <th>GASTOS FIJOS DIARIOS</th>
                                    <th>GASTOS DIARIOS</th>
                                    <th>TOTAL EGRESOS</th>
                                    <th>VENTA EFECTIVO</th>
                                    <th>VENTA TRANSFERENCIA</th>
                                    <th>VENTA NETA TARJETA</th>
                                    <th>VENTA TARJETA - %</th>
                                    <th>TOTAL INGRESOS</th>
                                    <th>UTILIDAD PISO</th>
                                    <th>UTILIDAD DISPONIBLE</th>
                                    <th>INGRESO PLATAFORMAS</th>
                                    <th>NOMBRE</th>
                                    <th>ACCIÓN</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php require PATH_APP . '/views/footer/footer.php'; ?>