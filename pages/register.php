<?php
  $nameError = $usernameError = $passwordError = "";
  $name = $username = '';

  if(isset($_POST['name'],$_POST['username'],$_POST['password'],$_POST['confirm_password'])){

    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if(empty($name)){
      $nameError = "pllease input name!";
    }
    if(empty($username)){
      $usernameError = "pllease input username!";
    }
    if(empty($password)){
      $passwordError = "pllease input password!";
    }
  } 
  ?>



<form  action="?page=register" method="post" class="col-md-8 col-lg-6 mx-auto">
    <h3>Register</h3>
  <div class="mb-3">
    <label for="Name" class="form-label">Name</label>
    <input name="name" value="<?php  echo $name ?>" type="text" class="form-control
     <?php echo empty($nameError)? '' : 'is-invalid'; ?>">
     <div class="invalid-feedback">
      <?php echo $nameError; ?></div>
   
   
  </div>
    <div class="mb-3">
    <label class="form-label">username</label>
    <input name="username" value="<?php  echo $username?>" type="text" class="form-control
     <?php echo empty($usernameError)? '' : 'is-invalid'; ?>">
     <div class="invalid-feedback"><?php echo $usernameError;?></div>
   
   
  </div>

  <div class="mb-3">
    <label class="form-label">Password</label>
    <input name="password" type="password" class="form-control <?php echo empty($passwordError)? '' : 'is-invalid'; ?>">
    <div class="invalid-feedback"><?php echo $passwordError;?></div>
  </div>
    <div class="mb-3">
    <label class="form-label"> Confirm Password</label>
    <input name="confirm_password" type="password" class="form-control">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>