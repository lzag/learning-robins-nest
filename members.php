<?php
require_once 'header.php';

if (!$user->loggedin) die("Your must be logged in to view this page");

if (isset($_GET['view']))
{
    $view = sanitizeString($_GET['view']);

    if ($view == $user->getUsername()) $name = "Your";
    else $name = "$view's";
    echo "<h3> $name Profile</h3>";
    showProfile($view);
    echo "<a class='button' href='messages.php?view=$view'>"."View $name messages</a><br><br>";
    die("</div></body></html>");
}

if (isset($_GET['add']))
{
    $add = sanitizeString($_GET['add']);

    $result = queryPDOMysql("SELECT * FROM friends WHERE username='$add' AND friend='{$user->getUsername()}'");
    if (!$result->fetchAll())
        queryPDOMysql("INSERT INTO friends VALUES ('$add','{$user->getUsername()}')");
}
else if (isset($_GET['remove']))
{
    $remove = sanitizeString($_GET['remove']);
    queryPDOMysql("DELETE FROM friends WHERE username='$remove' and friend='{$user->getUsername()}'");
}

$result = queryPDOMysql("SELECT username FROM members ORDER by username");
?>

<h3>Other Members (total of <?=User::totalMembers()?>) </h3><ul>

<?php
while( $row = $result->fetch(PDO::FETCH_ASSOC))
{

    if ($row['username'] == $user->getUsername()) continue;
    echo "<li><a href='members.php?view=" . $row['username'] . "'>" . $row['username'] . "</a>";
    $follow = "follow";

    $result1 = queryPDOMysql("SELECT * FROM friends WHERE username='". $row['username'] . "' AND friend='{$user->getUsername()}'");
    $t1 = $result1->rowCount();

    $result1 = queryPDOMysql("SELECT * FROM friends WHERE username='{$user->getUsername()}' AND friend='". $row['username'] . "'");
    $t2 = $result1->rowCount();

    if (($t1 + $t2 ) > 1) echo "&harr; is a mutual friend";
    elseif ($t1) echo " &larr; you are following";
    elseif ($t2) { echo " &rarr; is following you";
    $follow = "recip"; }

if (!$t1) echo " [<a href='members.php?add=" . $row['username'] . "'>$follow</a>]";
else echo " [<a href='members.php?remove=" . $row['username'] . "'>drop</a>]";

}
?>
</ul>
<?php require 'footer.php' ?>
