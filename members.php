<?php
require_once 'header.php';

if (!$loggedin) die("Your must be logged in to view this page");

if (isset($_GET['view']))
{
    $view = sanitizeString($_GET['view']);

    if ($view == $user) $name = "Your";
    else $name = "$view's";
    echo "<h3> $name Profile</h3>";
    showProfile($view);
    echo "<a class='button' href='messages.php?view=$view'>"."View $name messages</a><br><br>";
    die("</div></body></html>");
}

if (isset($_GET['add']))
{
    $add = sanitizeString($_GET['add']);

    $result = queryPDOMysql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
    if (!$result->fetchAll())
        queryPDOMysql("INSERT INTO friends VALUES ('$add','$user')");
}
else if (isset($_GET['remove']))
{
    $remove = sanitizeString($_GET['remove']);
    queryPDOMysql("DELETE FROM friends WHERE user='$remove' and friend='$user'");
}

$result = queryPDOMysql("SELECT user FROM members ORDER by user");
?>

<h3>Other Members</h3><ul>

<?php
while( $row = $result->fetch(PDO::FETCH_ASSOC))
{

    if ($row['user'] == $user) continue;
    echo "<li><a href='members.php?view=" . $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "follow";

    $result1 = queryPDOMysql("SELECT * FROM friends WHERE user='". $row['user'] . "' AND friend='$user'");
    $t1 = $result1->rowCount();
    $result1 = queryPDOMysql("SELECT * FROM friends WHERE user='$user' AND friend='". $row['user'] . "'");
    $t2 = $result1->rowCount();

    if (($t1 + $t2 ) > 1) echo "&harr; is a mutual friend";
    elseif ($t1) echo " &larr; you are following";
    elseif ($t2) { echo " &rarr; is following you";
    $follow = "recip"; }

if (!$t1) echo " [<a href='members.php?add=" . $row['user'] . "'>$follow</a>]";
else echo " [<a href='members.php?remove=" . $row['user'] . "'>drop</a>]";

}
?>


</ul>
<?php require 'footer.php' ?>
