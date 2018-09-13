<?php
require_once 'header.php';

/* Check for login */
if (!$user->loggedin) die("Sorry, you need to be logged in to view this page");

if (isset($_GET['view']))
{
	$view = sanitizeString($_GET['view']);
}
else
{
	$view = $user->getUsername();
}

/* Inserting the text message into the database*/
if (isset($_POST['text']))
{
	$stmt = $con->prepare("INSERT INTO messages VALUES(?, ?, ?, ?, ?, ?)" );
    $text = $_POST['text'];
    if ($text != "")
    {
        $pm = substr(sanitizeString($_POST['pm']),0,1);
        $time = time();
        $stmt->execute(array('NULL',$user->getUsername(), $view, $pm, $time, $text));
    }
	else
	{
		echo "Your message has no text";
	}
}

/* Erase the text messages from the database */
if (isset($_GET['erase']))
    {
        $erase = sanitizeString($_GET['erase']);
		$stmt = $con->prepare("DELETE FROM messages WHERE id= ? AND recip= ?");
        $stmt->execute(array($erase,$user->getUsername()));
    }

/* Set variables depending on whose profile the user is viewing */
if ($view != "")
{
    if ($view == $user->getUsername()) $name1 = $name2 = "Your";
    else
    {
        $name1 = "<a href='members.php'?view=$view'>$view</a>'s";
        $name2 = "$view's";
    }
}
 ?>

<div class='main'><h3><?=$name1?> Messages</h3>

<?php

   $result = $con->prepare("SELECT * FROM messages WHERE recip= ? ORDER BY time DESC");
   $result->execute(array($view));
?>

<?php if ($result->rowCount() == 0) : ?>

	<span class='info'>No messages yet</span><br><br>

<?php else : ?>
<?php
	/* Echo  the messages */
    while( $row = $result->fetch(PDO::FETCH_ASSOC))
    {

        if ($row['pm'] == 0 || $row['auth'] == $user->getUsername() || $row['recip'] == $user->getUsername())
        {
            echo "On " . date('M jS \'y g:ia: ', $row['time']) . "<br>";
            echo "<strong><a href='messages.php?view=".$row['auth']."'>".$row['auth']."</a></strong> ";

            if ($row['pm'] == 0)
                echo "wrote: &quot; ".$row['message'] . "&quot; ";
            else
                echo "whispered: <span class='whisper'>&quot;" . $row['message'] . "&quot;</span>";

            if ($row['recip'] == $user->getUsername())
                echo "[<a href='messages.php?view=$view" . "&erase=" . $row['id'] . "'>erase</a>]";

            echo "<br>";

        }
    }

?>
<?php endif; ?>

<br><a class="btn btn-primary" href="messages.php?view=<?=$view?>">Refresh messages</a>

<?php if ($view != $user->getUsername()) : ?>
<div class="row">
   <div class="col-md-6 mt-5">
    <form method="post" action="messages.php?view=<?=$view?>">
    <div class="form-group">
    <label for="message">Type here to leave <?=$view?> a message</label>
    <textarea type="text" name="text" cols="40" rows="3" id="message" class="form-control"></textarea>
	</div>
   	<div class="form-check form-check-inline">
   		<input class="form-check-input" id="pm-0" type="radio" name="pm" value="0" checked="checked">
   		<label class="form-check-label" for="pm-0">Public </label>
   	</div>
   	<div class="form-check form-check-inline">
   		<input class="form-check-input" id="pm-1" type="radio" name="pm" value="0" checked="checked">
   		<label class="form-check-label" for="pm-1">Private </label>
   	</div>
   	<br>
    <input class="btn btn-primary mt-3" type="submit" value="Post Message">
    </form><br>
    </div>
 </div>
<?php endif; ?>

<?php require 'footer.php'; ?>
