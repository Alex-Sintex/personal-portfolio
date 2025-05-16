<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance</title>
    <link rel="icon" type="image/x-icon" href="favicon/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
    <!-- DataTable styles-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" />
</head>
<body>
    <div class="container">
        <button class="btn btn-primary" id="addbutton" title="Add"><span class="fa fa-plus-square"></span></button>
        <table cellpadding="0" cellspacing="0" border="0" class="dataTable responsive-table" id="balance">
            <caption>Balance</caption>
            <thead>
                <tr>
                    <th scope="col">NO.</th>
                    <th scope="col">FECHA</th>
                    <th scope="col">GASTOS FIJOS DIARIOS</th>
                    <th scope="col">GASTOS DIARIOS</th>
                    <th scope="col">TOTAL EGRESOS</th>
                    <th scope="col">VENTA EFECTIVO</th>
                    <th scope="col">VENTA TRANSFERENCIA</th>
                    <th scope="col">VENTA NETA TARJETA</th>
                    <th scope="col">VENTA TARJETA - %</th>
                    <th scope="col">TOTAL INGRESOS</th>
                    <th scope="col">UTILIDAD PISO</th>
                    <th scope="col">UTILIDAD DISPONIBLE</th>
                    <th scope="col">INGRESO PLATAFORMAS</th  >
                    <th scope="col">NOMBRE</th>
                    <th scope="col">ACCIÓN</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- DataTable scripts -->
    <script src="https://code.jquery.com/jquery-3.0.0.js"></script>

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js"></script>
    <script src="js/DataTable/dataTables.altEditor.js"></script>
    <script src="js/DataTable/balance.js"></script>
</body>
</html>