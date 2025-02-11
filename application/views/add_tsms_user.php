

<section id="Homepage">
<div class="registration_form">
 <?php echo validation_errors('<p class="error">'); ?>
 <?php echo form_open("cntrl_tsms/add_user"); ?>
 
  <p>
  <label for="name">Name:</label>
  <input type="text" id="name" name="name" value="<?php echo set_value('user_name'); ?>" />
  </p>
   <p>
  <label for="last_name">Last Name:</label>
  <input type="text" id="last_name" name="last_name" value="<?php echo set_value('user_name'); ?>" />
  </p>
  <p>
  <label for="username">User Name:</label>
  <input type="text" id="username" name="username" value="<?php echo set_value('user_name'); ?>" />
  </p>
  <p>
  <label for="password">Password:</label>
  <input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" />
  </p>
  <p>
  <label for="cpassword">Confirm Password:</label>
  <input type="password" id="cpassword" name="cpassword" value="<?php echo set_value('cpassword'); ?>" />
  </p>
     <p>
  <label for="user_type">User Type:</label>
  <input type="text" id="user_type" name="user_type" value="<?php echo set_value('user_type'); ?>" />
  </p>
  <br>
  <p>
  <input type="submit" class="greenButton" value="Submit" />
  </p>
  </br>
 <?php echo form_close(); ?>
</div>

                     
</section>