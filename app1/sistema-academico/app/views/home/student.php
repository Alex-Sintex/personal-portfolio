<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <!-- Favicons -->
   <link href="<?= BASE_URL; ?>img/favicon/favicon.ico" rel="icon">
   <link href="<?= BASE_URL; ?>img/favicon/apple-touch-icon.png" rel="apple-touch-icon">
   <title>Dashboard</title>
   <!-- BOWER COMPONENTS CSS -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/fontawesome-free/css/all.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/ionicons-2.0.1/css/ionicons.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/jvectormap/jquery-jvectormap.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
   <!-- iziToast css plugins -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/iziToast/css/iziToast.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/iziModal/css/iziModal.min.css">
   <!-- STYLE TABLE -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/DataTables-1.13.6/css/jquery.dataTables.min.css">
   <!-- SWEETALERT2 CSS -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/sweetalert2.css">
   <!-- PLUGINS CSS -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
   <!-- PLUGIN SIGNATURE -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/signature/css/signature.css">
   <!-- Main Template -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>dist/css/skins/_all-skins.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>dist/css/AdminLTE.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/modal.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/custom_dropdown.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/custom_upload.css">
   <!-- Google Font: Source Sans Pro -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
</head>

<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
   <div class="wrapper">
      <!-- Preloader -->
      <div id="preloader">
         <div id="loader-img">
            <div id="loader"></div>
         </div>
         <div id="panel_left" class='loader-section section-left'></div>
         <div id="panel_right" class='loader-section section-right'></div>
      </div>
      <header class="main-header">
         <a href="index2.html" class="logo">
            <span class="logo-mini"><b>KA</b></span>
            <span class="logo-lg"><b>KA's </b>website</span>
         </a>
         <nav class="navbar navbar-static-top">
            <a href="index.html#" class="sidebar-toggle" data-toggle="push-menu" role="button">
               <i class="fas fa-bars"></i>
            </a>
            <div class="navbar-custom-menu">
               <ul class="nav navbar-nav">
                  <li class="dropdown messages-menu">
                  <li class="dropdown notifications-menu">
                     <a href="index.html#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="far fa-bell"></i>
                        <span class="label label-warning">1</span>
                     </a>
                     <ul class="dropdown-menu">
                        <li class="header">You have 1 notification</li>
                        <li>
                           <ul class="menu">
                              <li>
                                 <a href="#">
                                    <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                                    <b>¡Tu solicitud F-DC-15 fue aprobada!</b>
                                 </a>
                              </li>
                           </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                     </ul>
                  </li>
                  </li>
                  <li class="dropdown user user-menu">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                        // Instantiate the User class
                        $userModel = new User();
                        // Get the user data by ID
                        $userId = $_SESSION['usernameStud'];
                        // Get the gender value from the model function
                        $user = $userModel->getStudInfo($userId);
                        // Get the user's image data for the current session
                        $imageUrl = $userModel->getStudImageForSession($userId);

                        if ($imageUrl) {
                           echo '<img src="' . $imageUrl  . '" class="user-image" alt="User Image">';
                        } else {
                           // Set a default image profile if it is not available
                           if ($user->stud_gender === 'Hombre') {
                              echo '<img src="' . BASE_URL . 'img/avatars/male.png" class="user-image" alt="User Image">';
                           } else {
                              echo '<img src="' . BASE_URL . 'img/avatars/female.png" class="user-image" alt="User Image">';
                           }
                        }
                        ?>
                        <?php
                        // Get the username from session
                        $usernameStud = $_SESSION['usernameStud'];

                        if ($usernameStud) {
                           echo '<span class="hidden-xs">' . ucfirst(htmlspecialchars($usernameStud)) . '</span>';
                        } else {
                           echo 'Guest';
                        }
                        ?>
                     </a>
                     <ul class="dropdown-menu user-header">
                        <!-- Dropdown Menu -->
                        <li class="card user-header">
                           <?php
                           // Instantiate the User class
                           $userModel = new User();
                           // Get the user data by ID
                           $userId = $_SESSION['usernameStud'];
                           // Get the gender value from the model function
                           $user = $userModel->getStudInfo($userId);
                           // Get the user's image data for the current session
                           $imageUrl = $userModel->getStudImageForSession($userId);

                           if ($imageUrl) {
                              echo '<img src="' . $imageUrl  . '" alt="User Image">';
                           } else {
                              // Set a default image profile if it is not available
                              if ($user->stud_gender === 'Hombre') {
                                 echo '<img src="' . BASE_URL . 'img/avatars/male.png" alt="User Image">';
                              } else if ($user->stud_gender === 'Mujer') {
                                 echo '<img src="' . BASE_URL . 'img/avatars/female.png" alt="User Image">';
                              } else {
                                 echo '<img src="' . BASE_URL . 'img/avatars/student.png" alt="User Image">';
                              }
                           }
                           ?>
                           <?php
                           // Instantiate the User class
                           $studModel = new User();
                           // Get the username from session
                           $usernameStud = $_SESSION['usernameStud'];
                           // Get the gender value from the model function
                           $student = $studModel->getStudInfo($usernameStud);

                           if ($student) {
                              // User with the provided session ID exists
                              $stud_charge = $student->stud_charge;
                              $registrationDate = date('d/m/y', strtotime($student->created_at));

                              echo '<p class="customP">' . ucfirst(htmlspecialchars($usernameStud)) . '</p>';
                              echo '<p class="customP">' . ucfirst(htmlspecialchars($stud_charge)) . '</p>';
                              echo '<small class="customP">' . "Member since " . $registrationDate . '</small>';
                              echo '</li>'; // End for user-header <li>

                              echo '<li class="user-body">'; // Starting for user-body <li>
                              echo '<div class="row">';
                              echo '</div>';
                              echo '</li>';
                           } else {
                              echo $studentData;
                           }
                           ?>
                        </li>
                        <li class="user-footer">
                           <div class="pull-left">
                              <a href="<?= BASE_URL; ?>profile/account" class="btn btn-default">Profile</a>
                           </div>
                           <div class="pull-right">
                              <button class="btn btn-default" href="javascript:void(0);" onclick="confirmLogout()">Sign
                                 out</button>
                           </div>
                        </li>
                     </ul>
                  </li>
                  <li>
                     <a href="index.html#" data-toggle="control-sidebar"><i class="fa fa-cog"></i></a>
                  </li>
               </ul>
            </div>
         </nav>
      </header>
      <aside class="main-sidebar">
         <section class="sidebar">
            <div class="user-panel">
               <div class="image">
                  <?php
                  // Instantiate the User class
                  $userModel = new User();
                  // Get the user data by ID
                  $userId = $_SESSION['usernameStud'];
                  // Get the gender value from the model function
                  $user = $userModel->getStudInfo($userId);
                  // Get the user's image data for the current session
                  $imageUrl = $userModel->getStudImageForSession($userId);

                  if ($imageUrl) {
                     echo '<img src="' . $imageUrl  . '" class="img-circle" alt="User Image">';
                  } else {
                     // Set a default image profile if it is not available
                     if ($user->stud_gender === 'Hombre') {
                        echo '<img src="' . BASE_URL . 'img/avatars/male.png" class="img-circle" alt="User Image">';
                     } else {
                        echo '<img src="' . BASE_URL . 'img/avatars/female.png" class="img-circle" alt="User Image">';
                     }
                  }
                  ?>
               </div>
               <div class="info" style="position: relative;display: block;padding: 10px;left: 0;background-color: color(srgb 0.3088 0.4998 0.6623);box-shadow: black 10px 1px 20px;">
                  <p>
                     <center>
                        <?php echo strtoupper(htmlspecialchars($_SESSION["usernameStud"])); ?>
                        <hr>
                        <div class="btn-group">
                           <button type="button" class="btn btn-primary">Online</button>
                           <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              <span class="caret"></span>
                           </button>
                           <ul class="dropdown-menu" role="menu">
                              <li><a id="Active"><i class="fa fa-circle text-success"></i>Online</a></li>
                              <li><a id="Inactive"><i class="fa fa-circle text-danger"></i>Offline</a></li>
                           </ul>
                        </div>
                     </center>
                  </p>
               </div>
            </div>
            <form action="javascript:void(0);" method="get" class="sidebar-form">
               <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="Search...">
                  <span class="input-group-btn">
                     <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                     </button>
                  </span>
               </div>
            </form>
            <ul class="sidebar-menu" data-widget="tree">
               <li class="header">MAIN NAVIGATION</li>
               <li class="active treeview">
                  <a href="#">
                     <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li class="active"><a href="homepage"><i class="fa fa-home"></i>Home</a></li>
                  </ul>
               </li>
               <li class="treeview">
                  <a href="#">
                     <i class="fa fa-cog"></i> <span>Settings</span>
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li><a href="<?= BASE_URL; ?>profile/account"><i class="fa fa-user"></i>Profile</a></li>
                  </ul>
               </li>
            </ul>
         </section>
      </aside>
      <div class="content-wrapper">
         <section class="content-header">
            <h1>
               Dashboard
               <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
               <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
               <li class="active">Dashboard</li>
            </ol>
         </section>
         <section class="content">
            <!-- LIST OF F-DC-15 STUDENT RECORDS -->
            <div class="row">
               <section class="col-lg-7 connectedSortable">
                  <!-- STARTING TABLE FOR FDC LIST -->
                  <div class="box box-info">
                     <div class="box-header">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title">F-DC-15</h3>
                        <div class="box-tools pull-right">
                           <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                           </button>
                           <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                     </div>
                     <div class="box-body">
                        <?php if (is_array($data['stud_fdc'])) : ?>
                           <?php foreach ($data['stud_fdc'] as $stud_fdc) : ?>
                              <table id="example3" class="content-table uk-table uk-table-hover uk-table-striped" style="width:100%">
                                 <thead>
                                    <tr>
                                       <th>No. Control</th>
                                       <th>Nombre alumno</th>
                                       <th>Apellido Paterno</th>
                                       <th>Apellido Materno</th>
                                       <th>Carrera</th>
                                       <th>Asunto</th>
                                       <th>Petición</th>
                                       <th>Fecha</th>
                                       <th>Motivos académicos</th>
                                       <th>Motivos personales</th>
                                       <th>Otros motivos</th>
                                       <th>Anexos</th>
                                       <th>Firma</th>
                                       <th>Teléfono</th>
                                       <th>Correo</th>
                                       <?php
                                       $observation = $stud_fdc->observaciones;
                                       echo $observation === null ? '' : '<th>Observaciones</th>';
                                       ?>
                                       <th>Acciones</th>
                                       <?php
                                       $replyFDC = $stud_fdc->resp_solicitud;
                                       echo $replyFDC === null ? '' : '<th>Respuesta de la solicitud</th>';
                                       ?>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr class="sent">
                                       <td>
                                          <?php echo $stud_fdc->nControl; ?>
                                       </td>
                                       <td>
                                          <?php echo $stud_fdc->nombre; ?>
                                       </td>
                                       <td>
                                          <?php echo $stud_fdc->aPaterno; ?>
                                       </td>
                                       <td>
                                          <?php echo $stud_fdc->aMaterno; ?>
                                       </td>
                                       <td>
                                          <?php echo $stud_fdc->carrera; ?>
                                       </td>
                                       <td>
                                          <?php echo $stud_fdc->asunto; ?>
                                       </td>
                                       <td>
                                          <?php echo $stud_fdc->peticion; ?>
                                       </td>
                                       <td>
                                          <?php echo $stud_fdc->fecha; ?>
                                       </td>
                                       <td>
                                          <?php
                                          $motivosA = $stud_fdc->motivosA;
                                          echo $motivosA === '' ? 'Ninguno' : $motivosA;
                                          ?>
                                       </td>
                                       <td>
                                          <?php
                                          $motivosP = $stud_fdc->motivosP;
                                          echo $motivosP === '' ? 'Ninguno' : $motivosP;
                                          ?>
                                       </td>
                                       <td>
                                          <?php
                                          $otrosM = $stud_fdc->otrosM;
                                          echo $otrosM === '' ? 'No aplica' : $otrosM;
                                          ?>
                                       </td>
                                       <td>
                                          <?php
                                          $anexos = json_decode($stud_fdc->anexos, true); // Note the 'true' argument to decode as an associative array
                                          if ($anexos === null) {
                                             echo 'Ninguno';
                                          } else {
                                             if (is_array($anexos)) {
                                                // Handle the array elements as needed, e.g., implode them into a string
                                                echo implode(', ', $anexos);
                                             } else {
                                                // If it's not an array, simply echo the value
                                                echo $anexos;
                                             }
                                          }
                                          ?>
                                       </td>
                                       <td>
                                          <img id="myImg" src="<?= BASE_URL . $stud_fdc->firma_alumno; ?>" alt="Firma ingresada" style="width:100%;max-width:300px">
                                          <!-- The Modal -->
                                          <div id="myModal" class="modalI">
                                             <span class="close">&times;</span>
                                             <img class="modal-contentImg" id="img01">
                                             <div id="caption"></div>
                                          </div>
                                       </td>
                                       <td>
                                          <?php echo $stud_fdc->telefono; ?>
                                       </td>
                                       <td>
                                          <?php echo $stud_fdc->correo; ?>
                                       </td>
                                       <?php
                                       $observations = $stud_fdc->observaciones;
                                       echo $observations === null ? '' : '<td>' . $observations . '</td>';
                                       ?>
                                       <td>
                                          <?php
                                          $FDCStatus = $stud_fdc->estado;
                                          echo $FDCStatus === 'Enviado' ? '' : '<a class="small-box-footer btn btn-primary btn-sm" data-toggle="modal" data-target="#editFDC' . $stud_fdc->nControl . '"><span class="glyphicon glyphicon-edit"></span> Editar</a>';
                                          ?>
                                          <a href="download_fdc?nControl=<?php echo $stud_fdc->nControl; ?>" class="small-box-footer btn btn-success btn-sm"><span class="glyphicon glyphicon-download"></span> Descargar</a>
                                       </td>
                                       <?php
                                       $replyFDC = $stud_fdc->resp_solicitud;
                                       echo $replyFDC === null ? '' : '<td>' . $replyFDC . '</td>';
                                       ?>
                                    </tr>
                                 </tbody>
                              </table>
                     </div>
                     <?php
                              // Instantiate the User class
                              $stud = new User();

                              // Get the student data by username
                              $studUsername = $_SESSION['usernameStud'];

                              // Get the values from the model function
                              $user = $stud->getStudFDCByUser($studUsername);

                              if ($user) {
                                 echo '<div class="box-footer">
                           <a class="btn btn-sm btn-info btn-flat pull-left" data-toggle="modal" data-target="#modalFDC">Añadir nueva solicitud</a>
                           </div>';
                              } else {
                                 // Assuming $stud_fdc is an instance of some class
                                 $FDCStatus = $stud_fdc->estado;
                                 echo $FDCStatus === 'Enviado' ?
                                    '<div class="box-footer">
                           <a class="btn btn-sm btn-info btn-flat pull-left" aria-disabled="true">Solicitud enviada</a>
                           </div>'
                                    :
                                    '<div class="box-footer">
                           <a class="btn btn-sm btn-info btn-flat pull-left btn-sendFDC" id="' . $_SESSION['usernameStud'] . '">Enviar solicitud</a>
                           </div>';
                              }
                     ?>
                  <?php endforeach; ?>
               <?php else : ?>
                  <p>No hay ningún documento F-DC-15 creado aún.</p>
                  <div class="box-footer">
                     <a class="btn btn-sm btn-info btn-flat pull-left" data-toggle="modal" data-target="#modalFDC">Añadir nueva solicitud</a>
                  </div>
               <?php endif; ?>
                  </div>
               </section>
            </div>
         </section>
      </div>
      <?php
      // Instantiate the User class
      $stud = new User();

      // Get the student data by username
      $studUsername = $_SESSION['usernameStud'];

      // Get the values from the model function
      $user = $stud->getFDCStatus($studUsername);

      if ($user === 'No enviado' || $user !== '') {
         $html = <<<HTML
                           <!-- MODAL SEND FDC -->
                        <div class="modal fade" id="modalSendFDC" aria-hidden="true" role="dialog">
                           <div class="modal-dialog modal-sm modal-dialog-centered">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title">Mensaje de confirmación</h5>
                                 </div>
                                 <div class="modal-body">
                                    <h3 class="text-danger">¿Estás seguro de que deseas enviar la solicitud?</h3>
                                    <p>Una vez enviada la solicitud, <b>ya no podrás editar el documento</b>, a excepción de que tu jefe de carrera lo considere pertinente.</p>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="btn_yes">Enviar</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                        HTML;

         echo $html;
      }
      ?>
      <!-- FOOTER STARTING -->
      <footer class="main-footer">
         <div class="pull-right hidden-xs">
            <b>Version</b> 2.0
         </div>
         <strong>Copyright &copy; 2023-2024 <a href="">KA's website</a>.</strong> All rights
         reserved.
      </footer>
      <!-- STARTING SIDEBAR -->
      <aside class="control-sidebar control-sidebar-dark" style="display: none;">
         <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home" aria-hidden="true"></i></a>
            </li>
            <li class="active"><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-cogs" aria-hidden="true"></i></a></li>
         </ul>
         <div class="tab-content">
            <div class="tab-pane" id="control-sidebar-home-tab">
               <ul class="control-sidebar-menu">
                  <li>
                     <div style="text-align:center;padding:1em 0;">
                        <h3><a style="text-decoration:none;" href="https://www.zeitverschiebung.net/es/city/3530597"><span style="color:gray;">Hora actual en</span><br />Mexico City, México</a></h3>
                        <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=es&size=medium&timezone=America%2FMexico_City" width="100%" height="115" frameborder="0" seamless></iframe>
                     </div>
                  </li>
               </ul>
            </div>
            <div class="tab-pane active" id="control-sidebar-settings-tab">
               <div class="form-group">
                  <h4 class="control-sidebar-heading">Select a theme</h4>
                  <ul class="list-unstyled clearfix">
                     <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0)" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                           <div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                           <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                           </div>
                        </a>
                        <p class="text-center no-margin">Blue</p>
                     </li>
                     <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0)" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                           <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span>
                           </div>
                           <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                           </div>
                        </a>
                        <p class="text-center no-margin">Black</p>
                     </li>
                     <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0)" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                           <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                           <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                           </div>
                        </a>
                        <p class="text-center no-margin">Purple</p>
                     </li>
                     <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0)" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                           <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                           <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                           </div>
                        </a>
                        <p class="text-center no-margin">Green</p>
                     </li>
                     <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0)" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                           <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                           <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                           </div>
                        </a>
                        <p class="text-center no-margin">Red</p>
                     </li>
                     <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0)" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                           <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                           <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                           </div>
                        </a>
                        <p class="text-center no-margin">Yellow</p>
                     </li>
                     <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0)" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                           <div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                           <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                           </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px">Blue Light</p>
                     </li>
                     <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0)" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                           <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span>
                           </div>
                           <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                           </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px">Black Light</p>
                     </li>
                     <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0)" data-skin="skin-purple-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                           <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                           <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                           </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px">Purple Light</p>
                     </li>
                     <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0)" data-skin="skin-green-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                           <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                           <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                           </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px">Green Light</p>
                     </li>
                     <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0)" data-skin="skin-red-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                           <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                           <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                           </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px">Red Light</p>
                     </li>
                     <li style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0)" data-skin="skin-yellow-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                           <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                           <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                           </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px">Yellow Light</p>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </aside>
      <div class="control-sidebar-bg"></div>
   </div>
   <?php
   // Instantiate the User class
   $stud = new User();

   // Get the student data by username
   $studUsername = $_SESSION['usernameStud'];

   // Get the values from the model function
   $user = $stud->getFDCStatus($studUsername);

   if ($user === 'No enviado' || $user !== '') {
      $html = <<<HTML
                        <!-- CREATE FDC MODAL -->
                     <div class="modal fade" id="modalFDC" role="dialog" style="display: none;">
                        <!-- The Modal -->
                        <div class="modal-dialog">
                           <div class="modal-content">
                              <!-- Modal Header -->
                              <div class="modal-header">
                                 <h4 class="modal-title">
                                 <img class="imgFDC" src="https://localhost/sistema-academico/public/img/LogoDoc.png" alt="header-image"></h4>
                              </div>
                              <!-- Modal body -->
                              <div class="modal-body">
                                    <div class="box box-info">
                                       <div class="box-header">
                                          <h3 class="box-title">Encabezado del documento</h3>
                                       </div>
                                    <form enctype="multipart/form-data" id="fdcForm" class="form-horizontal" method="POST">
                                       <div class="box-body">
                                          <!-- HEADER OF DOCUMENT FORM GROUP -->
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label">Fecha:</label>
                                             <div class="col-sm-10">
                                                <div class="input-group">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-calendar" aria-hidden="true"></i>
                                                   </div>
                                                   <input name="fechaFDC" type="text" class="form-control" id="fechaFDC" data-inputmask='{"alias": "dd/mm/yyyy"}' data-mask="">
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label">Asunto:</label>
                                             <div class="col-sm-10">
                                                <input name="asuntoA" type="text" class="form-control" id="asuntoA" placeholder="Ingresar asunto">
                                             </div>
                                          </div>
                                          </div>
                                          <!-- BODY OF DOCUMENT FORM GROUP -->
                                          <div class="box box-info">
                                             <div class="box-header">
                                                <h3 class="box-title">Cuerpo del documento</h3>
                                             </div>
                                             <!-- PART FOR NAME OF STUDENT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Nombre:</label>
                                                <div class="col-sm-10">
                                                   <input name="nombreA" type="text" class="form-control" id="nombreA" placeholder="Ingresar nombre">
                                                </div>
                                             </div>
                                             <!-- PART FOR APELLIDO PATERNO OF STUDENT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Apellido Paterno:</label>
                                                <div class="col-sm-10">
                                                   <input name="aPaternoA" type="text" class="form-control" id="aPaternoA" placeholder="Ingresar apellido paterno">
                                                </div>
                                             </div>
                                             <!-- PART FOR APELLIDO MATERNO OF STUDENT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Apellido Materno:</label>
                                                <div class="col-sm-10">
                                                   <input name="aMaternoA" type="text" class="form-control" id="aMaternoA" placeholder="Ingresar apellido materno">
                                                </div>
                                             </div>
                                             <!-- PART FOR CAREER OF STUDENT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Carrera:</label>
                                                <div class="col-sm-10">
                                                   <div class="dropdownC">
                                                      <div class="selectC form-control">
                                                         <span id="selected_career">Selecciona tu carrera</span>
                                                         <i class="fa fa-chevron-left"></i>
                                                      </div>
                                                      <input type="hidden" name="carreraA">
                                                      <ul class="dropdown-menuC" name="carreraA">
                                                         <li class="career" id="Ingeniería Industrial">Ingeniería Industrial</li>
                                                         <li class="career" id="Ingeniería en Gestión Empresarial">Ingeniería en Gestión
                                                            Empresarial</li>
                                                         <li class="career" id="Ingeniería en Sistemas Computacionales">Ingeniería en
                                                            Sistemas Computacionales</li>
                                                         <li class="career" id="Ingeniería en Electrónica">Ingeniería en Electrónica</li>
                                                         <li class="career" id="Ingeniería Electromecánica">Ingeniería Electromecánica
                                                         </li>
                                                         <li class="career" id="Ingeniería en Industrias Alimentarias">Ingeniería en
                                                            Industrias Alimentarias</li>
                                                         <li class="career" id="Ingeniería Bioquímica">Ingeniería Bioquímica</li>
                                                         <li class="career" id="Ingeniería Mecatrónica">Ingeniería Mecatrónica</li>
                                                         <li class="career" id="Ingeniería Civil">Ingeniería Civil</li>
                                                         <li class="career" id="Licenciatura en Gastronomía">Licenciatura en Gastronomía
                                                         </li>
                                                      </ul>
                                                   </div>
                                                </div>
                                             </div>
                                             <!-- PART FOR NO. CONTROL OF STUDENT -->
                                             <div class="form-group">
                                                <label style="padding-top: 0px;" class="col-sm-2 control-label">No. Control:</label>
                                                <div class="col-sm-10">
                                                   <div class="alert callout alert-warning alert-dismissible">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                      <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta!</h4>
                                                      ¡Omite este campo!
                                                   </div>
                                                   <input name="nControlA" type="text" class="form-control" id="nControlA" placeholder="Ingresa tu número de control" value="$_SESSION[usernameStud]" readonly>
                                                </div>
                                             </div>
                                             <!-- PART FOR PETICIÓN OF STUDENT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Petición:</label>
                                                <div class="col-sm-10">
                                                   <input name="peticionA" type="text" class="form-control" id="peticionA" placeholder="Solicito de la manera más atenta se recomiende que me autoricen...">
                                                </div>
                                             </div>
                                             <!-- PART FOR TYPE OF REASON OF STUDENT -->
                                             <div class="box-header">
                                                <h3 class="box-title">Lo anterior ocasionado por los siguientes motivos:</h3>
                                             </div>
                                             <div id="war1"></div>
                                             <!-- ACADEMIC REASON -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Académicos:</label>
                                                <div class="col-sm-10">
                                                   <textarea name="motivosAcaA" type="text" class="form-control" id="motivosAcaA" placeholder="Ingresar razón académica"></textarea>
                                                </div>
                                             </div>
                                             <!-- PERSONAL REASON -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Personales:</label>
                                                <div class="col-sm-10">
                                                   <textarea name="motivosPerA" type="text" class="form-control" id="motivosPerA" placeholder="Ingresar razón personal"></textarea>
                                                </div>
                                             </div>
                                             <!-- OTHER REASON -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Otros:</label>
                                                <div class="col-sm-10">
                                                   <textarea name="otrosMA" type="text" class="form-control" id="otrosMA" placeholder="Ingresar otras razones"></textarea>
                                                </div>
                                             </div>
                                             <!-- EXTRA DOCUMENTS -->
                                             <div class="form-group">
                                                <label for="upload" class="col-sm-2 control-label">Anexos (opcional):</label>
                                                <div class="col-sm-10">
                                                   <div class="anexos">
                                                      <div class="files customDiv">
                                                         <h2>Archivos seleccionados</h2>
                                                         <ul id="previewF" class="listFiles"></ul>
                                                      </div>
                                                      <label class="lAnexos" for="upload">
                                                         <input name="anexosA[]" type="file" id="upload" multiple accept=".pdf, .png, .jpg">
                                                         Upload Files
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>
                                             <!-- SIGN DOCUMENT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Firma:</label>
                                                <div class="col-sm-10">
                                                   <div id="sig" class="kbw-signature"></div>
                                                   <button type="button" class="btn btn-default" id="clear">Clear Signature</button>
                                                   <textarea id="signature64" name="signed" style="display: none"></textarea>
                                                </div>
                                             </div>
                                             <!-- CONTACT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Teléfono particular o de contacto:</label>
                                                <div class="col-sm-10" style="margin: 20px auto;">
                                                   <div class="input-group">
                                                      <div class="input-group-addon">
                                                         <i class="fa fa-phone" aria-hidden="true"></i>
                                                      </div>
                                                      <input name="telefonoA" type="text" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" id="telefonoA" data-mask="" style="font-weight: 500;">
                                                   </div>
                                                </div>
                                             </div>
                                             <!-- EMAIL -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Correo electrónico del estudiante:</label>
                                                <div class="col-sm-10" style="margin: 20px auto;">
                                                   <div class="input-group">
                                                      <div class="input-group-addon">
                                                         <i class="fa fa-envelope" aria-hidden="true"></i>
                                                      </div>
                                                      <input name="correoA" type="email" class="form-control" id="correoA" placeholder="Ingresar correo" style="font-weight: 500;">
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="form-group">
                                                <img class="imgFooter" src="https://localhost/sistema-academico/public/img/FooterDoc.png" alt="image-footer">
                                             </div>
                                          </div>
                                       </div>
                                 </div><!-- END MODAL BODY -->
                                       <!-- Modal footer -->
                                       <div class="modal-footer">
                                             <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Cerrar</button>
                                             <button type="submit" class="btn btn-primary pull-left" name="submitFDC">Guardar</button>
                                       </div>
                                 </form>
                                 <!-- END MODAL CONTENT -->
                              <!-- END MODAL DIALOG -->
                           </div>
                        </div>
                     </div>
                     <!-- END MODAL FDC -->
                     HTML;
      echo $html;
   }
   ?>
   <?php
   // Instantiate the User class
   $stud = new User();

   // Get the student data by username
   $studUsername = $_SESSION['usernameStud'];

   // Get the values from the model function
   $user = $stud->getFDCStatus($studUsername);

   if (is_array($data['stud_fdc'])) :
      foreach ($data['stud_fdc'] as $stud_fdc) :
         if ($user === 'No enviado' || $user !== '') {
            $html = <<<HTML
                     <!-- EDIT MODAL FDC -->
                     <div class="modal fade" id="editFDC' . $stud_fdc->nControl . '" data-backdrop="static" aria-hidden="true" role="dialog" style="display: none;">
                        <!-- The Modal -->
                        <div class="modal-dialog">
                           <div class="modal-content">
                              <!-- Modal Header -->
                              <div class="modal-header">
                                 <h4 class="modal-title"><img class="imgFDC" src="https://localhost/sistema-academico/public/img/LogoDoc.png" alt="header-image"></h4>
                              </div>
                              <!-- Modal body -->
                              <div class="modal-body">
                                 <div class="box box-info">
                                    <div class="box-header">
                                       <div class="alert callout alert-warning alert-dismissible">
                                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                          <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta!</h4>
                                          ¡Asegúrate de que los datos sean correctos!
                                       </div>
                                       <h3 class="box-title">Encabezado del documento</h3>
                                    </div>
                                    <form enctype="multipart/form-data" id="EditfdcForm" class="form-horizontal" method="POST">
                                       <div class="box-body">
                                          <!-- HEADER OF DOCUMENT FORM GROUP -->
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label">Fecha:</label>
                                             <div class="col-sm-10">
                                                <div class="input-group">
                                                   <div class="input-group-addon">
                                                      <i class="fa fa-calendar" aria-hidden="true"></i>
                                                   </div>
                                                   <input name="EditfechaFDC" type="text" class="form-control" id="EditfechaFDC" data-inputmask=\'{"alias": "dd/mm/yyyy"}\' data-mask="" value="' . $stud_fdc->fecha . '">
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label">Asunto:</label>
                                             <div class="col-sm-10">
                                                <input name="EditasuntoA" type="text" class="form-control" id="EditasuntoA" placeholder="Ingresar asunto" value="' . $stud_fdc->asunto . '">
                                             </div>
                                          </div>
                                          <!-- BODY OF DOCUMENT FORM GROUP -->
                                          <div class="box box-info">
                                             <div class="box-header">
                                                <h3 class="box-title">Cuerpo del documento</h3>
                                             </div>
                                             <!-- PART FOR NAME OF STUDENT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Nombre:</label>
                                                <div class="col-sm-10">
                                                   <input name="EditnombreA" type="text" class="form-control" id="EditnombreA" placeholder="Ingresar nombre" value="' . $stud_fdc->nombre . '">
                                                </div>
                                             </div>
                                             <!-- PART FOR APELLIDO PATERNO OF STUDENT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Apellido Paterno:</label>
                                                <div class="col-sm-10">
                                                   <input name="EditaPaternoA" type="text" class="form-control" id="EditaPaternoA" placeholder="Ingresar apellido paterno" value="' . $stud_fdc->aPaterno . '">
                                                </div>
                                             </div>
                                             <!-- PART FOR APELLIDO MATERNO OF STUDENT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Apellido Materno:</label>
                                                <div class="col-sm-10">
                                                   <input name="EditaMaternoA" type="text" class="form-control" id="EditaMaternoA" placeholder="Ingresar apellido materno" value="' . $stud_fdc->aMaterno . '">
                                                </div>
                                             </div>
                                             <!-- PART FOR CAREER OF STUDENT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Carrera:</label>
                                                <div class="col-sm-10">
                                                   <div class="dropdownC">
                                                      <div class="selectC form-control">
                                                      <span id="selected_career">'
                                                         . (isset($stud_fdc->carrera) ? $stud_fdc->carrera : "Selecciona tu carrera") . '
                                                      </span>
                                      <i class="fa fa-chevron-left"></i>
                                  </div>
                                  <input type="hidden" name="EditcarreraA" value="' . (isset($stud_fdc->carrera) ? $stud_fdc->carrera : "Carrera no seleccionada") . '">
                                                      <ul class="dropdown-menuC" name="carreraA">
                                                         <li class="career" id="Ingeniería Industrial">Ingeniería Industrial</li>
                                                         <li class="career" id="Ingeniería en Gestión Empresarial">Ingeniería en Gestión
                                                            Empresarial</li>
                                                         <li class="career" id="Ingeniería en Sistemas Computacionales">Ingeniería en
                                                            Sistemas Computacionales</li>
                                                         <li class="career" id="Ingeniería en Electrónica">Ingeniería en Electrónica</li>
                                                         <li class="career" id="Ingeniería Electromecánica">Ingeniería Electromecánica
                                                         </li>
                                                         <li class="career" id="Ingeniería en Industrias Alimentarias">Ingeniería en
                                                            Industrias Alimentarias</li>
                                                         <li class="career" id="Ingeniería Bioquímica">Ingeniería Bioquímica</li>
                                                         <li class="career" id="Ingeniería Mecatrónica">Ingeniería Mecatrónica</li>
                                                         <li class="career" id="Ingeniería Civil">Ingeniería Civil</li>
                                                         <li class="career" id="Licenciatura en Gastronomía">Licenciatura en Gastronomía
                                                         </li>
                                                      </ul>
                                                   </div>
                                                </div>
                                             </div>
                                             <!-- PART FOR NO. CONTROL OF STUDENT -->
                                             <div class="form-group">
                                                <label style="padding-top: 0px;" class="col-sm-2 control-label">No. Control:</label>
                                                <div class="col-sm-10">
                                                   <div class="alert callout alert-warning alert-dismissible">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                      <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta!</h4>
                                                      ¡Omite este campo!
                                                   </div>
                                                   <input name="EditnControlA" type="text" class="form-control" id="EditnControlA" placeholder="Ingresa tu número de control" value="' . $stud_fdc->nControl . '" readonly>
                                                </div>
                                             </div>
                                             <!-- PART FOR PETICIÓN OF STUDENT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Petición:</label>
                                                <div class="col-sm-10">
                                                   <input name="EditpeticionA" type="text" class="form-control" id="EditpeticionA" placeholder="Solicito de la manera más atenta se recomiende que me autoricen..." value="' . $stud_fdc->peticion . '">
                                                </div>
                                             </div>
                                             <!-- PART FOR TYPE OF REASON OF STUDENT -->
                                             <div class="box-header">
                                                <h3 class="box-title">Lo anterior ocasionado por los siguientes motivos:</h3>
                                             </div>
                                             <div id="war2"></div>
                                             <!-- ACADEMIC REASON -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Académicos:</label>
                                                <div class="col-sm-10">
                                                   <textarea name="EditmotivosAcaA" type="text" class="form-control" id="EditmotivosAcaA" placeholder="Ingresar razón académica">' . $stud_fdc->motivosA . '</textarea>
                                                </div>
                                             </div>
                                             <!-- PERSONAL REASON -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Personales:</label>
                                                <div class="col-sm-10">
                                                   <textarea name="EditmotivosPerA" type="text" class="form-control" id="EditmotivosPerA" placeholder="Ingresar razón personal">' . $stud_fdc->motivosP . '</textarea>
                                                </div>
                                             </div>
                                             <!-- OTHER REASON -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Otros:</label>
                                                <div class="col-sm-10">
                                                   <textarea name="EditotrosMA" type="text" class="form-control" id="EditotrosMA" placeholder="Ingresar otras razones">' . $stud_fdc->otrosM . '</textarea>
                                                </div>
                                             </div>
                                             <!-- EXTRA DOCUMENTS -->
                                             <div class="form-group">
                                                <label for="upload" class="col-sm-2 control-label">Anexos (opcional):</label>
                                                <div class="col-sm-10">
                                                   <div class="anexos">
                                                      <div class="files customDiv">
                                                         <h2>Archivos seleccionados</h2>
                                                         <ul id="previewF" class="listFiles">
                                                            <li>' . (!empty(json_decode($stud_fdc->anexos)) ? implode(", ", json_decode($stud_fdc->anexos)) : "No hay archivos anexados") . '</li>
                                                         </ul>
                                                      </div>
                                                      <label class="lAnexos" for="upload">
                                                         <input name="EditanexosA[]" type="file" id="upload" multiple accept=".pdf, .png, .jpg">
                                                         Upload Files
                                                      </label>
                                                   </div>
                                                </div>
                                             </div>
                                             <!-- SIGN DOCUMENT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Firma:</label>
                                                <div class="col-sm-10">
                                                   <div id="Editsig" class="kbw-signature"></div>
                                                   <button type="button" class="btn btn-default" id="Editclear">Clear Signature</button>
                                                   <textarea id="Editsignature64" name="signed" style="display: none"></textarea>
                                                </div>
                                             </div>
                                             <!-- CONTACT -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Teléfono particular o de contacto:</label>
                                                <div class="col-sm-10" style="margin: 20px auto;">
                                                   <div class="input-group">
                                                      <div class="input-group-addon">
                                                         <i class="fa fa-phone" aria-hidden="true"></i>
                                                      </div>
                                                      <input name="EdittelefonoA" type="text" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" id="EdittelefonoA" data-mask="" style="font-weight: 500;" value="' . $stud_fdc->telefono . '">
                                                   </div>
                                                </div>
                                             </div>
                                             <!-- EMAIL -->
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Correo electrónico del estudiante:</label>
                                                <div class="col-sm-10" style="margin: 20px auto;">
                                                   <div class="input-group">
                                                      <div class="input-group-addon">
                                                         <i class="fa fa-envelope" aria-hidden="true"></i>
                                                      </div>
                                                      <input name="EditcorreoA" type="email" class="form-control" id="EditcorreoA" placeholder="Ingresar correo" style="font-weight: 500;" value="' . $stud_fdc->correo . '">
                                                   </div>
                                                </div>
                                             </div>
                                                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary pull-left" name="submitFDC">Guardar</button>
                                             </div>
                                          </div>
                                             <!-- Modal footer -->
                                             <div class="modal-footer">
                                                <img class="imgFooter" src="https://localhost/sistema-academico/public/img/FooterDoc.png" alt="image-footer">
                                             </div>
                                    </form>
                                    <!-- END MODAL BODY -->
                                 </div>
                                 <!-- END MODAL CONTENT -->
                              </div>
                              <!-- END MODAL DIALOG -->
                           </div>
                        </div>
                     </div>
                     <!-- END EDIT MODAL FDC -->
                     HTML;
            echo $html;
         }
      endforeach;
   else :
      echo '<p>No hay datos para editar, primero crea uno.</p>';
   endif;
   ?>
   <!-- Bower components -->
   <script src="<?= BASE_URL; ?>bower_components/jquery/dist/jquery.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/raphael/raphael.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/morris.js/morris.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/moment/min/moment.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/fastclick/lib/fastclick.js"></script>
   <!-- Plugins -->
   <script src="<?= BASE_URL; ?>plugins/input-mask/jquery.inputmask.js"></script>
   <script src="<?= BASE_URL; ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
   <script src="<?= BASE_URL; ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
   <script src="<?= BASE_URL; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
   <script>
      document.onreadystatechange = function() {
         if (document.readyState === "complete") {
            $("#panel_left").addClass("panel_left");
            $("#panel_right").addClass("panel_right");
            $("#loader").addClass("loaded-circle");
            $("#loader-img").addClass("loaded-img");
            $("#preloader").addClass("loaded-img");
         }
      }
   </script>
   <!-- MAIN -->
   <script src="<?= BASE_URL; ?>dist/js/adminlte.min.js"></script>
   <script src="<?= BASE_URL; ?>dist/js/dashboard.js"></script>
   <script src="<?= BASE_URL; ?>dist/js/demo.js"></script>
   <script src="<?= BASE_URL; ?>js/confirmLogout.js"></script>
   <script src="<?= BASE_URL; ?>js/sweetalert2.js"></script>
   <script src="<?= BASE_URL; ?>js/sign_modal.js"></script>
   <script src="<?= BASE_URL; ?>js/informat.js"></script>
   <script src="<?= BASE_URL; ?>js/search.js"></script>
   <!-- SIGNATURE -->
   <script src="<?= BASE_URL; ?>plugins/signature/js/signature.js"></script>
   <script src="<?= BASE_URL; ?>plugins/signature/js/signature_ui.js"></script>
   <?php
   // Instantiate the User class
   $stud = new User();

   // Get the student data by username
   $studUsername = $_SESSION['usernameStud'];

   // Get the values from the model function
   $user = $stud->getFDCStatus($studUsername);

   if ($user === 'No enviado' || $user !== '') {
      echo '<!-- AJAX -->';
      echo '<script src="' . BASE_URL . 'ajax/generate-fdc.js"></script>';
      echo '<script src="' . BASE_URL . 'ajax/editFDC.js"></script>';
      echo '<script src="' . BASE_URL . 'ajax/setFDCState.js"></script>';
   }
   ?>
   <!-- TABLES SCRIPT -->
   <script src="<?= BASE_URL; ?>plugins/DataTables/DataTables-1.13.6/js/jquery.dataTables.min.js"></script>
   <script src="<?= BASE_URL; ?>plugins/DataTables/DataTables-1.13.6/js/dataTables.bootstrap4.min.js"></script>
   <script src="<?= BASE_URL; ?>plugins/DataTables/Responsive-2.5.0/js/dataTables.responsive.min.js"></script>
   <script src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
   <script src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/buttons.bootstrap4.min.js"></script>
   <script src="<?= BASE_URL; ?>plugins/DataTables/JSZip-3.10.1/jszip.min.js"></script>
   <script src="<?= BASE_URL; ?>plugins/DataTables/pdfmake-0.2.7/pdfmake.min.js"></script>
   <script src="<?= BASE_URL; ?>plugins/DataTables/pdfmake-0.2.7/vfs_fonts.js"></script>
   <script src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/buttons.html5.min.js"></script>
   <script src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/buttons.print.min.js"></script>
   <script src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
   <script src="<?= BASE_URL; ?>plugins/DataTables/FixedColumns-4.3.0/js/fixedColumns.dataTables.min.js"></script>
   <script src="<?= BASE_URL; ?>js/dataTableStud.js"></script>
   <!-- END TABLES SCRIPT -->
   <script type="text/javascript" src="<?= BASE_URL; ?>js/custom_dropdown.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>js/upload_files.js"></script>
   <!-- iziToast JS plugins -->
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/iziToast/js/iziToast.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/iziModal/js/iziModal.min.js"></script>
</body>

</html>