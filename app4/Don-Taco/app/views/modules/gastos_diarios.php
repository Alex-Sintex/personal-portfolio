<?php require PATH_APP . '/views/header/header.php'; ?>
<div id="layoutSidenav">
    <?php require PATH_APP . '/views/navigation/navigation.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Gastos diarios</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="<?= PATH_URL; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Módulo 3</li>
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
                        Tabla de gastos diarios
                    </div>
                    <div class="card-body">
<<<<<<< HEAD
                        <table id="tableGD" class="ui celled table hover" style="width:100%">
=======
                        <table id="tableGD" class="content-table" style="width:100%">
>>>>>>> 680170b (Implemented all modules: Product, Balance and Gastos (all working))
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Fecha</th>
                                    <th>Carne</th>
                                    <th>Queso</th>
                                    <th>Tortilla Maíz</th>
                                    <th>Tortilla Harina Grande</th>
                                    <th>Longaniza</th>
                                    <th>Pan</th>
<<<<<<< HEAD
=======
                                    <th>Vinagre</th>
>>>>>>> 680170b (Implemented all modules: Product, Balance and Gastos (all working))
                                    <th>Bodegón</th>
                                    <th>Adelanto Marcos</th>
                                    <th>Transporte Marcos</th>
                                    <th>Nómina</th>
                                    <th>Nómina Weekend</th>
                                    <th>Mundo Novi</th>
                                    <th>Color</th>
                                    <th>Otros</th>
                                    <th>Observaciones</th>
                                    <th>Total Gastos Diarios</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php require PATH_APP . '/views/footer/footer.php'; ?>