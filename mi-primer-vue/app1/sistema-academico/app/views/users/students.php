<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <!-- Favicons -->
   <link href="<?php echo BASE_URL; ?>/img/favicon/favicon.ico" rel="icon">
   <link href="<?php echo BASE_URL; ?>/img/favicon/apple-touch-icon.png" rel="apple-touch-icon">
   <title>Student management</title>
   <!-- BOWER COMPONENTS CSS -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/fontawesome-free/css/all.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/ionicons-2.0.1/css/ionicons.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/jvectormap/jquery-jvectormap.css">
   <!-- STYLE TABLE -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/DataTables-1.13.6/css/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/Responsive-2.5.0/css/responsive.bootstrap4.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/DataTables-1.13.6/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/DataTables/datatables-select/css/select.bootstrap4.min.css">
   <!-- SWEETALERT2 CSS -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/sweetalert2.css">
   <!-- PLUGINS CSS -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
   <!-- Main Template -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>dist/css/skins/_all-skins.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>dist/css/AdminLTE.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/modal.css">
   <!-- Google Font: Source Sans Pro -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/customRegister.css">
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
         <a href="<?= BASE_URL; ?>" class="logo">
            <span class="logo-mini"><b>KA</b></span>
            <span class="logo-lg"><b>KA's </b>website</span>
         </a>
         <nav class="navbar navbar-static-top">
            <a href="index.html#" class="sidebar-toggle" data-toggle="push-menu" role="button">
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
                           echo '<img src="' . $imageUrl . '" class="user-image" alt="User Image">';
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
                              echo '<img src="' . $imageUrl . '" alt="User Image">';
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
                                 if ($userData["gender"] === "Masculino") {
                                    echo '<p class="customP">Secretario</p>';
                                 } else {
                                    echo '<p class="customP">Secretaria</p>';
                                 }
                              } else if ($userData['charge'] === 'Jefe de carrera') {
                                 if ($userData["gender"] === "Masculino") {
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
                              <button id="profileButton" class="btn btn-default">Profile</button>
                           </div>
                           <div class="pull-right">
                              <button class="btn btn-default" href="javascript:void(0);" onclick="confirmLogout()">Sign
                                 out</button>
                           </div>
                        </li>
                     </ul>
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
                     echo '<img src="' . $imageUrl . '" class="user-image" alt="User Image">';
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
                        <li><a href=""><i class="fa fa-circle text-success"></i>Online</a></li>
                        <li><a href=""><i class="fa fa-circle text-danger"></i>Offline</a></li>
                     </ul>
                  </div>
               </div>
            </div>
            <form action="index.html#" method="get" class="sidebar-form">
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
                     <li><a href="homepage"><i class="fa fa-home"></i>Home</a></li>
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
                        echo '<li class="active"><a href="' . BASE_URL . 'users/students"><i class="fa fa-graduation-cap"></i>Students</a></li>';
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
                     <li><a href="<?= BASE_URL; ?>profile/profile"><i class="fa fa-user"></i>Profile</a></li>
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
               <small>List of users</small>
            </h1>
            <ol class="breadcrumb">
               <li><a href="<?= BASE_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
               <li><a href="#">Table</a></li>
               <li class="active">Users</li>
            </ol>
         </section>
         <section class="content">
            <div class="row">
               <div class="col-xs-12">
                  <div class="box">
                     <div class="box-header">
                        <h3 class="box-title">Tabla con la lista de estudiantes creados</h3>
                     </div>
                     <div class="box-body">
                        <table id="example" class="content-table uk-table uk-table-hover uk-table-striped" style="width:100%">
                           <thead>
                              <tr>
                                 <th>#</th>
                                 <th>Username</th>
                                 <th>Carrera</th>
                                 <th>Género</th>
                                 <th>Acciones</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $displayedId = 1; // Initialize the displayed ID to 1
                              foreach ($data['students'] as $student) :
                              ?>
                                 <tr class="del_stud<?php echo $student->stud_id; ?>">
                                    <td>
                                       <?php echo $displayedId; ?>
                                    </td>
                                    <td>
                                       <?php echo $student->stud_username; ?>
                                    </td>
                                    <td>
                                       <?php echo $student->stud_career; ?>
                                    </td>
                                    <td>
                                       <?php echo $student->stud_gender; ?>
                                    </td>
                                    <td>
                                       <a style="display: inline;padding: 0px 10px;" class="btn btn-warning" data-toggle="modal" data-target="#editUser<?php echo $student->stud_id; ?>">Edit</a>
                                       <a style="display: inline;padding: 0px 10px;" class="btn btn-danger btn-delete" id="<?php echo $student->stud_id; ?>">Delete</a>
                                    </td>
                                 </tr>
                              <?php
                                 $displayedId++; // Increment the displayed ID for the next iteration
                              endforeach;
                              ?>
                           </tbody>
                        </table>
                        <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudM">Añadir nuevo estudiante</a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
      <!-- Modal add Student -->
      <div class="modal fade" id="addStudM" aria-hidden="true" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="cardC-title text-center pb-0 fs-4">Añadir un nuevo estudiante</h5>
               </div>
               <div class="modal-body">
                  <div class="cardC mb-3">
                     <div class="cardC-body box">
                        <br>
                        <p class="text-center small" style="font-size: inherit;">Ingresa los datos del estudiante</p>
                        <form id="addStudForm" class="row g-3 needs-validation" method="POST">
                           <div class="form-group">
                              <label for="nControl_stud" class="form-label">No. Control</label>
                              <input type="text" name="nControl_stud" class="form-control" id="nControl_stud" placeholder="Número de control con el formato XXXOXXXXX" required>
                              <div class="invalid-feedback">¡Por favor, ingrese el número de control del estudiante!
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="password_stud" class="form-label">Contraseña</label>
                              <input type="password" name="password_stud" class="form-control" id="password_stud" placeholder="Contraseña" required>
                              <div class="invalid-feedback">¡Por favor, ingrese la contraseña!</div>
                           </div>
                           <div class="form-group">
                              <span class="form-label">Carrera</span>
                              <div class="alert callout alert-warning alert-dismissible">
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                 <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alert!</h4>
                                 ¡No es necesario seleccionar este campo!
                              </div>
                              <div class="dropdownC" id="careerDropdown">
                                 <div class="select form-control" style="background-color: #dddddd;">
                                    <?php
                                    // Instantiate the User class
                                    $userModel = new User();
                                    // Get the user data by ID
                                    $userId = $_SESSION['id'];
                                    // Get the gender value from the model function
                                    $user = $userModel->getUserById($userId);
                                    ?>
                                    <span id="<?php echo $user->career; ?>">
                                       <?php echo $user->career; ?>
                                    </span>
                                    <i class="fa fa-chevron-left"></i>
                                 </div>
                                 <input type="hidden" name="stud_career" value="<?php echo $user->career; ?>">
                                 <ul class="dropdownC-menu">
                                    <li id="<?php echo $user->career; ?>"></li>
                                 </ul>
                              </div>
                           </div>
                           <div class="form-group">
                              <span class="form-label">Role</span>
                              <div class="alert callout alert-warning alert-dismissible">
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                 <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Alert!</h4>
                                 ¡No es necesario seleccionar este campo!
                              </div>
                              <div class="dropdownC" id="chargeDropdown">
                                 <div class="select form-control" style="background-color: #dddddd;">
                                    <span id="Estudiante">Estudiante</span>
                                    <i class="fa fa-chevron-left"></i>
                                 </div>
                                 <input type="hidden" name="stud_charge" value="Estudiante">
                                 <ul class="dropdownC-menu">
                                    <li id="Estudiante">Estudiante</li>
                                 </ul>
                              </div>
                           </div>
                           <div class="form-group">
                              <span class="form-label">Selecciona el género</span>
                              <div class="form-check">
                                 <div class="checkboxes__row">
                                    <div class="checkboxes__item">
                                       <label for="male" class="checkbox style-h">
                                          <input type="checkbox" id="male" name="stud_gender" value="Hombre" />
                                          <div class="checkbox__checkmark"></div>
                                          <div class="checkbox__body">Hombre</div>
                                       </label>
                                    </div>
                                    <div class="checkboxes__item">
                                       <label for="female" class="checkbox style-h">
                                          <input type="checkbox" id="female" name="stud_gender" value="Mujer" />
                                          <div class="checkbox__checkmark"></div>
                                          <div class="checkbox__body">Mujer</div>
                                       </label>
                                    </div>
                                    <div class="invalid-feedback">Por favor, selecciona el género!</div>
                                 </div>
                              </div>
                           </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" name="addStudent" class="btn btn-primary pull-left">Send</button>
                  <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Close</button>
               </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Modal edit Student -->
      <?php foreach ($data['students'] as $student) : ?>
         <div class="modal fade" id="editUser<?php echo $student->stud_id; ?>" aria-hidden="true" role="dialog">
            <div class="modal-dialog">
               <!-- Modal content-->
               <div class="modal-contentU">
                  <!-- Modal body -->
                  <div class="modal-body">
                     <div class="card mb-3">
                        <div class="cardC-body box">
                           <div class="pt-4 pb-2">
                              <h5 class="cardC-title text-center pb-0 fs-4">Edit</h5>
                              <p class="text-center">Introduzca los nuevos datos del estudiante</p>
                           </div>
                           <form id="updateStud<?php echo $student->stud_id; ?>" class="g-3 needs-validation" method="POST">
                              <div class="form-group">
                                 <input type="hidden" name="stud_id" value="<?php echo $student->stud_id; ?>" class="form-control" />
                              </div>
                              <div class="form-group">
                                 <label for="Update No. Contrl" class="form-label">Nuevo No. Control</label>
                                 <div class="input-group has-validation" style="width: 100%;">
                                    <input type="text" name="UpdateNctrStud" class="form-control" id="UpdateNctrStud<?php echo $student->stud_id; ?>" required value="<?php echo $student->stud_username; ?>">
                                    <div class="invalid-feedback">Please enter the new control number!</div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label for="Update password" class="form-label">Nueva contraseña</label>
                                 <input type="password" name="UpdatePasswdStud" class="form-control" id="UpdatePasswdStud<?php echo $student->stud_id; ?>" placeholder="Ingresa la nueva contraseña">
                                 <div class="invalid-feedback">Please enter the new password!</div>
                              </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" name="updateStudent" class="btn btn-primary pull-left">Send</button>
                     <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Close</button>
                  </div>
                  </form>
               </div>
            </div>
         </div>
      <?php endforeach; ?>
      <div class="modal fade" id="deleteStud" aria-hidden="true" role="dialog">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Alerta del sistema</h4>
               </div>
               <div class="modal-body">
                  <h3 class="text-danger">¿Está seguro de que desea eliminar los datos del estudiante seleccionado?</h3>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-success" id="btn_yes">Continuar</button>
               </div>
            </div>
         </div>
      </div>
      <footer class="main-footer">
         <div class="pull-right hidden-xs">
            <b>Version</b> 2.0
         </div>
         <strong>Copyright &copy; 2023-2024 <a href="">KA's website</a>.</strong> All rights
         reserved.
      </footer>
      <!-- Bower components -->
      <script src="<?= BASE_URL; ?>bower_components/jquery/dist/jquery.min.js"></script>
      <script src="<?= BASE_URL; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
      <script src="<?= BASE_URL; ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
      <script src="<?= BASE_URL; ?>bower_components/fastclick/lib/fastclick.js"></script>
      <!-- TABLES SCRIPT -->
      <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/DataTables-1.13.6/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/DataTables-1.13.6/js/dataTables.bootstrap4.min.js"></script>
      <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/Responsive-2.5.0/js/dataTables.responsive.min.js"></script>
      <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
      <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/buttons.bootstrap4.min.js"></script>
      <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/pdfmake-0.2.7/vfs_fonts.js"></script>
      <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/buttons.html5.min.js"></script>
      <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/buttons.print.min.js"></script>
      <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/Buttons-2.4.2/js/buttons.colVis.min.js"></script>
      <script type="text/javascript" src="<?= BASE_URL; ?>plugins/DataTables/FixedColumns-4.3.0/js/fixedColumns.dataTables.min.js"></script>
      <script type="text/javascript" src="<?= BASE_URL; ?>js/dataTable.js"></script>
      <!-- END TABLES SCRIPT -->
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
      <script src="<?= BASE_URL; ?>dist/js/adminlte.min.js"></script>
      <script src="<?= BASE_URL; ?>dist/js/dashboard.js"></script>
      <script src="<?= BASE_URL; ?>dist/js/demo.js"></script>
      <script src="<?= BASE_URL; ?>js/confirmLogout.js"></script>
      <script src="<?= BASE_URL; ?>js/sweetalert2.js"></script>
      <script src="<?= BASE_URL; ?>js/replace_uppercase.js"></script>
      <script src="<?= BASE_URL; ?>js/search.js"></script>
      <!-- PLUGINS -->
      <script src="<?= BASE_URL; ?>plugins/input-mask/jquery.inputmask.js"></script>
      <script src="<?= BASE_URL; ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
      <script src="<?= BASE_URL; ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
      <!-- DROPDOWN-MENU -->
      <script src="<?= BASE_URL; ?>js/dropdown_stud.js"></script>
      <!-- AJAX -->
      <script src="<?= BASE_URL; ?>ajax/newStudForm.js"></script>
      <script src="<?= BASE_URL; ?>ajax/upStudInfo.js"></script>
      <script src="<?= BASE_URL; ?>ajax/deleteStud.js"></script>
      <?php
      // Define an array of allowed usernames
      $allowedUsers = ['Secretario'];
      if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
         // Echo BASE_URL into JavaScript
         // FDC notifications
         echo '<script type="text/javascript" src="' . BASE_URL . 'ajax/fdc_notifications.js"></script>';
      }
      ?>
</body>

</html>