<?php require 'header.php'; ?>

<?php $message = $user->loggedin ? "{$user->getUsername()}, you are logged in" : "Please sign up and/or log in to join in."; ?>

<h2>
	<p class='text-secondary mt-3'>Welcome to <?=$appname?></p>
</h2>
<span><?=$message?></span>

<?php require 'footer.php'; ?>
