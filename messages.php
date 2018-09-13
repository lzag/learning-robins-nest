<?php
require_once 'header.php';

/* Check for login */
if (!$loggedin) die("Sorry, you need to be logged in to view this page");

if (isset($_GET['view']))
{
	$view = sanitizeString($_GET['view']);
}
else
{
	$view = $user;
}

/* Inserting the text message into the database*/
if (isset($_POST['text']))
{
    $text = sanitizeString($_POST['text']);

    if ($text != "")
    {
        $pm = substr(sanitizeString($_POST['pm']),0,1);
        $time = time();
        queryPDOMysql("INSERT INTO messages VALUES(NULL, '$user', '$view', '$pm','$time','$text')");
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
        queryPDOMysql("DELETE FROM messages WHERE id=$erase AND recip='$user'");
    }

/* Set variables depending on whose profile the user is viewing */
if ($view != "")
{
    if ($view == $user) $name1 = $name2 = "Your";
    else
    {
        $name1 = "<a href='members.php'?view=$view'>$view</a>'s";
        $name2 = "$view's";
    }
 ?>


<div class='main'><h3><?=$name1?> Messages</h3>



<?php


   $query = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
   $result = queryPDOMysql($query);
?>

<?php if ($result->rowCount() == 0) : ?>

	<span class='info'>No messages yet</span><br><br>

<?php else : ?>
<?php
	/* Echo  the messages */
    while( $row = $result->fetch(PDO::FETCH_ASSOC))
    {

        if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user)
        {
            echo "On " . date('M jS \'y g:ia: ', $row['time']) . "<br>";
            echo "<strong><a href='messages.php?view=".$row['auth']."'>".$row['auth']."</a></strong> ";

            if ($row['pm'] == 0)
                echo "wrote: &quot; ".$row['message'] . "&quot; ";
            else
                echo "whispered: <span class='whisper'>&quot;" . $row['message'] . "&quot;</span>";

            if ($row['recip'] == $user)
                echo "[<a href='messages.php?view=$view" . "&erase=" . $row['id'] . "'>erase</a>]";

            echo "<br>";

        }
    }
}


?>

<br><a class="btn btn-primary" href="messages.php?view=<?=$view?>">Refresh messages</a>


    <form method="post" action="messages.php?view=<?=$view?>">
    <div class="form-group">
    <label for="message">Type here to leave a message</label>
    <textarea name="text" cols="40" rows="3" id="message"></textarea>
	</div>
   	<div class="form-check">
   		<label for="pm-0">Public</label>
   		<input id="pm-0" type="radio" name="pm" value="0" checked="checked">
   	</div>
   	<div class="form-check">
   		<label for="pm-1">Private</label>
   		<input id="pm-1" type="radio" name="pm" value="0" checked="checked">
   	</div>
    <input class="btn btn-primary" type="submit" value="Post Message"></form><br>


<?php require 'footer.php'; ?>
