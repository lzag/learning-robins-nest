<?php
$error = $user = $pass =  "";
if ($error == "") {

?>

<h3>Please enter your details to log in</h3>
<form method="post" action="login.php">
 <span class="text-danger"><?=$error?></span>
  <div class="form-group">
    <label for="inputUsername">Username</label>
    <input name="user" value="<?=$user?>" type="text" class="form-control" id="inputUsername" aria-describedby="emailHelp" placeholder="Enter username" maxlength="16">
  </div>
  <div class="form-group">
    <label for="inputPassword">Password</label>
    <input name="pass" value="<?=$pass?>" type="password" class="form-control" id="inputPassword" placeholder="Password" maxlength="16">
  </div>
  <button type="submit" class="btn btn-primary">Log in</button>
</form>

<?php } else {

echo " there is not this" ;

?>

<span class="text-success">You are now logged in. Please <a href="members.php?view=<?=$user?>">click here</a> to continue.</span>

<?php
}
require 'footer.php';
?>
