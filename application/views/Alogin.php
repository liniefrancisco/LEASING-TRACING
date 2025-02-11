      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/animate.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/noty-animate.css">
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login page</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/Alogin.css">
</head>
<body>

<div id-"container">

  <h1><br></br></h1>
<div class="login-page">
  <div class="form">

    <form class="register-form">
      <input type="text" placeholder="name"/>
      <input type="password" placeholder="password"/>
      <input type="text" placeholder="email address"/>
      <button>create</button>
  <p class="message">Already registered? <a href="#">Sign In</a></p>
    </form>
    <form class="login-form">
 <input type="text" placeholder="username"/>
      <input type="password" placeholder="password"/>
      <button>login <a href=' <?php echo base_url()."index.php/main/signup"; ?>' ></a> </button>

      <p class="message">Not registered? <a href=' <?php echo base_url()."index.php/main/signup"; ?>' >Create an account </a></p>
    </form>
  </div>
</div>

</div>

  </body>
  </html>

  <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login page</title>

</head>
<body>

<div id-"container">
  <h1>Login</h1>

  <?php 
  
 
  echo form_open('index.php/main/login_validation');

  echo validation_errors();
 echo "<p>Username: ";
  echo form_input('username', $this->input->post('username'));
  echo "</p>";

  echo "<p>Password: ";
  echo form_password('password');
  echo "</p>";

  echo "<p>";
  echo form_submit('login_submit', 'Login');
  echo "</p>";

  echo form_close();

  ?>

  <a href=' <?php echo base_url()."index.php/main/signup"; ?>' >Sign up! </a>


  </div>

  </body>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/notification.js"></script>
  </html>