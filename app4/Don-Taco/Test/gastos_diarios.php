<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Don Taco</title>
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
        <table cellpadding="0" cellspacing="0" border="0" class="dataTable responsive-table" id="gastos_d">
            <caption>Gastos diarios</caption>
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Carne</th>
                    <th scope="col">Queso</th>
                    <th scope="col">Tortilla Maíz</th>
                    <th scope="col">Tortilla Harina Grande</th>
                    <th scope="col">Longaniza</th>
                    <th scope="col">Pan</th>
                    <th scope="col">Bodegón</th>
                    <th scope="col">Adelanto Marcos</th>
                    <th scope="col">Transporte Marcos</th>
                    <th scope="col">Nómina</th  >
                    <th scope="col">Nómina Weekend</th>
                    <th scope="col">Mundo Novi</th>
                    <th scope="col">Color</th>
                    <th scope="col">Otros</th>
                    <th scope="col">Observaciones</th>
                    <th scope="col">Total Gastos Diarios</th>
                    <th scope="col">Acción</th>
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
    <script src="js/DataTable/gastos_diarios.js"></script>
</body>

</html>