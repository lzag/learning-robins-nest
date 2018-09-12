<?php
require_once 'header.php';

/* Check for login */
if (!$loggedin) die("Sorry, you need to be logged in to view this page");


if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
else                      $view = $user;

/* Inserting the text message into the database*/
if (isset($_POST['text']))
{
    $text = sanitizeString($_POST['text']);

    if ($text != "")
    {
        $pm = substr(sanitizeString($_POST['pm']),0,1);
        $time = time();
        queryPDOMysql("INSERT INTO messages VALUES(NULL, 'user', '$view', '$pm', '$time','$text')");
    }
}

if ($view != "")
{
    if ($view == $user) $name1 = $name2 = "Your";
    else
    {
        $name1 = "<a href='members.php'?view=$view'>$view</a>'s";
        $name2 = "$view's";
    }

    echo "<div class='main'><h3>$name1 Messages</h3>";
    showProfile($view);

?>
    <form method="post" action="messages.php?view=<?=$view?>">
    Type here to leave a message: <br>
    <textarea name="text" cols="40" rows="3"></textarea><br>
    Public<input type="radio" name="pm" value="0" checked="checked">
    Private<input type="radio" name="pm" value="1">
    <input class="btn btn-primary" type="submit" value="Post Message"></form><br>

<?php

	/* Erase the messages from the database */
    if (isset($_GET['erase']))
    {
        $erase = sanitizeString($_GET['erase']);
        queryPDOMysql("DELETE FROM messages WHERE id=$erase AND recip='$user'");
    }

	$query = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
    $result = queryPDOMysql($query);

	/* Echo  the messages */
    while( $row = $result->fetch(PDO::FETCH_ASSOC))
    {

        if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user)
        {
            echo date('M jS \'y g:ia:', $row['time']);
            echo "<a href='messages.php?view=".$row['auth']."'>".$row['auth']."</a>";

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

if ($result->rowCount() == 0) echo "<br><span class='info'>No messages yet</span><br><br>";
?>

<br><a class="btn btn-primary" href="messages.php?view=<?=$view?>">Refresh messages</a>


<?php require 'footer.php'; ?>
