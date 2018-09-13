<?php

require 'dbconfig.php';

$appname="My Social Network";

try
{
	$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";";
	$con = new PDO($dsn,DB_USER,DB_PASS);
	$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
	echo $e->getMessage();
}

function createTable($name,$query)
{
	global $con;

	try
    {

		$sql = $con->query("CREATE TABLE IF NOT EXISTS $name ( $query ) ");
		if($sql) echo "Table '$name' created or already exists.<br>";

	}
	catch (PDOException $e)
	{
		echo $e->getMessage(). "<br>";
	}
}

function queryPDOMysql($query)
{
    global $con;
	try
	{
		$result = $con->query($query);
		return $result;
	}
   	catch (PDOException $e)
	{
		echo $e->getMessage();
		return false;
	}

}

function destroySession()
{
    $_SESSION=array();
    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(),'',time()-25920000,'/');
	session_destroy();
}

function sanitizeString($var)
{
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $var;
}

function showProfile($user)
{
    if(file_exists("./uploads/$user.jpg"))
        echo "<img src='./uploads/$user.jpg' style='float:left;'>";
    $result = queryPDOMysql("SELECT description FROM members WHERE user='$user'");

    if($result->rowCount())
    {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        echo stripslashes($row['description']) . "<br style='clear:left;'><br>";
    }
}
