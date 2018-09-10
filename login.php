<?php

require 'header.php';

$error = $user = $pass = "";

if (isset($_POST['user']))
{
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")
	{
		$error = "Not all fields were entered";
	}
	else
	{
		$result = queryMysql("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");
		if ($result->num_rows == 0)
    	{
        	$error = "Username/Password invalid";
    	}
		else
    	{
			$_SESSION['user'] = $user;
			$_SESSION['pass'] = $pass;
			$login_success = TRUE;
    	}
	}
}

if (isset($login_success)) :

?>

<span class="text-success mt-3">You are now logged in. Please <a href="members.php?view=<?=$user?>">click here</a> to continue.</span>

<?php else : ?>

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

<?php
endif;
require 'footer.php';
?>
