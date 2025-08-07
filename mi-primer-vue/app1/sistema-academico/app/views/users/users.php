<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <!-- Favicons -->
   <link href="<?= BASE_URL; ?>img/favicon/favicon.ico" rel="icon">
   <link href="<?= BASE_URL; ?>img/favicon/apple-touch-icon.png" rel="apple-touch-icon">
   <title>Users management</title>
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
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/customRegister.css">
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
         <a href="<?= BASE_URL; ?>" class="logo">
            <span class="logo-mini"><b>KA</b></span>
            <span class="logo-lg"><b>KA's </b>website</span>
         </a>
         <nav class="navbar navbar-static-top">
            <a href="" class="sidebar-toggle" data-toggle="push-menu" role="button">
               <i class="fas fa-bars"></i>
            </a>
            <div class="navbar-custom-menu">
               <ul class="nav navbar-nav">
               <?php
                        // Define an array of allowed usernames
                        $allowedUsers = ['Director académico', 'Jefe de carrera', 'Secretario'];
                        if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
                           $html = <<<HTML
                        <li class="dropdown messages-menu">
                        <a href="index.html#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="far fa-comments"></i>
                        <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                        <ul class="menu">
                          <li>
                              <a href="index.html#">
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
                          <li>
                              <a href="index.html#">
                                  <div class="pull-left">
                                      <img src="../dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                  </div>
                                  <h4>
                                      AdminLTE Design Team
                                      <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                  </h4>
                                  <p>Why not buy a new awesome theme?</p>
                              </a>
                          </li>
                          <li>
                              <a href="index.html#">
                                  <div class="pull-left">
                                      <img src="../dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                  </div>
                                  <h4>
                                      Developers
                                      <small><i class="fa fa-clock-o"></i> Today</small>
                                  </h4>
                                  <p>Why not buy a new awesome theme?</p>
                              </a>
                          </li>
                          <li>
                              <a href="index.html#">
                                  <div class="pull-left">
                                      <img src="../dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                  </div>
                                  <h4>
                                      Sales Department
                                      <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                  </h4>
                                  <p>Why not buy a new awesome theme?</p>
                              </a>
                          </li>
                          <li>
                              <a href="index.html#">
                                  <div class="pull-left">
                                      <img src="../dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                  </div>
                                  <h4>
                                      Reviewers
                                      <small><i class="fa fa-clock-o"></i> 2 days</small>
                                  </h4>
                                  <p>Why not buy a new awesome theme?</p>
                              </a>
                          </li>
                        </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
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
                              } else if ($user->gender === 'Mujer') {
                                 echo '<img src="' . BASE_URL . 'img/avatars/female.png" alt="User Image">';
                              } else {
                                 echo '<img src="' . BASE_URL . 'img/avatars/student.png" alt="User image"">';
                              }
                           }
                           ?>
                           <?php
                           $user = new User();
                           $userData = $user->getUserNameAndRegistrationDateForSession();

                           if ($userData) {
                              echo '<p class="customP">' . ucfirst(htmlspecialchars($userData['name'])) . '</p>';
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
                        <li><a href=""><i class="fa fa-circle text-success"></i>Online</a></li>
                        <li><a href=""><i class="fa fa-circle text-danger"></i>Offline</a></li>
                     </ul>
                  </div>
               </div>
            </div>
            <form action="" method="get" class="sidebar-form">
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
                        echo '<li class="active"><a href="'. BASE_URL. 'users/users"><i class="fa fa-users"></i>Users</a></li>';
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
                     <li><a href="<?php echo BASE_URL; ?>profile/profile"><i class="fa fa-user"></i>Profile</a></li>
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
                        <h3 class="box-title">Tabla de datos con lista de usuarios creados</h3>
                     </div>
                     <div class="box-body">
                        <table id="example" class="content-table uk-table uk-table-hover uk-table-striped" style="width:100;">
                           <thead>
                              <tr>
                                 <th>#</th>
                                 <th>Name</th>
                                 <th>Email</th>
                                 <th>Username</th>
                                 <th>Cargo</th>
                                 <th>Acciones</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $displayedId = 1; // Initialize the displayed ID to 1
                              foreach ($data['users'] as $user) :
                                 // Skip the user with the charge "Academic director"
                                 if ($user->charge === 'Director académico') {
                                    continue;
                                 }
                              ?>
                                 <tr class="del_user<?php echo $user->id; ?>">
                                    <td>
                                       <?php echo $displayedId; ?>
                                    </td>
                                    <td>
                                       <?php echo $user->firstname; ?>
                                    </td>
                                    <td>
                                       <?php echo $user->email; ?>
                                    </td>
                                    <td>
                                       <?php echo $user->username; ?>
                                    </td>
                                    <td>
                                       <?php echo $user->charge; ?>
                                    </td>
                                    <td>
                                       <a style="display: inline; padding: 0px 10px;" class="btn btn-warning btn-edit" id="<?php echo $user->id; ?>">Editar</a>
                                       <a style="display: inline; padding: 0px 10px;" class="btn btn-danger btn-delete" id="<?php echo $user->id; ?>">Eliminar</a>
                                    </td>
                                 </tr>
                              <?php
                                 $displayedId++; // Increment the displayed ID for the next iteration
                              endforeach;
                              ?>
                           </tbody>
                        </table>
                        <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUser">Añadir nuevo usuario</a>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
      <!-- Modal add User -->
      <div class="modal fade" id="addUser" aria-hidden="true" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="cardC-title text-center pb-0 fs-4">Añadir un nuevo usuario</h5>
               </div>
               <div class="modal-body">
                  <div class="cardC mb-3">
                     <div class="cardC-body box">
                        <div class="pt-4 pb-2">
                           <br>
                           <p class="text-center small" style="font-size: inherit;">Ingresa los datos del nuevo usuario
                           </p>
                        </div>
                        <form id="newUserForm" class="row g-3 needs-validation" method="POST">
                           <div class="form-group">
                              <label for="Name" class="form-label">Nombre</label>
                              <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Introduzca un nombre" required>
                              <div class="invalid-feedback">¡Por favor, introduzca su nombre!</div>
                           </div>
                           <div class="form-group">
                              <label for="Email" class="form-label">Email</label>
                              <input type="email" name="email" class="form-control" id="email" placeholder="Introduzca una dirección de correo electrónico válida" required>
                              <div class="invalid-feedback">¡Por favor, introduzca una dirección de correo electrónico válida!</div>
                           </div>
                           <div class="form-group">
                              <label for="Username" class="form-label">Nombre de usuario</label>
                              <input type="text" name="username" class="form-control" id="username" placeholder="Introduzca un nombre de usuario" required>
                              <div class="invalid-feedback">¡Por favor, elija un nombre de usuario!</div>
                           </div>
                           <div class="form-group">
                              <label for="Password" class="form-label">Contraseña</label>
                              <input type="password" name="password" class="form-control" id="password" placeholder="Introduzca una contraseña" required>
                              <div class="invalid-feedback">¡Por favor, introduzca su contraseña!</div>
                           </div>
                           <div class="form-group">
                              <label for="Charge" class="form-label">Elija el cargo</label>
                              <div class="alert callout alert-warning alert-dismissible">
                                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                 <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>¡Alerta!</h4>
                                 ¡Algunos cargos únicamente pueden ser seleccionados una vez!
                              </div>
                              <div class="dropdownC" id="chargeDropdown">
                                 <div class="select form-control">
                                    <span>Elija un cargo</span>
                                    <i class="fa fa-chevron-left"></i>
                                 </div>
                                 <input type="hidden" name="charge">
                                 <?php
                                 // Instantiate the User class
                                 $new_user = new User();
                                 // Get the users from the model
                                 $users = $new_user->getUsers();

                                 // Create an array to store the charge of each user
                                 $userCharges = [];

                                 // Loop through the users and store their charges in the $userCharges array
                                 foreach ($users as $user) {
                                    $userCharges[$user->id] = $user->charge;
                                 }

                                 echo '<ul class="dropdownC-menu">';
                                 foreach (['Director académico', 'Secretario técnico', 'Jefe de carrera', 'Secretario'] as $charge) {
                                    // Check if the charge is "Jefe de carrera" or "Secretario"
                                    $isSpecialCharge = in_array($charge, ['Jefe de carrera', 'Secretario']);

                                    // Check if there is a user with the specified charge
                                    $isChargeExist = in_array($charge, $userCharges);

                                    // Display the option only if there is no user with the specified charge or if it's a special charge
                                    if (!$isChargeExist || $isSpecialCharge) {
                                       echo '<li id="' . htmlspecialchars($charge) . '">';
                                       echo htmlspecialchars($charge);
                                       echo '</li>';
                                    }
                                 }
                                 echo '</ul>';
                                 ?>
                              </div>
                              <span class="msg"></span>
                           </div>
                           <div class="showC form-group">
                              <label for="Career" class="form-label">Carrera</label>
                              <div class="dropdownEditC" id="careerDropdown">
                                 <div class="select form-control">
                                    <span>
                                       Selecciona una carrera
                                    </span>
                                    <i class="fa fa-chevron-left"></i>
                                 </div>
                                 <input type="hidden" name="career">
                                 <ul class="dropdownEditC-menu">
                                    <li class="career" id="Ingeniería Industrial">Ingeniería
                                       Industrial</li>
                                    <li class="career" id="Ingeniería en Gestión Empresarial">
                                       Ingeniería en Gestión
                                       Empresarial</li>
                                    <li class="career" id="Ingeniería en Sistemas Computacionales">
                                       Ingeniería en
                                       Sistemas Computacionales</li>
                                    <li class="career" id="Ingeniería en Electrónica">
                                       Ingeniería
                                       en
                                       Electrónica</li>
                                    <li class="career" id="Ingeniería Electromecánica">
                                       Ingeniería
                                       Electromecánica
                                    </li>
                                    <li class="career" id="Ingeniería en Industrias Alimentarias">
                                       Ingeniería en
                                       Industrias Alimentarias</li>
                                    <li class="career" id="Ingeniería Bioquímica">Ingeniería
                                       Bioquímica</li>
                                    <li class="career" id="Ingeniería Mecatrónica">
                                       Ingeniería
                                       Mecatrónica</li>
                                    <li class="career" id="Ingeniería Civil">Ingeniería
                                       Civil
                                    </li>
                                    <li class="career" id="Licenciatura en Gastronomía">
                                       Licenciatura
                                       en Gastronomía
                                    </li>
                                 </ul>
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="Genre" class="form-label">Selecciona el género</label>
                              <div class="form-check gender">
                                 <label class="containerR form-check-label">
                                    <input type="radio" class="form-check-input" id="male" name="gender" value="Hombre">Hombre
                                    <span class="checkmark"></span>
                                 </label>
                                 <label class="containerR form-check-label">
                                    <input type="radio" class="form-check-input" id="female" name="gender" value="Mujer">Mujer
                                    <span class="checkmark"></span>
                                 </label>
                              </div>
                           </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" id="addNUser" class="btn btn-primary pull-left">Send</button>
                  <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Close</button>
               </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Modal edit User -->
      <?php foreach ($data['users'] as $user) : ?>
         <div class="modal fade" id="editUser<?php echo $user->id; ?>" aria-hidden="true" role="dialog">
            <div class="modal-dialog">
               <!-- Modal content-->
               <div class="modal-contentU">
                  <!-- Modal header -->
                  <div class="modal-header">
                     <h5 class="cardC-title text-center pb-0 fs-4">Editar información del usuario</h5>
                  </div>
                  <!-- Modal body -->
                  <div class="modal-body">
                     <div class="card mb-3">
                        <div class="cardC-body">
                           <div class="pt-4 pb-2">
                              <p class="text-center small">Ingresa los nuevos datos del usuario</p>
                           </div>
                           <!-- Opening form tag -->
                           <form id="updateUser<?php echo $user->id; ?>" class="g-3 needs-validation" method="POST">
                              <div class="form-group">
                                 <label for="UpdateName" class="form-label">Nombre</label>
                                 <input type="text" name="UpdateName" class="form-control" id="UpdateName<?php echo $user->id; ?>" required value="<?php echo $user->firstname; ?>" placeholder="Introduzca el nombre">
                                 <div class="invalid-feedback">Por favor, introduzca un nombre válido que contenga sólo letras</div>
                              </div>
                              <div class="form-group">
                                 <label for="UpdateEmail" class="form-label">Correo electrónico</label>
                                 <input type="email" name="UpdateEmail" class="form-control" id="UpdateEmail<?php echo $user->id; ?>" required value="<?php echo $user->email; ?>" placeholder="Introduzca el correo">
                                 <div class="invalid-feedback">Por favor, introduzca una dirección de correo electrónico válida</div>
                              </div>
                              <div class="form-group">
                                 <label for="UpdateUsername" class="form-label">Nombre de usuario</label>
                                 <div class="input-group has-validation" style="width: 100%;">
                                    <input type="text" name="UpdateUsername" class="form-control" id="UpdateUsername<?php echo $user->id; ?>" required value="<?php echo $user->username; ?>" placeholder="Introduzca un nombre de usuario">
                                    <div class="invalid-feedback">Please choose a username.</div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label for="currentPassword" class="form-label">Contraseña actual</label>
                                 <input type="password" name="currentPassword" class="form-control" id="currentPassword<?php echo $user->id; ?>" required placeholder="Introduzca la contraseña actual">
                                 <div class="invalid-feedback">Please enter your password!</div>
                              </div>
                              <div class="form-group">
                                 <label for="NewPassword" class="form-label">Nueva contraseña</label>
                                 <input type="password" name="NewPassword" class="form-control" id="NewPassword<?php echo $user->id; ?>" placeholder="Introduzca la nueva contraseña">
                                 <div class="invalid-feedback">Please enter your new password optional!</div>
                              </div>
                              <div class="form-group">
                                 <span class="form-label" style="font-weight: 700;">Cargo</span>
                                 <div class="dropdownEditU">
                                    <div class="select form-control">
                                       <span>
                                          <?php echo isset($user->charge) ? $user->charge : 'Seleccion cargo'; ?>
                                       </span>
                                       <i class="fa fa-chevron-left"></i>
                                    </div>
                                    <input id="Updatecharge<?php echo $user->id; ?>" type="hidden" name="Updatecharge" value="<?php echo $user->charge; ?>">
                                    <?php
                                    // Instantiate the User class
                                    $new_user = new User();
                                    // Get the users from the model
                                    $users = $new_user->getUsers();

                                    // Create an array to store the charge of each user
                                    $userCharges = [];

                                    // Loop through the users and store their charges in the $userCharges array
                                    foreach ($users as $user) {
                                       $userCharges[$user->id] = $user->charge;
                                    }

                                    echo '<ul class="dropdownEditU-menu">';
                                    foreach (['Director académico', 'Secretario técnico', 'Jefe de carrera', 'Secretario'] as $charge) {
                                       // Check if the charge is "Jefe de carrera" or "Secretario"
                                       $isSpecialCharge = in_array($charge, ['Jefe de carrera', 'Secretario']);

                                       // Check if there is a user with the specified charge
                                       $isChargeExist = in_array($charge, $userCharges);

                                       // Display the option only if there is no user with the specified charge or if it's a special charge
                                       if (!$isChargeExist || $isSpecialCharge) {
                                          echo '<li id="' . htmlspecialchars($charge) . '">';
                                          echo htmlspecialchars($charge);
                                          echo '</li>';
                                       }
                                    }
                                    echo '</ul>';
                                    ?>
                                 </div>
                              </div>
                              <div class="showEditC form-group">
                                 <span class="form-label" style="font-weight: 700;">Carrera</span>
                                 <div class="dropdownEditC">
                                    <div class="select form-control">
                                       <span>
                                          <?php echo isset($user->career) ? $user->career : 'Selecciona una carrera'; ?>
                                       </span>
                                       <i class="fa fa-chevron-left"></i>
                                    </div>
                                    <input id="Updatecareer<?php echo $user->id; ?>" type="hidden" name="Updatecareer" value="<?php echo $user->career; ?>">
                                    <ul class="dropdownEditC-menu">
                                       <li id="Ingeniería Industrial">
                                          Ingeniería Industrial
                                       </li>
                                       <li id="Ingeniería en Gestión Empresarial">
                                          Ingeniería en Gestión Empresarial
                                       </li>
                                       <li id="Ingeniería en Sistemas Computacionales">
                                          Ingeniería en Sistemas Computacionales
                                       </li>
                                       <li id="Ingeniería en Electrónica">
                                          Ingeniería en Electrónica
                                       </li>
                                       <li id="Ingeniería Electromecánica">
                                          Ingeniería Electromecánica
                                       </li>
                                       <li id="Ingeniería en Industrias Alimentarias">
                                          Ingeniería en Industrias Alimentarias
                                       </li>
                                       <li id="Ingeniería Bioquímica">
                                          Ingeniería Bioquímica
                                       </li>
                                       <li id="Ingeniería Mecatrónica">
                                          Ingeniería Mecatrónica
                                       </li>
                                       <li id="Ingeniería Civil">
                                          Ingeniería Civil
                                       </li>
                                       <li id="Licenciatura en Gastronomía">
                                          Licenciatura en Gastronomía
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label for="EditGenre" class="form-label">Género</label>
                                 <div class="form-check">
                                    <label class="containerR">
                                       <input id="Updategender<?php echo $user->id; ?>" type="radio" name="Updategender" value="Hombre" <?php echo ($user->gender === 'Hombre') ? 'checked' : ''; ?>>Hombre
                                       <span class="checkmark"></span>
                                    </label>
                                    <label class="containerR">
                                       <input id="Updategender<?php echo $user->id; ?>" type="radio" name="Updategender" value="Mujer" <?php echo ($user->gender === 'Mujer') ? 'checked' : ''; ?>>Mujer
                                       <span class="checkmark"></span>
                                    </label>
                                 </div>
                              </div>
                        </div>
                     </div>
                  </div>
                  <!-- Modal footer -->
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-primary pull-left" id="btn_send">Enviar</button>
                     <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Cerrar</button>
                  </div>
                  </form>
                  <!-- Closing form tag -->
               </div>
            </div>
         </div>
      <?php endforeach; ?>
      <div class="modal fade" id="deleteUser" aria-hidden="true" role="dialog">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Alerta del sistema</h4>
               </div>
               <div class="modal-body">
                  <h3 class="text-danger">¿Está seguro de que desea eliminar estos datos?</h3>
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
      <script src="<?= BASE_URL; ?>plugins/input-mask/jquery.inputmask.js"></script>
      <script src="<?= BASE_URL; ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
      <script src="<?= BASE_URL; ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
      <!-- DROPDOWN-MENU -->
      <script src="<?= BASE_URL; ?>js/drop-menuUser.js"></script>
      <script src="<?= BASE_URL; ?>js/dropdw_edituser.js"></script>
      <!-- END DROPDOWN -->
      <script src="<?= BASE_URL; ?>ajax/newUserForm.js"></script>
      <script src="<?= BASE_URL; ?>ajax/update_user.js"></script>
      <script src="<?= BASE_URL; ?>ajax/deleteUser.js"></script>
      <script src="<?= BASE_URL; ?>js/search.js"></script>
</body>

</html>