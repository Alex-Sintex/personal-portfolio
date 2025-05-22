<?php
$loadDataTablesSimple = $data['loadDataTablesSimple'] ?? false;
$loadDataTables = $data['loadDataTables'] ?? false;
$loadDataTablesBalance = $data['loadDataTablesBalance'] ?? false;
$loadDataTablesGD = $data['loadDataTablesGD'] ?? false;
$loadToasty = $data['loadToasty'] ?? false;
$loadCharts = $data['loadCharts'] ?? false;
?>

<!-- Core JS -->
<script src="<?= PATH_URL ?>js/bootstrap.bundle.min.js"></script>
<script src="<?= PATH_URL ?>js/scripts.js"></script>
<script src="<?= PATH_URL ?>js/all.js"></script>

<?php if ($loadDataTablesSimple): ?>
    <!-- DataTables Simple -->
    <script src="<?= PATH_URL ?>js/DataTable-Simple/simple-datatables.min.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable-Simple/datatables-simple.js"></script>
<?php endif; ?>

<?php if ($loadDataTables): ?>
    <!-- DataTables -->
    <script src="<?= PATH_URL ?>js/DataTable/jquery-3.7.1.min.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/jquery.dataTables.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.buttons.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.select.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.responsive.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/jquery.datetimepicker.full.js"></script>
    <script src="<?= PATH_URL ?>js/DataTable/dataTables.altEditor.js"></script>

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

</body>

</html>