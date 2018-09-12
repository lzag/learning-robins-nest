<?php

require_once 'header.php';

if (!$loggedin) die("You need to be loggedin in order to view this page");

if (isset($_GET['view'])) $view = sanitizeStrings($_GET['view']);
else $view = $user;

if ($view == $user)
{
    $name1 = $name2 = "Your";
    $name3 = "You are";
}
else
{
    $name1 = "<a href='members.php?view=$view'>$view</a>'s";
    $name2 = "$view's";
    $name3 = "$view is";
}

$followers = array();
$following = array();


/* Get all the people who are following the user*/
$result = queryPDOMysql("SELECT * FROM friends WHERE user='$view'");

$j = 0;
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
    $followers[$j] = $row['friend'];
	$j++;
}

/* Get all the people that the user folows */
$result = queryPDOMysql("SELECT * FROM friends WHERE friend='$view'");

$j = 0;
while( $row = $result->fetch(PDO::FETCH_ASSOC))
{
    $following[$j] = $row['user'];
	$j++;
}


$mutual = array_intersect($followers, $following);
$followers = array_diff($followers, $mutual);
$following = array_diff($following, $mutual);

$friends = (!$mutual && !$followers && !$following) ? FALSE : TRUE;

?>

	<?php if ($mutual) :?>
	<div class="row">
	<h3>Mututal friends</h3>
	</div>
	<div class="row">
		<ul class="list-group">
			<?php foreach($mutual as $friend) : ?>
				<li class="list-group-item"><a href='members.php?view=<?=$friend?>'><?=$friend?></a>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if ($followers) :?>
	<div class="row">
	<h3>Followers</h3>
	</div>
	<div class="row">
		<ul class="list-group">
			<?php foreach($followers as $friend) : ?>
				<li class="list-group-item"><a href='members.php?view=<?=$friend?>'><?=$friend?></a>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if ($following) :?>
	<div class="row">
	<h3><?=$name3?> following</h3>
	</div>
	<div class="row">
		<ul class="list-group">
			<?php foreach($following as $friend) : ?>
				<li class="list-group-item"><a href='members.php?view=<?=$friend?>'><?=$friend?></a>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if (!$friends) : ?>

	<br>You don't have any friends yet.<br><br>

	<?php endif; ?>


<?php
echo "<a class='button' href='messages.php?view=$view'>" .
    "View $name2 messages</a>";
?>

<?php require 'footer.php'; ?>
