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
   <!-- STYLE TABLE -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/DataTables-1.13.6/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/datatables-select/css/select.bootstrap4.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/datatables-rowreorder/css/rowReorder.bootstrap4.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/datatables-editor/css/editor.dataTables.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/css/buttons.dataTables.min.css">
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
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/timepicker/bootstrap-timepicker.min.css">
   <!-- iziToast css plugins -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/iziToast/css/iziToast.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/iziModal/css/iziModal.min.css">
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
         <a href="#" class="logo">
            <span class="logo-mini"><b>KA</b></span>
            <span class="logo-lg"><b>KA's </b>website</span>
         </a>
         <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
               <i class="fas fa-bars"></i>
            </a>
            <div class="navbar-custom-menu">
               <ul class="nav navbar-nav">
                  <?php
                  // Define an array of allowed usernames
                  $allowedUsers = ['Secretario'];
                  if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
                     $html = <<<HTML
                                    <li class="dropdown messages-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="far fa-comments"></i>
                                    <span class="label label-success">1</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                    <li class="header">You have 1 message(s)</li>
                                    <li>
                                    <ul class="menu">
                                      <li>
                                          <a href="#">
                                              <div class="pull-left">
                                                  <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                              </div>
                                              <h4>
                                                  Support Team
                                                  <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                              </h4>
                                              <p>Why not buy a new awesome theme?</p>
                                          </a>
                                      </li>
                                    </ul>
                                    </li>
                                    <li class="footer"><a href="#">Borrar mensajes</a></li>
                                    </ul>
                                    </li>
                                    <li class="dropdown notifications-menu">
                                       <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                          <i class="far fa-bell"></i>
                                          <span class="label label-warning">0</span>
                                       </a>
                                       <ul class="dropdown-menu">
                                             <li class="header">No notifications</li>
                                          <li>
                                             <ul id="notificationsList" class="menu"></ul>
                                          </li>
                                             <li class="footer"><a href="#">Borrar notificaciones</a></li>
                                       </ul>
                                    </li>
                                    HTML;
                     echo $html;
                  }
                  ?>
                  <?php
                  // Define an array of allowed usernames
                  $allowedUsers = ['Director académico', 'Jefe de carrera', 'Secretario técnico'];
                  if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
                     $html = <<<HTML
                                    <li class="dropdown messages-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="far fa-comments"></i>
                                    <span class="label label-success">1</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                    <li class="header">You have 1 message(s)</li>
                                    <li>
                                    <ul class="menu">
                                      <li>
                                          <a href="#">
                                              <div class="pull-left">
                                                  <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                              </div>
                                              <h4>
                                                  Support Team
                                                  <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                              </h4>
                                              <p>Why not buy a new awesome theme?</p>
                                          </a>
                                      </li>
                                    </ul>
                                    </li>
                                    <li class="footer"><a href="#">Borrar mensajes</a></li>
                                    </ul>
                                    </li>
                                    HTML;
                     echo $html;
                  }
                  ?>
                  <li class="dropdown user user-menu">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                        // Instantiate the User class
                        $userModel = new User();
                        // Get the user data by ID
                        $userId = $_SESSION['id'];
                        // Get the gender value from the model function
                        $user = $userModel->getUserById($userId);

                        // Get the user's image URL for the current session
                        $imageUrl = $userModel->getUserImageForSession();

                        if ($imageUrl) {
                           // Generate the HTML with the image URL
                           echo '<img src="'  . $imageUrl . '" class="user-image" alt="User Image">';
                        } else {
                           // Set a default image profile if it is not available
                           if ($user->gender === 'Hombre') {
                              echo '<img src="' . BASE_URL . 'img/avatars/male.png" class="user-image" alt="User Image">';
                           } else {
                              echo '<img src="' . BASE_URL . 'img/avatars/female.png" class="user-image" alt="User Image">';
                           }
                        }
                        ?>
                        <?php
                        $user = new User();
                        $userName = $user->getUserNameForSession();

                        if ($userName) {
                           echo '<span class="hidden-xs">' . ucfirst(htmlspecialchars($userName)) . '</span>';
                        } else {
                           echo 'User not found.';
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
                           $userId = $_SESSION['id'];
                           // Get the gender value from the model function
                           $user = $userModel->getUserById($userId);

                           // Get the user's image URL for the current session
                           $imageUrl = $userModel->getUserImageForSession();

                           if ($imageUrl) {
                              // Generate the HTML with the image URL
                              echo '<img src="'  . $imageUrl . '" alt="User Image">';
                           } else {
                              // Set a default image profile if it is not available
                              if ($user->gender === 'Hombre') {
                                 echo '<img src="' . BASE_URL . 'img/avatars/male.png" alt="User Image">';
                              } else {
                                 echo '<img src="' . BASE_URL . 'img/avatars/female.png" alt="User Image">';
                              }
                           }
                           ?>
                           <?php
                           $user = new User();
                           $userData = $user->getUserNameAndRegistrationDateForSession();

                           if ($userData) {
                              if (is_array($userData) && array_key_exists('name', $userData)) {
                                 echo '<p class="customP">' . ucfirst(htmlspecialchars($userData['name'])) . '</p>';
                              } else {
                                 // Manejar el caso en el que no se pueda obtener el nombre del usuario
                                 echo '<p class="customP">Guest</p>';
                              }
                              if ($userData['charge'] === "Secretario") {
                                 if ($userData["gender"] === "Hombre") {
                                    echo '<p class="customP">Secretario</p>';
                                 } else {
                                    echo '<p class="customP">Secretaria</p>';
                                 }
                              } else if ($userData['charge'] === 'Jefe de carrera') {
                                 if ($userData["gender"] === "Hombre") {
                                    echo '<p class="customP">Jefe de carrera</p>';
                                 } else {
                                    echo '<p class="customP">Jefa de carrera</p>';
                                 }
                              } else {
                                 echo '<p class="customP">' . $userData['charge'] . '</p>';
                              }
                              echo '<small class="customP">' . "Member since " . $userData['registration_date'] . '</small>';
                              echo '</li>'; // End for user-header <li>

                              echo '<li class="user-body">'; // Starting for user-body <li>
                              echo '<div class="row">';
                              echo '<div class="text-center" style="margin: 24px 0;">';
                              echo '<a href="https://web.whatsapp.com" target="_blank" rel="noopener noreferrer"><i class="customA fab fa-whatsapp"></i></a>';
                              echo '<a href="https://www.google.com" target="_blank" rel="noopener noreferrer"><i class="customA fab fa-google"></i></a>';
                              echo '<a href="https://www.youtube.com" target="_blank" rel="noopener noreferrer"><i class="customA fab fa-youtube"></i></a>';
                              echo '<a href="https://mail.google.com" target="_blank" rel="noopener noreferrer"><i class="customA fa fa-envelope"></i></a>';
                              echo '</div>';
                              echo '</div>';
                              echo '</li>';
                           } else {
                              echo '<p>Guest</p>';
                           }
                           ?>
                        </li>
                        <li class="user-footer">
                           <div class="pull-left">
                              <a href="<?php echo BASE_URL ?>profile/profile" class="btn btn-default">Profile</a>
                           </div>
                           <div class="pull-right">
                              <button class="btn btn-default" href="javascript:void(0);" onclick="confirmLogout()">
                                 Sign out
                              </button>
                           </div>
                        </li>
                     </ul>
                  </li>
                  <li>
                     <a href="#" data-toggle="control-sidebar"><i class="fa fa-cog"></i></a>
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
                  $userId = $_SESSION['id'];
                  // Get the gender value from the model function
                  $user = $userModel->getUserById($userId);

                  // Get the user's image URL for the current session
                  $imageUrl = $userModel->getUserImageForSession();

                  if ($imageUrl) {
                     // Generate the HTML with the image URL
                     echo '<img src="'  . $imageUrl . '" class="user-image" alt="User Image">';
                  } else {
                     // Set a default image profile if it is not available
                     if ($user->gender === 'Hombre') {
                        echo '<img src="' . BASE_URL . 'img/avatars/male.png" class="user-image" alt="User Image">';
                     } else {
                        echo '<img src="' . BASE_URL . 'img/avatars/female.png" class="user-image" alt="User Image">';
                     }
                  }
                  ?>
               </div>
               <div class="info" style="position: relative;display: block;padding: 10px;left: 0;background-color: color(srgb 0.3088 0.4998 0.6623);box-shadow: black 10px 1px 20px;">
                  <p>
                     <?php echo strtoupper(htmlspecialchars($_SESSION["username"])); ?>
                  </p>
                  <div class="btn-group">
                     <button type="button" class="btn btn-primary"><?php echo ucfirst(htmlspecialchars($_SESSION["status"])); ?></button>
                     <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                     </button>
                     <ul class="dropdown-menu" role="menu">
                        <li><a id="Active"><i class="fa fa-circle text-success"></i>Online</a></li>
                        <li><a id="Inactive"><i class="fa fa-circle text-danger"></i>Offline</a></li>
                     </ul>
                  </div>
               </div>
            </div>
            <form action="javascript:void(0)" method="get" class="sidebar-form">
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
                  <a href="javascript:void(0)">
                     <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li class="active"><a href="homepage"><i class="fa fa-home"></i>Home</a></li>
                     <?php
                     // Check if the username in the session is 'administrator'
                     if (isset($_SESSION['username']) && $_SESSION['username'] === 'administrator') {
                        // Display the specific HTML code for the 'administrator'
                        echo '<li><a href="' . BASE_URL . 'users/users"><i class="fa fa-users"></i>Users</a></li>';
                     }
                     ?>
                     <?php
                     $allowedUsers = ['Jefe de carrera', 'Secretario'];
                     // Check if the username in the session is 'administrator'
                     if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
                        // Display the specific HTML code for the 'administrator'
                        echo '<li><a href="' . BASE_URL . 'users/students"><i class="fa fa-graduation-cap"></i>Students</a></li>';
                     }
                     ?>
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
                     <li><a href="<?php echo BASE_URL ?>profile/profile"><i class="fa fa-user"></i>Profile</a></li>
                  </ul>
               </li>
               <li class="treeview">
                  <a href="">
                     <i class="fa fa-users"></i> <span>Lista de usuarios</span>
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li class="treeview">
                        <a href=""><i class="fa fa-circle text-green"></i> Online
                           <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                           </span>
                        </a>
                        <ul class="treeview-menu">
                           <li><a href=""><i class="fa fa-circle"></i> Noemi</a></li>
                        </ul>
                     </li>
                     <li class="treeview">
                        <a href=""><i class="fa fa-circle text-red"></i> Offline
                           <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                           </span>
                        </a>
                        <ul class="treeview-menu">
                           <li><a href=""><i class="fa fa-circle"></i> Noemi</a></li>
                        </ul>
                     </li>
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
            <!-- LIST OF F-DC-15 RECORDS -->
            <div class="row">
               <section class="col-lg-7 connectedSortable">
                  <?php
                  // Define an array of allowed usernames
                  $allowedUsers = ['Director académico', 'Secretario técnico', 'Jefe de carrera'];
                  if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
                     $html = <<<HTML
                                                      <!-- GRAPHS OF ACADEMIC RECORDS GENERATED -->
                                                      <div class="nav-tabs-custom">
                                                         <div class="box box-primary">
                                                            <div class="box-header with-border">
                                                               <i class="fa fa-bar-chart"></i>
                                                               <h3 class="box-title">Reporte de solicitudes atendidas</h3>
                                                               <div class="box-tools pull-right">
                                                                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                                  </button>
                                                                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                               </div>
                                                            </div>
                                                            <div class="box-body">
                                                               <div class="row">
                                                                  <div class="col-md-8">
                                                                     <div class="chart">
                                                                        <canvas id="barChart" style="height: 180px; width: 763px;" height="360" width="1526"></canvas>
                                                                     </div>
                                                                  </div>
                                                                  <div class="col-md-4">
                                                                  <p class="text-center">
                                                                     <strong>Carreras</strong>
                                                                  </p>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                            <div class="panel box box-primary box-footer">
                                                            <div class="with-border">
                                                            <h4 class="box-title">
                                                            <a data-toggle="collapse" data-parent="#accordion" href="general.html#collapseTwo" class="collapsed" aria-expanded="false">
                                                            <i class="fa fa-chevron-circle-down" aria-hidden="true"></i> Comentarios
                                                            </a>
                                                            </h4>
                                                            </div>
                                                            <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">
                                                            <div class="box-body">
                                                               <!-- BEGINNING TIMELINE -->
                                                               <ul class="timeline">
                                                                  <div class="timeline-footer">
                                                                        <div class="box box-default box-solid collapsed-box">
                                                                        <div class="btn-primary btn-xs">
                                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse" style="width: 100%;">
                                                                           <h4 class="box-title" style="color: white;">Añadir comentario</h4>
                                                                        </button>
                                                                        </div>
                                                                        <div class="box-body" style="display: none;">
                                                                           <div class="input-group">
                                                                              <span class="input-group-addon"><i class="fa fa-comment" aria-hidden="true"></i></span>
                                                                              <input id="sender" name="comment" type="text" class="form-control" placeholder="Escribe un comentario">
                                                                              </div>
                                                                        </div>
                                                                        </div>
                                                                        </div>
                                                                  <!-- END timeline item -->
                                                               </ul>
                                                               <!-- END TIMELINE -->
                                                            </div>
                                                         </div>
                                                      </div>
                                                      </div>
                                                      </div>
                                                      HTML;
                     echo $html;
                  }
                  ?>
                  <?php
                  // Define an array of allowed usernames
                  $allowedUsers = ['Director académico', 'Jefe de carrera', 'Secretario'];

                  if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
                     $html = <<<HTML
                     <!-- STARTING TABLE FOR ACTA -->
                     <div class="box box-info">
                        <div class="box-header">
                           <i class="far fa-folder-open"></i>
                           <h3 class="box-title">Actas académicas</h3>
                              <div class="box-tools pull-right">
                                 <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                 <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                              </div>
                        </div>
                        <div class="box-body">
                           <table id="tbActa" class="content-table uk-table uk-table-hover uk-table-striped" width="100%"></table>
                     HTML;
                     if (isset($_SESSION['charge']) && $_SESSION['charge'] === 'Director académico') {
                        $html .= <<<HTML
                           <form method="GET" action="generate_acta">
                              <button type="submit" name="generate" class="btn btn-primary">Generar acta</button>
                           </form>
                     HTML;
                     } elseif (isset($_SESSION['charge']) && $_SESSION['charge'] === 'Secretario') {
                        $html .= <<<HTML
                           <button class="btn btn-primary trigger" data-iziModal-open="#ModalActa">Acta académica</button>
                     HTML;
                     }
                     $html .= <<<HTML
                     </div>
                        </div>
                     HTML;
                     echo $html;
                  }
                  ?>

                  <!-- General requests -->
                  <?php
                  // Define an array of allowed usernames
                  $allowedUsers = ['Secretario'];

                  if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
                     $html = <<<HTML
                     <!-- STARTING TABLE FOR ACTA -->
                     <div class="box box-info">
                        <div class="box-header">
                           <i class="far fa-folder-open"></i>
                              <h3 class="box-title">Asuntos generales del acta</h3>
                              <div class="box-tools pull-right">
                                 <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                 <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                              </div>
                        </div>
                        <div class="box-body">
                           <table id="tbAG" class="content-table uk-table uk-table-hover uk-table-striped" style="width:100%"></table>
                        </div>
                     </div>
                     HTML;
                     echo $html;
                  }
                  ?>

                  <?php
                  // Define an array of allowed usernames
                  $allowedUsers = ['Secretario'];
                  if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
                     $html = <<<HTML
                                            <!-- STARTING TABLE FOR F-DC-15 -->
                                             <div class="box box-primary">
                                                <div class="box-header">
                                                    <i class="far fa-folder-open"></i>
                                                    <h3 class="box-title">F-DC-15 recibidos</h3>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                   <table id="example1" class="content-table uk-table uk-table-hover uk-table-striped" style="width:100%"></table>
                                                </div>
                                                <div class="box-footer">
                                                   <select id="careerSelect" class="select">
                                                      <i class="fa fa-angle-left pull-right"></i>
                                                      <option value="" disabled selected>Selecciona una carrera</option>
                                                      <option value="Ingeniería Industrial">Ingeniería Industrial</option>
                                                      <option value="Ingeniería en Gestión Empresarial">Ingeniería en Gestión Empresarial</option>
                                                      <option value="Ingeniería en Sistemas Computacionales">Ingeniería en Sistemas Computacionales</option>
                                                      <option value="Ingeniería en Electrónica">Ingeniería en Electrónica</option>
                                                      <option value="Ingeniería Electromecánica">Ingeniería Electromecánica</option>
                                                      <option value="Ingeniería en Industrias Alimentarias">Ingeniería en Industrias Alimentarias</option>
                                                      <option value="Ingeniería Bioquímica">Ingeniería Bioquímica</option>
                                                      <option value="Ingeniería Mecatrónica">Ingeniería Mecatrónica</option>
                                                      <option value="Ingeniería Civil">Ingeniería Civil</option>
                                                      <option value="Licenciatura en Gastronomía">Licenciatura en Gastronomía</option>
                                                   </select>
                                                </div>
                                             </div>
                                       HTML;
                     echo $html;
                  }
                  ?>
                  <?php
                  // Define an array of allowed usernames
                  $allowedUsers = ['Jefe de carrera'];
                  if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
                     $html = <<<HTML
                                            <!-- STARTING TABLE FOR F-DC-15 -->
                                            <div class="box box-primary">
                                                <div class="box-header">
                                                    <i class="far fa-folder-open"></i>
                                                    <h3 class="box-title">Consulta de solicitudes F-DC-15</h3>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                   <form id="checkedFDC" method="POST">
                                                      <table id="example3" class="content-table uk-table uk-table-hover uk-table-striped" style="width:100%"></table>
                                                         <p><b>Datos seleccionados:</b></p>
                                                         <pre id="example-console-rows"></pre>
                                                         <button id="checkedFDCList" class="btn btn-primary" data-iziModal-open="#ModalObsFDC" disabled>Añadir observación</button>
                                                   </form>
                                                </div>
                                             </div>
                                    HTML;
                     echo $html;
                  }
                  ?>
                  <?php
                  // Define an array of allowed usernames
                  $allowedUsers = ['Jefe de carrera'];
                  if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
                     echo '
                                    <!-- SELECT FDC FOR ACTA -->
                                    <div class="box box-primary">
                                    <div class="box-header">
                                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                                    <h3 class="box-title">Solicitudes Atendidas/Validadas</h3>
                                    <div class="box-tools pull-right">
                                    <ul class="pagination pagination-sm inline">
                                    <li><a href="#">&laquo;</a></li>
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">&raquo;</a></li>
                                    </ul>
                                    </div>
                                    </div>
                                    <div class="box-body">
                                    <div class="alert alert-warning alert-dismissible">
                                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                       <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alerta</h4>
                                       ¡A continuación puede marcar las solicitudes que ya fueron atendidas o validadas!
                                    </div>
                                    <ul class="todo-list">
                                    '; // Ended echo here
                     if (is_array($data["fdc"])) {
                        foreach ($data["fdc"] as $fdc) {
                           echo '
                                    <li>
                                    <span class="handle">
                                    <i class="fa fa-ellipsis-v"></i>
                                    <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" value>
                                    <span class="text">' . $fdc->nControl . '</span>
                                    <small class="label label-danger"><i class="fa fa-clock-o"></i> ' . $fdc->fecha . '</small>
                                    <div class="tools">
                                    <i class="fa fa-eye"></i>
                                    </div>
                                    </li>
                                    ';
                        }
                     } else {
                        echo '<li><span class="text">Sin solicitudes F-DC-15</span></li>';
                     }

                     // Close the ul and div element
                     echo '
                                    </ul>
                                    </div>
                                    </div>';
                  }
                  ?>
                  <?php
                  // Define an array of allowed usernames
                  $allowedUsers = ['Director académico', 'Secretario técnico', 'Jefe de carrera', 'Secretario'];
                  if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
                     // Check if $data["users"] is an array
                     if (is_array($data["users"])) {
                        echo '
                                    <!-- CHATTING -->
                                    <div class="box box-primary direct-chat direct-chat-warning">
                                    <div class="box-header with-border">
                                    <i class="fa fa-comments" aria-hidden="true"></i>
                                    <h3 class="box-title">Direct Chat</h3>
                                    <div class="box-tools pull-right">
                                    <span data-toggle="tooltip" title="1 New Messages" class="badge bg-yellow">1</span>
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                                    <i class="fa fa-comments" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                    </div>
                                    </div>
                                          <div class="box-body chat-box">
                                          <div id="chatContainer" class="direct-chat-messages">
                                          <div class="direct-chat-msg">
                                                      <div class="direct-chat-info clearfix">
                                                         <span class="direct-chat-name pull-left">Noemi Martínez</span>
                                                         <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                                      </div>
                                                         <img class="direct-chat-img" src="' . BASE_URL . 'img/avatars/female.png" alt="message user image">
                                                      <div class="direct-chat-text">Good afternoon!
                                                      </div>
                                                      </div>
                                                      <div class="direct-chat-msg right">
                                             <div class="direct-chat-info clearfix">
                                                <span class="direct-chat-name pull-right">Oscar Alejandro</span>
                                                <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                                             </div>
                                                <img class="direct-chat-img" src="' . BASE_URL . 'img/avatars/male.png" alt="message user image">
                                             <div class="direct-chat-text">Hiya!
                                             </div>
                                             </div>
                                             </div>
                                             <div class="direct-chat-contacts">
                                             <ul class="contacts-list">';
                                          foreach ($data["users"] as $user) {
                                                echo '
                                             <li>
                                                <a href="chat?user_id=' . $user->id . '">
                                                <img class="contacts-list-img" src="' . (($user->profile_image !== null) ? $user->profile_image : (($user->gender === 'male') ? BASE_URL . 'img/avatars/male.png' : BASE_URL . 'img/avatars/female.png')) . '" alt="User Image">
                                             <div class="contacts-list-info">
                                                <span class="contacts-list-name">' . $user->firstname . '
                                                   <small class="contacts-list-date pull-right">2/28/2015</small>
                                                </span>
                                                <span class="contacts-list-msg">How have you been? I was...</span>
                                                </div>
                                                </a>
                                                </li>';
                                          }
                                             echo '
                                    </ul>
                                    </div>
                                    </div>
                                    <div class="box-footer">
                                    <form class="typing-area" action="#" method="post">
                                       <div class="input-group">
                                          <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
                                          <input type="text" name="message" placeholder="Escribe tu mensaje aquí..." class="input-field form-control">
                                          <span class="input-group-btn">
                                             <button type="submit" class="btn btn-warning btn-flat"><i class="fab fa-telegram-plane"></i></button>
                                          </span>
                                       </div>
                                    </form>
                                    </div>
                                    </div>
                                    ';
                     }
                  }
                  ?>
               </section>
            </div>
         </section>
      </div>
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
                     <div style="text-align: center;font-size: large;margin: 0px 10px;padding: 2px 5px;">
                        <h3>
                           <span style="color:gray;">Hora actual en</span><br />
                           Mexico City, México
                        </h3>

                        <?php
                        // Set the timezone to Mexico City
                        date_default_timezone_set('America/Mexico_City');

                        // Get the current date and time in Mexico City
                        $currentDateTime = date('l, F j, Y - H:i A');
                        ?>

                        <p><strong id="timeDisplay"><?php echo $currentDateTime; ?></strong></p>
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
   <!-- Modal structure for observation -->
   <div id="ModalObsFDC" class="iziModal">
      <div class="iziModal-contentObs">
         <label for="observationFDC">Observación:</label>
         <input type="text" id="observationFDC" placeholder="Ingresa una observación para la solicitud(es) seleccionada(s)">
      </div>
   </div>
   <!-- MODAL FOR ACTA -->
   <div id="ModalActa" class="iziModal">
      <!-- Modal content-->
      <div class="modal-contentA">
         <!-- Modal Header -->
         <div class="modal-header">
            <img class="imgFDC" src="https://localhost/sistema-academico/public/img/LogoActa.png" alt="header-image">
         </div>
         <!-- Modal body -->
         <div class="modal-bodyA">
            <form id="ActaForm" class="form-horizontal" method="POST">
               <div class="box-body">
                  <!-- HEADER OF DOCUMENT FORM GROUP -->
                  <div class="map-container">
                     <div class="inner-basic division-details">
                        <div class="form-group">
                           <div class="col-sm-10">
                              <p class="actaPTitle">ACTA DE LA
                                 <?php
                                 function getCurrentMonth()
                                 {
                                    return date('n');
                                 }

                                 function getSessionString($month)
                                 {
                                    return ucfirst(getSpanishOrdinal($month)) . ' SESIÓN ORDINARIA ' . date('Y');
                                 }

                                 function getSpanishOrdinal($number)
                                 {
                                    $suffix = array('', 'PRIMERA', 'SEGUNDA', 'TERCERA', 'CUARTA', 'QUINTA', 'SEXTA', 'SÉPTIMA', 'OCTAVA', 'NOVENA', 'DÉCIMA', 'UNDÉCIMA', 'DUODÉCIMA');
                                    return $suffix[$number];
                                 }

                                 // Get the current month
                                 $currentMonth = getCurrentMonth();

                                 // Create the array of session strings
                                 $sessionsArray = array();
                                 for ($month = 1; $month <= 12; $month++) {
                                    $sessionsArray[$month] = getSessionString($month);
                                 }

                                 // Output the select dropdown
                                 echo '<select id="nameSesActa" name="nameSesActa" class="select" style="font-weight: bold;">';
                                 foreach ($sessionsArray as $month => $sessionString) {
                                    $selected = ($month == $currentMonth) ? 'selected' : ''; // Set the actual month as default
                                    echo '<option value="' . htmlspecialchars($sessionString) . '" ' . $selected . '>' . htmlspecialchars($sessionString) . '</option>';
                                 }
                                 echo '</select>';
                                 ?>
                                 DEL COMITÉ ACADÉMICO DEL INSTITUTO
                                 <span class="actaSPTitle">TECNOLÓGICO SUPERIOR DE XALAPA CELEBRADA EL <input type="text" id="celebrated_at" name="celebrated_at" class="inputStyle" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" required></span>
                              </p>
                           </div>
                        </div>
                        <div class="page1">
                           <div class="form-group">
                              <div class="col-sm-10">
                                 <p class="actaPBody">En la ciudad de Xalapa, Veracruz, siendo las <input type="text" id="acta_time" class="inputStyle timepicker" name="acta_time" style="font-weight: bold;" required>
                                    del día <input type="text" id="acta_date" name="acta_date" class="inputStyle" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" required>, se reunieron
                                    de manera presencial en la Sala de Juntas del ITSX:
                                    Mtra. Celia Gabriela Sierra Carmona,
                                    Directora Académica como Presidenta;
                                    Ing. Alejandro Israel Vargas Cabañas,
                                    Subdirector Académico; Mtra. Korina González Camacho,
                                    Subdirectora de Posgrado e Investigación;
                                    Mtro. Oscar Alejandro Trujillo Flores,
                                    Jefe de la División de la Carrera de Ingeniería en Sistemas Computacionales como Secretario Técnico;
                                    M.I.I. Nayeli Serrano Villa,
                                    Jefa de la División de la Carrera de Ingeniería Industrial;
                                    M.C. José Daniel Hernández Ventura,
                                    Jefe de la División de la Carrera de Ingeniería Electrónica;
                                    Ing. Osvaldo Camacho Jarvio,
                                    Jefe de la División de la Carrera de Ingeniería Electromecánica;
                                    Ing. Nemecio Martínez Martínez,
                                    Jefe de División de la Carrera de Ingeniería en Industrias Alimentarias;
                                    Mtra. Ludivina Flores Villegas,
                                    Jefa de la División de la Carrera de Ingeniería en Gestión Empresarial;
                                    Mtro. Daniel Hernández Pitalúa,
                                    Jefe de la División de la Carrera de Ingeniería Mecatrónica;
                                    Mtra. María Angélica Cerdán,
                                    Jefa de la División de la Carrera de Ingeniería Bioquímica;
                                    Mtra. Elsa Franco Alvarado,
                                    Jefa de la División de la Carrera de Ingeniería Civil;
                                    Prof. Técn. José Manuel Valdez Castro,
                                    Encargado de la División de la Carrera de la Licenciatura en Gastronomía;
                                    Mtra. Luz Aurora García Mathey, Jefa del Departamento de Ciencias Básicas;
                                    Lic. Patricia Guadalupe Carcaño Vernet,
                                    Jefa del Departamento de Estudios Profesionales,
                                    Mtra. Elizabeth Delfín Portela,
                                    Jefa del Departamento de Desarrollo Académico y la
                                    Mtra. Verónica Fabiola Libreros Morales,
                                    Jefa del Departamento de Control Escolar,
                                    todos ellos integrantes del Comité Académico del Instituto Tecnológico Superior de Xalapa, reunidos para dar inicio a la
                                    <?php
                                    // Get the current month
                                    $currentMonth = getCurrentMonth();

                                    // Generate and output the session string
                                    $sessionString = getSessionString($currentMonth);
                                    echo '<span">' . $sessionString . '.</span><br>';
                                    ?>
                                 </p>
                              </div>
                           </div>
                           <!-- SECTION FOR ROLL CALL -->
                           <div class="form-group">
                              <div class="col-sm-10">
                                 <p class="actaPBody">
                                    Se realiza el pase de lista, encontrándose presentes <input class="actaIn underline" type="number" id="NoMembers" name="NoMembers" min="1" max="17" placeholder="No." required> miembros y un invitado (<button type="button" class="btn btn-default" onclick="toggleInputs()" style="text-transform: initial;">Agregar información del invitado</button><span class="SPBold"><input class="optional" type="text" id="guest_fname" name="guest_fname" placeholder="Nombre completo"></span> <span class="SPBold"><input class="optional" type="text" id="guest_charge" name="guest_charge" placeholder="Cargo académico"></span>), se determina que
                                    existe quórum y da inicio a la
                                    <?php
                                    // Get the current month
                                    $currentMonth = getCurrentMonth();

                                    // Generate and output the session string
                                    $sessionString = getSessionString($currentMonth);
                                    echo '<span class="SPBold">' . $sessionString . '.</span><br>';
                                    echo '<p class="actaPBody">Lectura y proposición del orden el día:</p>';
                                    ?>
                                 </p>
                              </div>
                           </div>
                           <!-- SECTION LECTURE AND PROPOSITION -->
                           <div class="form-group">
                              <div class="col-sm-10">
                                 <p class="actaPBody">1. Análisis de solicitudes de alumnos:</p>
                                 <ul class="subText">
                                    <li>Solicitud con folio 001/2023</li>
                                    <li>Solicitud con folio 002/2023</li>
                                    <li>Solicitud con folio 003/2023</li>
                                    <li>Solicitud con folio 004/2023</li>
                                    <li>Solicitud con folio 005/2023</li>
                                    <li>Solicitud con folio 006/2023</li>
                                    <li>Solicitud con folio 007/2023</li>
                                 </ul>
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="col-sm-10">
                                 <p class="actaPBody">2. Aprobación del orden del día.</p>
                                 <p class="actaPBody">3. Asuntos Generales</p>
                                 <ul>
                                    <p class="actaPNormal">&#8226; AG1.- Se presenta por parte de la Dirección Académica en carácter informativo
                                       el caso extraordinario del alumno CEBALLOS SILVA JESÚS ALFREDO,
                                       con número de control 187002450, de la carrera de INGENIERÍA EN GESTIÓN EMPRESARIAL
                                    </p>
                                 </ul>
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="col-sm-10">
                                 <p class="actaPBody">
                                    Expuesto lo anterior, habiéndose sometido a votación y siendo aprobado por unanimidad el
                                    orden del día, se da inicio al análisis de solicitudes:
                                 </p>
                              </div>
                              <p class="PagFoot">Page 1</p>
                           </div>
                        </div>
                        <div class="page2 hide">
                           <div class="form-group">
                              <div class="col-sm-10">
                                 <div class="container my-4">
                                    <div class="card my-4 shadow">
                                       <div class="card-body">
                                          <fieldset>
                                             <!-- FORM TITLE -->
                                             <legend>Análisis de solicitudes de alumnos</legend>
                                             <div class="row" style="align-items: center;">
                                                <div class="col-md-10 dynamic-field" id="dynamic-field-1">
                                                   <div class="row">
                                                      <div class="col-md-4">
                                                         <div class="staresd">
                                                            <h4>Folio</h4>
                                                            <input id="folio" name="folio" type="text" class="form-control" placeholder="Solicitud con folio 00X/202X">
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="staresd">
                                                            <h4>Nombre del alumno</h4>
                                                            <input id="nomAlum" name="nomAlum" type="text" class="form-control" placeholder="Ingresa el nombre completo del alumno">
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="staresd">
                                                            <h4>No. Control del alumno</h4>
                                                            <input id="nCtrlAlum" name="nCtrlAlum" type="text" class="form-control" placeholder="Ingresa el No. Control del alumno">
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="staresd">
                                                            <h4>Asunto</h4>
                                                            <textarea id="asunto" name="asunto" class="form-control field" cols="40" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" placeholder="Se analiza la solicitud del C...."></textarea>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="staresd">
                                                            <h4>Recomendación</h4>
                                                            <textarea id="recomendacion" name="recomendacion" class="form-control field" cols="40" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" placeholder="Analizado el caso por el pleno..."></textarea>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="staresd">
                                                            <h4>Respuesta</h4>
                                                            <select id="resolucion" class="select" style="width: 100%;">
                                                               <i class="fa fa-angle-left pull-right"></i>
                                                               <option value="" disabled selected>Selecciona una respuesta</option>
                                                               <option value="Aceptado">Aceptado</option>
                                                               <option value="Rechazado">Rechazado</option>
                                                            </select>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-2 mt-30 append-buttons">
                                                <div class="clearfix">
                                                   <button type="button" id="add-button" class="btn btn-secondary float-left text-uppercase shadow-sm"><i class="fa fa-plus fa-fw"></i>
                                                   </button>
                                                   <button type="button" id="remove-button" class="btn btn-secondary float-left text-uppercase ml-1" disabled="disabled"><i class="fa fa-minus fa-fw"></i>
                                                   </button>
                                                </div>
                                             </div>
                                          </fieldset>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="col-sm-10">
                                 <div class="container my-4">
                                    <div class="card my-4 shadow">
                                       <div class="card-body">
                                          <fieldset>
                                             <!-- FORM TITLE -->
                                             <legend>Asuntos Generales</legend>
                                             <!-- Form items -->
                                             <div id="items" class="form-group">
                                             </div>
                                          </fieldset>
                                          <button id="add" class="btn add-more button-yellow uppercase" type="button"><i class="fa fa-plus-square" aria-hidden="true"></i> Añadir asunto general</button>
                                          <button class="delete btn button-white uppercase"><i class="fa fa-minus-square" aria-hidden="true"></i> Eliminar asunto</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <p class="PagFoot">Page 2</p>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- SECTION FOR BUTTONS -->
               <div class="form-group">
                  <div class="col-sm-10">
                     <div class="inner-basic division-map div-toggle" data-target=".division-details" id="divisiondetail">
                        <button id="save_changes" class="btnActa btn btn-primary">Guardar</button>
                        <div class="icon1">
                           <div id="prev-btn" class="arrow-left">
                              <span class="left"></span>
                              <span class="left"></span>
                              <span class="left"></span>
                           </div>
                        </div>
                        <div class="icon2">
                           <div id="next-btn" class="arrow-right">
                              <span class="right"></span>
                              <span class="right"></span>
                              <span class="right"></span>
                           </div>
                        </div>
                     </div>
                     <!-- end inner basic -->
                  </div>
               </div>
            </form>
         </div>
         <!-- END MODAL BODYA -->
         <div class="modal-footer">
            <img class="imgFooter" src="https://localhost/sistema-academico/public/img/FooterActa.png" alt="image-footer">
         </div>
      </div>
   </div>
   <!-- END MODAL ACTA iziToast -->
   <!-- Bower components -->
   <script type="text/javascript" src="<?= BASE_URL; ?>bower_components/jquery/dist/jquery.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>bower_components/raphael/raphael.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>bower_components/morris.js/morris.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>bower_components/moment/min/moment.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>bower_components/fastclick/lib/fastclick.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>js/chat.js"></script>
   <?php
   // Define an array of allowed usernames
   $allowedUsers = ['Director académico', 'Jefe de carrera', 'Secretario técnico'];
   if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
      // Display chart with data
      echo '<script type="text/javascript" src="' . BASE_URL . 'bower_components/chart/Chart.js"></script>';
      // Send comments
      echo '<script type="text/javascript" src="' . BASE_URL . 'ajax/senderC.js"></script>';
      // Send comments
      echo '<script type="text/javascript" src="' . BASE_URL . 'ajax/fetchC.js"></script>';
      // Fetch count fdc data
      echo '<script type="text/javascript" src="' . BASE_URL . 'ajax/fetchFDCData.js"></script>';
   }
   ?>
   <!-- Plugins -->
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/input-mask/jquery.inputmask.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
   <script type="text/javascript">
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
   <script type="text/javascript" src="<?= BASE_URL; ?>dist/js/adminlte.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>dist/js/BarChart.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>js/search.js"></script>
   <?php
   // Define an array of allowed usernames
   $allowedUsers = ['Jefe de carrera', 'Secretario'];
   if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
      echo '<script type="text/javascript" src="' . BASE_URL . 'dist/js/dashboard.js"></script>';
   }
   ?>
   <script type="text/javascript" src="<?= BASE_URL; ?>dist/js/demo.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>js/confirmLogout.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>js/sweetalert2.js"></script>
   <?php
   // Define an array of allowed usernames
   $allowedUsers = ['Jefe de carrera', 'Secretario'];
   if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
      echo '<script type="text/javascript" src="' . BASE_URL . 'ajax/ajaxUpdater.js"></script>';
   }
   ?>
   <?php
   // Define an array of allowed usernames
   $allowedUsers = ['Director académico', 'Secretario'];
   if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
      //echo '<script type="text/javascript" src="' . BASE_URL . 'ajax/tbActa.js"></script>';
   }
   ?>
   <!-- TABLES SCRIPT -->
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/DataTables-1.13.6/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/DataTables-1.13.6/js/dataTables.bootstrap4.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/Responsive-2.5.0/js/dataTables.responsive.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/buttons.bootstrap4.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/JSZip-3.10.1/jszip.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/pdfmake-0.2.7/pdfmake.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/pdfmake-0.2.7/vfs_fonts.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/buttons.html5.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/buttons.print.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/FixedColumns-4.3.0/js/fixedColumns.dataTables.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/datatables-select/js/dataTables.select.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/datatables-rowreorder/js/dataTables.rowReorder.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/datatables-editor/js/dataTables.editor.js"></script>
   <?php
   // Define an array of allowed usernames
   $allowedUsers = ['Secretario'];
   if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
      // Echo BASE_URL into JavaScript
      echo '<script type="text/javascript">var BASE_URL = "' . BASE_URL . '";</script>';
      // Datatable plugin
      echo '<script type="text/javascript" src="' . BASE_URL . 'ajax/DataTableS.js"></script>';
      // FDC notifications
      echo '<script type="text/javascript" src="' . BASE_URL . 'ajax/fdc_notifications.js"></script>';
      // Generate acta
      echo '<script type="text/javascript" src="' . BASE_URL . 'ajax/generate_acta.js"></script>';
      // Arrow function
      echo '<script type="text/javascript" src="' . BASE_URL . 'js/arrow.js"></script>';
      // Time picker
      echo '<script type="text/javascript" src="' . BASE_URL . 'plugins/timepicker/bootstrap-timepicker.min.js"></script>';
      // Mask inputs
      echo '<script type="text/javascript" src="' . BASE_URL . 'js/formatMask.js"></script>';
      // Append new elements to form (Requests)
      echo '<script type="text/javascript" src="' . BASE_URL . 'js/append.js"></script>';
      // Datatable modified for both acta and general requests
      echo '<script type="text/javascript" src="' . BASE_URL . 'ajax/asuntos_grals.js"></script>';
      echo '<script type="text/javascript" src="' . BASE_URL . 'js/new_datatable/tbActa.js"></script>';
   }
   ?>
   <?php
   // Define an array of allowed usernames
   $allowedUsers = ['Jefe de carrera'];
   if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
      // Echo BASE_URL into JavaScript
      echo '<script type="text/javascript">var BASE_URL = "' . BASE_URL . '";</script>';
      // Datatable plugin
      echo '<script type="text/javascript" src="' . BASE_URL . 'ajax/DataTableJ.js"></script>';
      echo '<script type="text/javascript" src="' . BASE_URL . 'js/checkedItems.js"></script>';
   }
   ?>
   <!-- END TABLES SCRIPT -->
   <script type="text/javascript" src="<?= BASE_URL; ?>js/custom_dropdown.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>js/upload_files.js"></script>
   <!-- iziToast JS plugins -->
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/iziToast/js/iziToast.min.js"></script>
   <script type="text/javascript" src="<?= BASE_URL; ?>plugins/iziModal/js/iziModal.min.js"></script>
   <!-- Time and date display script -->
   <script type="text/javascript" src="<?= BASE_URL; ?>js/display_time.js"></script>
</body>

</html>