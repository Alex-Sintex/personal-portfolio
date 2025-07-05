<!-- FOOTER SECTION -->
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">
                <script>
                    document.querySelector('.text-muted').innerHTML = `Copyright &copy; Don-Taco ${new Date().getFullYear()}`
                </script>
            </div>
            <div class="footer-terms">
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>
</div>
</div>

<?php
/* 
SCRIPTS LOADER 
*/
// Load JQuery Library
$loadJQueryLibrary = $data['loadJQueryLibrary'] ?? false;
// Load Script for dropdown sidebar
$loadScriptSideBar = $data['loadScriptSideBar'] ?? false;
// Load JS for Auth page
$loadJSLogin = $data['loadJSLogin'] ?? false;
// Load DataTable Simple scripts
$loadDataTablesSimple = $data['loadDataTablesSimple'] ?? false;
$loadDataTables = $data['loadDataTables'] ?? false;

// Load DataTables for each main page
$loadDataTableProduct = $data['loadDataTableProduct'] ?? false;
$loadDataTableBalance = $data['loadDataTableBalance'] ?? false;
$loadDataTableGFD = $data['loadDataTableGFD'] ?? false;
$loadDataTableGD = $data['loadDataTableGD'] ?? false;
$loadDataTableF = $data['loadDataTableF'] ?? false;
$loadDataTableSupp = $data['loadDataTableSupp'] ?? false;
$loadDataTableUnitoms = $data['loadDataTableUnitoms'] ?? false;

// Load assets for Toasty
$loadToasty = $data['loadToasty'] ?? false;
// Load assets for Charts
$loadCharts = $data['loadCharts'] ?? false;

// Load assets for Currency Format
$loadJShelpers = $data['loadJShelpers'] ?? false;
?>

<!-- Core JS -->
<script src="<?= PATH_URL ?>js/main/bootstrap.bundle.min.js"></script>
<?php if ($loadScriptSideBar): ?>
    <!-- Load Script for dropdown sidebar -->
    <script src="<?= PATH_URL ?>js/main/scripts.js"></script>
<?php endif; ?>
<script src="<?= PATH_URL ?>js/main/all.js"></script>

<!-- Load JQuery Library -->
<?php if ($loadJQueryLibrary): ?>
    <script src="<?= PATH_URL ?>js/main/jquery-3.7.1.min.js"></script>
<?php endif; ?>

<?php if (!empty($loadJSLogin)): ?>
    <script src="<?= PATH_URL ?>js/auth/login.js"></script>
<?php endif; ?>

<?php if ($loadDataTablesSimple): ?>
    <!-- DataTables Simple -->
    <script src="<?= PATH_URL ?>js/DataTable-Simple/simple-datatables.min.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable-Simple/datatables-simple.js"></script>
<?php endif; ?>

<?php if ($loadDataTables): ?>

    <!-- DataTables -->
    <script src="<?= PATH_URL ?>js/DataTable/jquery.dataTables.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.buttons.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/jszip.min.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/buttons.html5.min.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.select.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.select2.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.responsive.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/jquery.datetimepicker.full.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.altEditor.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/buttons.print.min.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/buttons.colVis.min.js"></script>

    <?php if (!empty($loadDataTableProduct)): ?>
        <script type="module" src="<?= PATH_URL ?>js/product/product.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTableBalance)): ?>
        <script type="module" src="<?= PATH_URL ?>js/balance/balance.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTableGFD)): ?>
        <script type="module" src="<?= PATH_URL ?>js/expense/fix_exp.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTableGD)): ?>
        <script type="module" src="<?= PATH_URL ?>js/expense/daily_expenses.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTableF)): ?>
        <script type="module" src="<?= PATH_URL ?>js/funds/funds.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTableSupp)): ?>
        <script src="<?= PATH_URL ?>js/supplier/supplier.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTableUnitoms)): ?>
        <script src="<?= PATH_URL ?>js/measures/unit_m.js"></script>
    <?php endif; ?>
<?php endif; ?>

<?php if ($loadToasty): ?>
    <!-- Toasty -->
    <script src="<?= PATH_URL ?>Toasty/js/toasty.js"></script>

<?php endif; ?>

<?php if ($loadCharts): ?>
    <!-- Chart -->
    <script src="<?= PATH_URL ?>js/Charts/Chart.min.js"></script>
    <script type="module" src="<?= PATH_URL ?>js/Charts/incomesChart.js"></script>
    <script type="module" src="<?= PATH_URL ?>js/Charts/outcomesChart.js"></script>
<?php endif; ?>
<!-- SCRIPTS -->

</body>

</html>