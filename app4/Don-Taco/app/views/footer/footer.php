<!-- FOOTER SECTION -->
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

<!-- SCRIPT LOADER -->
<?php
<<<<<<< HEAD
=======
// Load JQuery Library
$loadJQueryLibrary = $data['loadJQueryLibrary'] ?? false;
// Load JS for Auth page
$loadJSLogin = $data['loadJSLogin'] ?? false;
>>>>>>> 680170b (Implemented all modules: Product, Balance and Gastos (all working))
// Load DataTable Simple scripts
$loadDataTablesSimple = $data['loadDataTablesSimple'] ?? false;
$loadDataTables = $data['loadDataTables'] ?? false;

// Load DataTables for each main page
$loadDataTablesProduct = $data['loadDataTablesProduct'] ?? false;
$loadDataTablesBalance = $data['loadDataTablesBalance'] ?? false;
$loadDataTablesGD = $data['loadDataTablesGD'] ?? false;

// Load assets for Toasty
$loadToasty = $data['loadToasty'] ?? false;
// Load assets for Charts
$loadCharts = $data['loadCharts'] ?? false;
?>

<!-- Core JS -->
<script src="<?= PATH_URL ?>js/Main/bootstrap.bundle.min.js"></script>
<script src="<?= PATH_URL ?>js/Main/scripts.js"></script>
<script src="<?= PATH_URL ?>js/Main/all.js"></script>
<<<<<<< HEAD
=======

<!-- Load JQuery Library -->
<?php if ($loadJQueryLibrary): ?>
    <script src="<?= PATH_URL ?>js/DataTable/jquery-3.7.1.min.js"></script>
<?php endif; ?>

<?php if (!empty($loadJSLogin)): ?>
    <script src="<?= PATH_URL ?>js/auth/login.js"></script>
<?php endif; ?>
>>>>>>> 680170b (Implemented all modules: Product, Balance and Gastos (all working))

<?php if ($loadDataTablesSimple): ?>
    <!-- DataTables Simple -->
    <script src="<?= PATH_URL ?>js/DataTable-Simple/simple-datatables.min.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable-Simple/datatables-simple.js"></script>
<?php endif; ?>

<?php if ($loadDataTables): ?>

    <!-- DataTables -->
    <script src="<?= PATH_URL ?>js/DataTable/jquery.dataTables.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.buttons.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.select.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.select2.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.responsive.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/jquery.datetimepicker.full.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.altEditor.js"></script>

    <?php if (!empty($loadDataTablesProduct)): ?>
        <script src="<?= PATH_URL ?>js/DataTable/product.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTablesBalance)): ?>
        <script src="<?= PATH_URL ?>js/DataTable/balance.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTablesGD)): ?>
        <script src="<?= PATH_URL ?>js/DataTable/gastos_diarios.js"></script>
    <?php endif; ?>
<?php endif; ?>

<?php if ($loadToasty): ?>
    <!-- Toasty -->
    <script src="<?= PATH_URL ?>Toasty/js/toasty.js"></script>

<?php endif; ?>

<?php if ($loadCharts): ?>
    <!-- Chart -->
    <script src="<?= PATH_URL ?>js/Chart/Chart.min.js"></script>
    <script src="<?= PATH_URL ?>js/Chart/chart-area-demo.js"></script>
    <script src="<?= PATH_URL ?>js/Chart/chart-bar-demo.js"></script>
<?php endif; ?>
<!-- SCRIPTS -->

</body>

</html>