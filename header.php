<?php
require_once 'functions.php';
session_start();
$userstr = ' (Guest)';
if (isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = " ($user)";
}
else
{
	$loggedin = FALSE;
}

?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<title>
			<?=$appname.$userstr?>
		</title>
		<link rel="stylesheet" href="https://bootswatch.com/4/slate/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="style.css" type="text/css">

	</head>

	<body>
		<div class="container">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand" href="#">My Social Network</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">

						<?php if ($loggedin) : // Echo the menu for logged users ?>

						<li class="nav-item active">
							<a class="nav-link" href="members.php?view=<?=$user?>">Home <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="members.php">Members</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="friends.php">Friends</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="messages.php">Messages</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="profile.php">Edit Profile</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="logout.php">Log out</a>
						</li>

						<?php else : // echo the the standard menu ?>

						<li class="nav-item">
							<a class="nav-link" href="index.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="signup.php">Sign up</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="login.php">Log in</a>
						</li>
						<span class='info'>&#8658; You must be logged in to view this page.</span><br>

						<?php endif; ?>

					</ul>
					<!-- .navbar-nav -->
				</div>
				<!-- .collapse navbar-collapse-->
			</nav>
