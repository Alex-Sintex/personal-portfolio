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
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/fontawesome-free/css/fontawesome.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>bower_components/ionicons-2.0.1/css/ionicons.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/croppie-2.6.5/croppie.css">
   <!-- SWEETALERT2 CSS -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/sweetalert2.css">
   <!-- END SWEETALERT2 -->
   <!-- iziToast CSS PLUGIN -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>plugins/iziToast/css/iziToast.min.css">
   <!-- END iziToast -->
   <link rel="stylesheet" href="<?= BASE_URL; ?>dist/css/AdminLTE.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>dist/css/skins/_all-skins.min.css">
   <link rel="stylesheet" href="<?= BASE_URL; ?>css/modal.css">
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
         <a href="../../index2.html" class="logo">
            <span class="logo-mini"><b>KA</b></span>
            <span class="logo-lg"><b>KA's </b>website</span>
         </a>
         <nav class="navbar navbar-static-top">
            <a href="index#" class="sidebar-toggle" data-toggle="push-menu" role="button">
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
               <div class="input-group" data-widget="sidebar-search">
                  <input type="text" name="q" class="form-control" placeholder="Search...">
                  <span class="input-group-btn">
                     <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                        <i class="fa fa-search"></i>
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
                     <li><a href="<?= BASE_URL; ?>student/student"><i class="fa fa-home"></i>Home</a></li>
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
                     <li class="active"><a href="<?= BASE_URL; ?>profile/account"><i class="fa fa-user"></i>Profile</a></li>
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
                           <form enctype="multipart/form-data" id="formRegisterStud" class="form-horizontal" method="post">
                              <div class="box-body box-profile form-group">
                                 <div class="col-md-12">
                                    <div class="confirm-identity">
                                       <div class="ci-user d-flex align-items-center justify-content-center">
                                          <div class="ci-user-picture">
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
                                                echo '<img src="' . $imageUrl  . '" id="item-img-output" class="imgpreviewPrf img-fluid img-circle profile-user-img img-responsive" alt="User Image">';
                                             } else {
                                                // Set a default image profile if it is not available
                                                if ($user->stud_gender === 'Hombre') {
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
                                                      require</h5>
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
                                 <?php $student = $data['student']; ?>
                                 <ul class="list-group list-group-unbordered">
                                    <!-- FIELDS FOR PERSONAL INFORMATION UPDATE -->
                                    <li class="list-group-item">
                                       <label for="Nombre" class="control-label">
                                          <b>Nombre:</b>
                                       </label>
                                       <a>
                                          <input name="stud_firstname" id="stud_firstname" class="uProfile" type="text" readonly value="<?php echo $student->stud_firstname; ?>" placeholder="Ingresa tu nombre">
                                       </a>
                                    </li>
                                    <li class="list-group-item">
                                       <label for="PApellido" class="control-label">
                                          <b>Primer apellido:</b>
                                       </label>
                                       <a>
                                          <input name="stud_flastname" id="stud_flastname" class="uProfile" type="text" readonly value="<?php echo $student->stud_flastname; ?>" placeholder="Ingresa primer apellido">
                                       </a>
                                    </li>
                                    <li class="list-group-item">
                                       <label for="SApellido" class="control-label">
                                          <b>Segundo apellido:</b>
                                       </label>
                                       <a>
                                          <input name="stud_slastname" id="stud_slastname" class="uProfile" type="text" readonly value="<?php echo $student->stud_slastname; ?>" placeholder="Ingresa segundo apellido">
                                       </a>
                                    </li>
                                    <li class="list-group-item">
                                       <label for="Password" class="control-label">
                                          <b>Contraseña actual:</b>
                                       </label>
                                       <a>
                                          <input name="stud_current_passwd" id="stud_current_passwd" class="uProfile" type="password" readonly placeholder="Ingresa la contraseña actual">
                                       </a>
                                    </li>
                                    <li class="list-group-item">
                                       <label for="New Password" class="control-label">
                                          <b>Ingresa la nueva contraseña:</b>
                                       </label>
                                       <a>
                                          <input name="stud_new_passwd" id="stud_new_passwd" class="uProfile" type="password" readonly placeholder="Ingresa la nueva contraseña">
                                       </a>
                                    </li>
                                    <li class="list-group-item">
                                       <label for="Confirm Password" class="control-label">
                                          <b>Confirma la contraseña:</b>
                                       </label>
                                       <a>
                                          <input name="stud_passwd_confirm" id="stud_passwd_confirm" class="uProfile" type="password" readonly placeholder="Confirma la contraseña">
                                       </a>
                                    </li>
                                    <li class="list-group-item">
                                       <label for="Genre" class="control-label">
                                          <b>Género:</b>
                                       </label>
                                       <a>
                                          <div class="form-check">
                                             <label for="male" class="containerR form-check-label">
                                                <input type="radio" class="form-check-input" id="male" name="stud_gender" value="Hombre" <?php echo ($student->stud_gender === 'Hombre') ? 'checked' : ''; ?>>Hombre
                                                <span class="checkmark"></span>
                                             </label>
                                          </div>
                                       </a>
                                       <a>
                                          <div class="form-check">
                                             <label for="female" class="containerR form-check-label">
                                                <input type="radio" class="form-check-input" id="female" name="stud_gender" value="Mujer" <?php echo ($student->stud_gender === 'Mujer') ? 'checked' : ''; ?>>Mujer
                                                <span class="checkmark"></span>
                                             </label>
                                          </div>
                                       </a>
                                    </li>
                                 </ul>
                                 <button type="button" id="savebutton" class="btn btn-primary btn-block"><b>Edit</b></button>
                                 <button type="submit" class="btn btn-primary btn-block"><b>Send</b></button>
                              </div>
                           </form>
                        </div>
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
   <!-- MAIN JS -->
   <script src="<?= BASE_URL; ?>bower_components/jquery/dist/jquery.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
   <script src="<?= BASE_URL; ?>bower_components/fastclick/lib/fastclick.js"></script>
   <script src="<?= BASE_URL; ?>js/confirmLogout.js"></script>
   <script src="<?= BASE_URL; ?>js/sweetalert2.js"></script>
   <script src="<?= BASE_URL; ?>js/croppie-2.6.5/croppie.min.js"></script>
   <script src="<?= BASE_URL; ?>js/search.js"></script>
   <script src="<?= BASE_URL; ?>dist/js/adminlte.min.js"></script>
   <script src="<?= BASE_URL; ?>dist/js/demo.js"></script>
   <script src="<?= BASE_URL; ?>js/control.js"></script>
   <!-- iziToast JS plugins -->
   <script src="<?= BASE_URL; ?>plugins/iziToast/js/iziToast.min.js"></script>
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
   <!-- AJAX -->
   <script src="<?= BASE_URL; ?>ajax/update_studInfo.js"></script>
   <script src="https://kit.fontawesome.com/8a7f47aa91.js" crossorigin="anonymous"></script>
</body>

</html>