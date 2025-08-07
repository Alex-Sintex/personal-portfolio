<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <!-- Favicons -->
   <link href="<?php echo PATH_URL; ?>/img/favicon/favicon.ico" rel="icon">
   <link href="<?php echo PATH_URL; ?>/img/favicon/apple-touch-icon.png" rel="apple-touch-icon">
   <title>Recover password</title>
   <link rel="stylesheet" href="<?php echo PATH_URL2; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?php echo PATH_URL2; ?>bower_components/fontawesome-free/css/all.min.css">
   <link rel="stylesheet" href="<?php echo PATH_URL2; ?>bower_components/ionicons-2.0.1/css/ionicons.css">
   <link rel="stylesheet" href="<?php echo PATH_URL2; ?>dist/css/AdminLTE.min.css">
   <link rel="stylesheet" href="<?php echo PATH_URL2; ?>css/sweetalert2.css">
   <link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition lockscreen">
   <div class="lockscreen-wrapper">
      <div class="lockscreen-logo">
         <a><b>KA's </b>website</a>
      </div>
      <div class="lockscreen-name">User</div>
      <div class="lockscreen-item">
         <div class="lockscreen-image">
            <i class="fa fa-lock fa-4x"></i>
         </div>
         <form id="recovery" class="lockscreen-credentials" method="POST">
            <div class="input-group">
               <input type="password" class="form-control" name="new_password" id="new_password"
                  placeholder="Ingresa la nueva contraseña">
               <input type="password" class="form-control" name="confirm_passwd" id="confirm_passwd"
                  placeholder="Confirma la contraseña">
               <div class="input-group-btn">
                  <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
               </div>
            </div>
            <input id="token" type="hidden" name="token" value="<?php echo $data['token']; ?>">
         </form>
      </div>
      <div class="help-block text-center">
         Enter your new password
      </div>
      <div class="text-center">
         <a href="<?php echo PATH_URL ?>">Or cancel operation</a>
      </div>
      <div class="lockscreen-footer text-center">
         <strong>Copyright &copy; 2023-2024 <a class="text-black">KA's website</a>.</strong> All rights
         reserved.
      </div>
   </div>
   <script src="<?php echo PATH_URL2; ?>bower_components/jquery/dist/jquery.min.js"></script>
   <script src="<?php echo PATH_URL2; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
   <script src="<?php echo PATH_URL2; ?>ajax/recovery_passwd.js"></script>
   <script src="<?php echo PATH_URL2; ?>js/sweetalert2.js"></script>
</body>

</html>