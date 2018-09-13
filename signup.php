<?php

require_once 'header.php';

$error = $username = $pass = "";
if (isset($_SESSION['user'])) destroySession();

if (isset($_POST['user']))
{
    $username = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($username == "" || $pass == "")
        $error = "Not all fields were entered";
    else
    {
        $result = $con->prepare("SELECT * FROM members WHERE username=?");
		$result->execute(array($username));
        if ($result->rowCount())
            $error = "That username already exists";
        else
        {
			$result = $con->prepare("INSERT INTO members (user_id, username, pass) VALUES(NULL,?,?)");
			$result->execute(array($username,$pass));
			if ($result) $signup_success = TRUE;
        }
    }
}

?>

<?php if (isset($signup_success)) : ?>

	<h4 class="text-success">Account created</h4><br>Please log in.

<?php else : ?>

<h3>Please enter your details to sign up</h3>
<form method="post" action="signup.php">
 <span class="text-danger"><?=$error?></span>
  <div class="form-group">
    <label for="inputUsername">Username</label>
    <input name="user" value="<?=$username?>" type="text" class="form-control" id="signupUsername" aria-describedby="emailHelp" placeholder="Enter username" maxlength="16" onBlur="checkUser(this)">
  </div>
  <div class="form-group">
    <label for="inputPassword">Password</label>
    <input name="pass" value="<?=$pass?>" type="password" class="form-control" id="inputPassword" placeholder="Password" maxlength="16">
  </div>
  <button type="submit" class="btn btn-primary">Sign up</button>
</form>

<?php endif; ?>

<?php require 'footer.php'; ?>
