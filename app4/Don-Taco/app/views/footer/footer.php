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
$loadDataTableUsers = $data['loadDataTableUsers'] ?? false;

// Load assets for Toasty
$loadToasty = $data['loadToasty'] ?? false;
// Load assets for Charts
$loadCharts = $data['loadCharts'] ?? false;

// Load assets for Currency Format
$loadJShelpers = $data['loadJShelpers'] ?? false;

// Load assets for Chat module
$loadChatScripts = $data['loadChatScripts'] ?? false;

// Load asset for Login show hide password
$loadShowHidePasswd = $data['loadShowHidePasswd'] ?? false;

// Load asset for account/settings module
$loadAccountScripts = $data['loadAccountScripts'] ?? false;

// Load asset for Role helper
$loadJSRoleHelper = $data['loadJSRoleHelper'] ?? false;
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

<?php if (!empty($loadJSRoleHelper)): ?>
    <script>
        window.USER_ROLE = "<?= userRole() ?>";
    </script>
    <script src="<?= PATH_URL ?>js/ajax/helper/role_helper.js"></script>
<?php endif; ?>

<?php if (!empty($loadShowHidePasswd)): ?>
    <script src="<?= PATH_URL ?>js/auth/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
    <script src="<?= PATH_URL ?>js/auth/pass-show-hide.js"></script>
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
        <script type="module" src="<?= PATH_URL ?>js/ajax/product/product.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTableBalance)): ?>
        <script type="module" src="<?= PATH_URL ?>js/ajax/balance/balance.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTableGFD)): ?>
        <script type="module" src="<?= PATH_URL ?>js/ajax/expense/fix_exp.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTableGD)): ?>
        <script type="module" src="<?= PATH_URL ?>js/ajax/expense/daily_expenses.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTableF)): ?>
        <script type="module" src="<?= PATH_URL ?>js/ajax/funds/funds.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTableSupp)): ?>
        <script src="<?= PATH_URL ?>js/ajax/supplier/supplier.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTableUnitoms)): ?>
        <script src="<?= PATH_URL ?>js/ajax/measures/unit_m.js"></script>
    <?php endif; ?>

    <?php if (!empty($loadDataTableUsers)): ?>
        <script type="module" src="<?= PATH_URL ?>js/ajax/users/user.js"></script>
    <?php endif; ?>
<?php endif; ?>

<?php if ($loadToasty): ?>
    <!-- Toasty -->
    <script src="<?= PATH_URL ?>Toasty/js/toasty.js"></script>
<?php endif; ?>

<!-- Check user session JS -->
<?php if (isset($_SESSION['user_id'])): ?>
    <script>
        window.APP = {
            BASE_URL: "<?= PATH_URL ?>"
        };
    </script>
    <script src="<?= PATH_URL ?>js/auth/sessionCheckInterval.js"></script>
<?php endif; ?>

<?php if (!empty($_GET['timeout']) && $_GET['timeout'] == 1): ?>
    <script src="<?= PATH_URL ?>js/auth/message_session.js"></script>
<?php endif; ?>

<?php if (!empty($loadJSLogin)): ?>
    <script src="<?= PATH_URL ?>js/auth/login.js"></script>
    <script src="<?= PATH_URL ?>js/auth/reset.js"></script>
<?php endif; ?>

<?php if ($loadCharts): ?>
    <!-- Chart -->
    <script src="<?= PATH_URL ?>js/charts/chart.js"></script>
    <script type="module" src="<?= PATH_URL ?>js/ajax/income/chart.js"></script>
    <script type="module" src="<?= PATH_URL ?>js/ajax/outcome/chart.js"></script>
<?php endif; ?>

<?php if ($loadChatScripts): ?>
    <script src="<?= PATH_URL ?>js/chat/chat.js"></script>
    <!-- Begin emoji-picker JavaScript -->
    <script src="<?= PATH_URL ?>js/chat/emoji-picker.js"></script>
    <!-- End emoji-picker JavaScript -->
    <script src="<?= PATH_URL ?>js/chat/fetchUsers.js"></script>
    <!-- Load background chat changer -->
    <script src="<?= PATH_URL ?>js/chat/chat_bg.js"></script>
<?php endif; ?>

<?php if ($loadAccountScripts): ?>
    <script src="<?= PATH_URL ?>js/ajax/profile/profile.js"></script>
    <script src="<?= PATH_URL ?>js/ajax/profile/delete.js"></script>
    <script src="<?= PATH_URL ?>js/ajax/profile/email_verification.js"></script>
    <?php if (isset($_GET['verified'])): ?>
        <script>
            const status = '<?= htmlspecialchars($_GET['verified']) ?>';

            document.addEventListener('DOMContentLoaded', () => {
                if (status === 'success') {
                    toast.success('Correo verificado correctamente.');
                } else if (status === 'expired') {
                    toast.error('El enlace ha expirado o es inválido.');
                } else if (status === 'error') {
                    toast.error('Ocurrió un error en la verificación.');
                }

                // Remove the query param from URL without reloading the page
                const url = new URL(window.location);
                url.searchParams.delete('verified');
                window.history.replaceState({}, document.title, url.pathname + url.search);
            });
        </script>
    <?php endif; ?>
<?php endif; ?>

<?php if (isset($_SESSION['user_id'])): ?>
    <!-- Update user status JS -->
    <script src="<?= PATH_URL ?>js/main/status.js"></script>
    <!-- Load search JS -->
    <script src="<?= PATH_URL ?>js/main/search.js"></script>
    <!-- Load new notifications for all users -->
    <script src="<?= PATH_URL ?>js/main/notifications.js"></script>
    <!-- Load new chat notifications -->
    <script src="<?= PATH_URL ?>js/main/chat_notif.js"></script>
    <!-- Load notification toggle -->
    <script src="<?= PATH_URL ?>js/main/notification_menu.js"></script>
<?php endif; ?>
<!-- SCRIPTS -->

</body>

</html>