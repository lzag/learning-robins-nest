<?php

require 'header.php';

$error = $username = $pass = "";

if (isset($_POST['user']))
{
    $username = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($username == "" || $pass == "")
	{
		$error = "Not all fields were entered";
	}
	else
	{
		$result = $con->prepare("SELECT username,pass FROM members WHERE username= ? AND pass= ?");
		$result->execute(array($username,$pass));
		if ( !$result->fetchAll() )
    	{
        	$error = "Username/Password invalid";
    	}
		else
    	{
			$_SESSION['user'] = $username;
			$_SESSION['pass'] = $pass;
			$login_success = TRUE;
    	}
	}
}

if (isset($login_success)) :

?>

<span class="text-success mt-3">You are now logged in. Please <a href="members.php?view=<?=$user->getUsername()?>">click here</a> to continue.</span>

<?php else : ?>

<h3>Please enter your details to log in</h3>
<form method="post" action="login.php">
 <span class="text-danger"><?=$error?></span>
  <div class="form-group">
    <label for="inputUsername">Username</label>
    <input name="user" value="<?=$username?>" type="text" class="form-control" id="inputUsername" aria-describedby="emailHelp" placeholder="Enter username" maxlength="16">
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
