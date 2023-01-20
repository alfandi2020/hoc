<!DOCTYPE html>

<html lang="en">

   <head>

      <title>Login</title>

      <meta charset="UTF-8">

      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!--===============================================================================================-->	

      <link rel="icon" type="image/png" href="<?php echo base_url();?>img/logo_h.png"/>

      <!--===============================================================================================-->

      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>login_lib/vendor/bootstrap/css/bootstrap.min.css">

      <!--===============================================================================================-->

      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>login_lib/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

      <!--===============================================================================================-->

      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>login_lib/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

      <!--===============================================================================================-->

      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>login_lib/vendor/animate/animate.css">

      <!--===============================================================================================-->	

      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>login_lib/vendor/css-hamburgers/hamburgers.min.css">

      <!--===============================================================================================-->

      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>login_lib/vendor/animsition/css/animsition.min.css">

      <!--===============================================================================================-->

      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>login_lib/vendor/select2/select2.min.css">

      <!--===============================================================================================-->	

      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>login_lib/vendor/daterangepicker/daterangepicker.css">

      <!--===============================================================================================-->

      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>login_lib/css/util.css">

      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>login_lib/css/main.css">

      <!--===============================================================================================-->

   </head>

   <body>

      <div class="limiter">

         <div class="container-login100" style="background-image: url('');">

            <div class="p-t-10 p-b-10">

            <div class="row">
               <div class="col">
               <span class="login100-form-title p-b-41">

               <img class="mt-5"  width="400" src="<?php echo base_url();?>img/login_h.jpeg" alt="..." >

               </span>
               </div>
               <div class="col">

               <form class="login100-form validate-form p-b-33 p-t-5" action="<?php echo base_url();?>login/login_form" method="post" name="login">

                  <div class="wrap-input100 validate-input" data-validate = "Enter username">

                     <input class="input100" type="text" name="username" placeholder="Username" autocomplete="off">

                     <span class="focus-input100" data-placeholder="&#xe82a;"></span>

                  </div>

                  <div class="wrap-input100 validate-input" data-validate="Enter password">

                     <input class="input100" type="password" name="password" placeholder="Password" autocomplete="off">

                     <span class="focus-input100" data-placeholder="&#xe80f;"></span>

                  </div>

                  <div class="container-login100-form-btn m-t-32 ">

                     <button class="login100-form-btn">

                     &nbsp;&nbsp;Login&nbsp;&nbsp;

                     </button>&nbsp;

               </form>
            </div>
            </div>

					 <!--button class="login100-form-btn" onclick="window.location.replace('<?php echo base_url();?>login/register_view');">

				     Register

				     </button-->

				  </div>

				  <br><div class="text-center"><font color="#54585b">Harnoko Office Communication &copy;2022</font></div>


            </div>

         </div>

      </div>

      <!--===============================================================================================-->

      <script src="<?php echo base_url();?>login_lib/vendor/jquery/jquery-3.2.1.min.js"></script>

      <!--===============================================================================================-->

      <script src="<?php echo base_url();?>login_lib/vendor/animsition/js/animsition.min.js"></script>

      <!--===============================================================================================-->

      <script src="<?php echo base_url();?>login_lib/vendor/bootstrap/js/popper.js"></script>

      <script src="<?php echo base_url();?>login_lib/vendor/bootstrap/js/bootstrap.min.js"></script>

      <!--===============================================================================================-->

      <script src="<?php echo base_url();?>login_lib/vendor/select2/select2.min.js"></script>

      <!--===============================================================================================-->

      <script src="<?php echo base_url();?>login_lib/vendor/daterangepicker/moment.min.js"></script>

      <script src="<?php echo base_url();?>login_lib/vendor/daterangepicker/daterangepicker.js"></script>

      <!--===============================================================================================-->

      <script src="<?php echo base_url();?>login_lib/vendor/countdowntime/countdowntime.js"></script>

      <!--===============================================================================================-->

      <script src="<?php echo base_url();?>login_lib/js/main.js"></script>

   </body>

</html>