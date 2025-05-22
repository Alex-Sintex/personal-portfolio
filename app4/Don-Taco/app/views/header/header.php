<?php
$loadDataTableStyles = $data['loadDataTableStyles'] ?? false;
$loadToastStyle = $data['loadToastStyle'] ?? false;
?>

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
    <link rel="stylesheet" href="<?= PATH_URL; ?>css/style.min.css" type="text/css" />
    <link rel="stylesheet" href="<?= PATH_URL; ?>css/styles.css" type="text/css" />

    <?php if ($loadDataTableStyles): ?>
        <!-- DataTables css -->
        <link rel="stylesheet" href="<?= PATH_URL ?>css/DataTable/jquery.dataTables.css" type="text/css" />
        <link rel="stylesheet" href="<?= PATH_URL ?>css/DataTable/buttons.dataTables.css" type="text/css" />
        <link rel="stylesheet" href="<?= PATH_URL ?>css/DataTable/select.dataTables.css" type="text/css" />
        <link rel="stylesheet" href="<?= PATH_URL ?>css/DataTable/responsive.dataTables.css" type="text/css" />
        <link rel="stylesheet" href="<?= PATH_URL ?>css/DataTable/jquery.datetimepicker.css" type="text/css" />
        <link rel="stylesheet" href="<?= PATH_URL ?>css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="<?= PATH_URL ?>css/DataTable/semantic.min.css" type="text/css" />
        <link rel="stylesheet" href="<?= PATH_URL ?>css/DataTable/dataTables.semanticui.css" type="text/css" />
    <?php endif; ?>

    <?php if ($loadToastStyle): ?>
        <!-- Toast styles -->
        <link rel="stylesheet" href="<?= PATH_URL ?>Toasty/css/toasty.css">
    <?php endif; ?>
</head>