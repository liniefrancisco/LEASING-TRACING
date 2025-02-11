<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>AGC-TSMS</title>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/font-awesome.min.css"> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/Alogin.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/noty-animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/animate.css">
</head>
<body>
  <div class="form">
    <div class="bounce animated">                
      <form class="form-inline" action="<?php echo base_url(); ?>index.php/cntrl_tsms/admin_login" method="post">
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="username" class="form-control" placeholder="Username">
    </div>
<div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" placeholder="Password">
      </div>
            <button type="submit" class="btn btn-warning">Login</button>
        </form>
      </div>
    </div>
  </body>
<script type="text/javascript" src = "<?php echo base_url(); ?>js/jquery.js"></script>
<script type="text/javascript" src = "<?php echo base_url(); ?>js/bootstrap.js"></script>
<script type="text/javascript" src = "<?php echo base_url(); ?>js/jquery.noty.packaged.min.js"></script>
<script type="text/javascript" src = "<?php echo base_url(); ?>js/notification.js"></script>


<script type="text/javascript">
    <?php switch($flashdata): 
        case "Invalid Login": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-ban text-success"></i> Invalid Login</div>');
        <?php break;?>
    <?php endswitch;?>
</script>

</html>