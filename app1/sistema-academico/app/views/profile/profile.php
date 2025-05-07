<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <title>User Profile</title>
   <!-- FAVICONS -->
   <link href="<?= BASE_URL; ?>img/favicon/favicon.ico" rel="icon">
   <link href="<?= BASE_URL; ?>img/favicon/apple-touch-icon.png" rel="apple-touch-icon">
   <!-- END FAVICONS -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/fontawesome-free/css/all.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/ionicons-2.0.1/css/ionicons.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/croppie-2.6.5/croppie.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/customRegister.css">
   <!-- SWEETALERT2 CSS -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/sweetalert2.css">
   <!-- END SWEETALERT2 -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>dist/css/AdminLTE.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>dist/css/skins/_all-skins.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/modal.css">
   <!-- iziToast css plugins -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/iziToast/css/iziToast.min.css">
   <!-- GOOGLE FONTS -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
                              <a href="<?= BASE_URL; ?>profile/profile" class="btn btn-default">Profile</a>
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
                     echo '<img src="' . $imageUrl . '" class="img-circle" alt="User Image">';
                  } else {
                     // Set a default image profile if it is not available
                     if ($user->gender === 'Hombre') {
                        echo '<img src="' . BASE_URL . 'img/avatars/male.png" class="img-circle" alt="User Image">';
                     } else {
                        echo '<img src="' . BASE_URL . 'img/avatars/female.png" class="img-circle" alt="User Image">';
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
               <li class="treeview">
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
                        echo '<li><a href="' . BASE_URL . 'users/students"><i class="fa fa-graduation-cap"></i>Students</a></li>';
                     }
                     ?>
                  </ul>
               </li>
               <li class="active treeview">
                  <a href="#">
                     <i class="fa fa-cog"></i> <span>Settings</span>
                     <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                     </span>
                  </a>
                  <ul class="treeview-menu">
                     <li class="active"><a href="<?= BASE_URL; ?>profile/profile"><i class="fa fa-user"></i>Profile</a></li>
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
               User Profile
            </h1>
            <ol class="breadcrumb">
               <li><a href="<?= BASE_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
               <li class="active">Profile</li>
               <li class="active">User profile</li>
            </ol>
         </section>
         <section class="content">
            <div class="row">
               <div class="col-md-9">
                  <div class="nav-tabs-custom">
                     <ul class="nav nav-tabs">
                        <li class="active"><a href="profile#settings" data-toggle="tab">Settings</a></li>
                     </ul>
                     <div class="tab-content">
                        <div class="active tab-pane" id="settings">
                           <form accept-charset="UTF-8" enctype="multipart/form-data" id="formUserInfo" class="form-horizontal" method="post">
                              <div class="box-body box-profile form-group">
                                 <div class="col-md-12">
                                    <div class="confirm-identity">
                                       <div class="ci-user d-flex align-items-center justify-content-center">
                                          <div class="ci-user-picture">
                                             <?php
                                             // Instantiate the User class
                                             $userModel = new User();

                                             // Get the user data by ID
                                             $userId = $_SESSION['id'];

                                             // Get the user's image data for the current session
                                             $imageUrl = $userModel->getUserImageForSession();

                                             if ($imageUrl) {
                                                echo '<img src="' . $imageUrl  . '" id="item-img-output" class="imgpreviewPrf img-fluid img-circle profile-user-img img-responsive" alt="User Image">';
                                             } else {
                                                // Set a default image profile if it is not available
                                                if ($user->gender === 'Hombre') {
                                                   echo '<img src="' . BASE_URL . 'img/avatars/male.png" id="item-img-output" class="imgpreviewPrf img-fluid img-circle profile-user-img img-responsive" alt="User Image">';
                                                } else {
                                                   echo '<img src="' . BASE_URL . 'img/avatars/female.png" id="item-img-output" class="imgpreviewPrf img-fluid img-circle profile-user-img img-responsive" alt="User Image">';
                                                }
                                             }
                                             ?>
                                          </div>
                                       </div>
                                       <div class="ci-user-btn text-center mt-4">
                                          <a href="javascript:;" class="userEditeBtn btn-default bg-blue position-relative">
                                             <input name="profile_picture" id="fileSelect" type="file" class="item-img file center-block filepreviewprofile">
                                             Update Profile Photo
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="modal fade cropImageModal" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-body p-0">
                                             <div class="modal-header-bg"></div>
                                             <div class="up-photo-title">
                                                <h3 class="modal-title">Update Profile Photo</h3>
                                             </div>
                                             <div class="up-photo-content pb-5">
                                                <div id="upload-demo" class="center-block">
                                                   <h5><i class="fas fa-arrows-alt mr-1"></i> Drag your photo as you
                                                      require
                                                   </h5>
                                                </div>
                                                <div class="upload-action-btn text-center px-2">
                                                   <button type="button" id="cropImageBtn" class="btn btn-default btn-medium bg-blue px-3 mr-2">Save
                                                      Photo</button>
                                                   <button type="button" class="btn btn-default btn-medium bg-default-light px-3 ml-sm-2 replacePhoto position-relative">Replace
                                                      Photo</button>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <p class="text-muted text-center">Información personal</p>
                                 <?php $user = $data['user_info']; ?>
                                 <ul class="list-group list-group-unbordered">
                                    <!-- FIELDS FOR PERSONAL INFORMATION UPDATE -->
                                    <li class="list-group-item">
                                       <label for="firstname" class="control-label">
                                          <b>Nombre:</b>
                                       </label>
                                       <a>
                                          <input name="firstname" id="firstname" class="uProfile" type="text" readonly value="<?php echo $user->firstname; ?>" placeholder="Ingresa tu nombre">
                                       </a>
                                    </li>
                                    <li class="list-group-item">
                                       <label for="flastname" class="control-label">
                                          <b>Primer apellido:</b>
                                       </label>
                                       <a>
                                          <input name="flastname" id="flastname" class="uProfile" type="text" readonly value="<?php echo $user->flastname; ?>" placeholder="Ingresa tu primer apellido">
                                       </a>
                                    </li>
                                    <li class="list-group-item">
                                       <label for="slastname" class="control-label">
                                          <b>Segundo apellido:</b>
                                       </label>
                                       <a>
                                          <input name="slastname" id="slastname" class="uProfile" type="text" readonly value="<?php echo $user->slastname; ?>" placeholder="Ingresa segundo apellido">
                                       </a>
                                    </li>
                                    <li class="list-group-item">
                                       <label for="email" class="control-label">
                                          <b>Correo electrónico:</b>
                                       </label>
                                       <a>
                                          <input name="email" id="email" class="uProfile" type="email" readonly value="<?php echo $user->email; ?>" placeholder="Ingresa un correo institucional">
                                       </a>
                                    </li>
                                    <li class="list-group-item">
                                       <label for="current_passwd" class="control-label">
                                          <b>Contraseña actual:</b>
                                       </label>
                                       <a>
                                          <input name="current_passwd" id="current_passwd" class="uProfile" type="password" readonly placeholder="Ingresa la contraseña actual">
                                       </a>
                                    </li>
                                    <li class="list-group-item">
                                       <label for="new_passwd" class="control-label">
                                          <b>Ingresa la nueva contraseña:</b>
                                       </label>
                                       <a>
                                          <input name="new_passwd" id="new_passwd" class="uProfile" type="password" readonly placeholder="Ingresa una nueva contraseña">
                                       </a>
                                    </li>
                                    <li class="list-group-item">
                                       <label for="confirm_passwd" class="control-label">
                                          <b>Confirma la nueva contraseña:</b>
                                       </label>
                                       <a>
                                          <input name="confirm_passwd" id="confirm_passwd" class="uProfile" type="password" readonly placeholder="Confirma la nueva contraseña">
                                       </a>
                                    </li>
                                    <li class="list-group-item">
                                       <label for="gender" class="control-label">
                                          <b>Género:</b>
                                       </label>
                                       <a>
                                          <div class="form-check">
                                             <label class="containerR form-check-label">
                                                <input type="radio" class="form-check-input" id="male" name="gender" value="Hombre" <?php echo ($user->gender === 'Hombre') ? 'checked' : ''; ?>>Hombre
                                                <span class="checkmark"></span>
                                             </label>
                                             <label class="containerR form-check-label">
                                                <input type="radio" class="form-check-input" id="female" name="gender" value="Mujer" <?php echo ($user->gender === 'Mujer') ? 'checked' : ''; ?>>Mujer
                                                <span class="checkmark"></span>
                                             </label>
                                          </div>
                                       </a>
                                    </li>
                                    <?php
                                    $userData = $data['user_info'];
                                    // Define an array of allowed usernames
                                    $allowedUsers = ['Jefe de carrera', 'Secretario'];
                                    if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
                                       $html = <<<HTML
                                          <li class="list-group-item">
                                             <label for="career" class="control-label">
                                                <b>Carrera:</b>
                                             </label>
                                             <a>
                                                <div class="dropdownEditC" id="careerDropdown">
                                                   <div class="select form-control">
                                                      <span>
                                                         $userData->career
                                                      </span>
                                                      <i class="fa fa-chevron-left"></i>
                                                   </div>
                                                   <input type="hidden" name="career" value="$user->career">
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
                                             </a>
                                          </li>
                                          HTML;
                                       echo $html;
                                    }
                                    ?>
                                 </ul>
                                 <button type="button" id="savebutton" class="btn btn-primary btn-block"><b>Edit</b></button>
                                 <button type="submit" class="btn btn-primary btn-block"><b>Send</b></button>
                              </div>
                        </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
      <footer class="main-footer">
         <div class="pull-right hidden-xs">
            <b>Version</b> 2.0
         </div>
         <strong>Copyright &copy; 2023-2024 <a href="">KA's website</a>.</strong> All rights reserved.
      </footer>
   </div>
   <!-- MAIN JS -->
   <script src="<?= BASE_URL; ?>bower_components/jquery/dist/jquery.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/fastclick/lib/fastclick.js"></script>
   <script src="<?= BASE_URL; ?>js/confirmLogout.js"></script>
   <script src="<?= BASE_URL; ?>js/sweetalert2.js"></script>
   <script src="<?= BASE_URL; ?>js/croppie-2.6.5/croppie.min.js"></script>
   <script src="<?= BASE_URL; ?>dist/js/adminlte.min.js"></script>
   <script src="<?= BASE_URL; ?>dist/js/demo.js"></script>
   <script src="<?= BASE_URL; ?>js/search.js"></script>
   <!-- iziToast JS plugins -->
   <script src="<?= BASE_URL; ?>plugins/iziToast/js/iziToast.min.js"></script>
   <?php
   // Define an array of allowed usernames
   $allowedUsers = ['Director académico', 'Jefe de carrera', 'Secretario técnico', 'Secretario'];
   if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
      // DROPDOWN-MENU
      echo '<script src="' . BASE_URL . 'js/control.js"></script>';
   }
   ?>
   <?php
   // Define an array of allowed usernames
   $allowedUsers = ['Director académico', 'Jefe de carrera', 'Secretario técnico', 'Secretario'];
   if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
      // Update user info
      echo '<script src="' . BASE_URL . 'ajax/saveInfo.js"></script>';
   }
   ?>
   <?php
   // Define an array of allowed usernames
   $allowedUsers = ['Secretario'];
   if (isset($_SESSION['charge']) && in_array($_SESSION['charge'], $allowedUsers)) {
      // Echo BASE_URL into JavaScript
      // FDC notifications
      echo '<script type="text/javascript" src="' . BASE_URL . 'ajax/fdc_notifications.js"></script>';
   }
   ?>
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
   <script src="https://kit.fontawesome.com/8a7f47aa91.js" crossorigin="anonymous"></script>
</body>

</html>