<?php
require_once 'header.php';

if (!$loggedin) die();

echo "<div class='main'><h3>Your Profile</h3>";

$result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

if (isset($_POST['text']))
{
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', '', $text);

    if ($result->num_rows)
        queryMysql("UPDATE profiles SET text='$text' WHERE user='$user'");
    else queryMysql("INSERT INTO profiles VALUES('$user','$text')");
}
else
{
    if ($result->num_rows)
    {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $text = stripslashes($row['text']);
    }
else $text = "";
}

$text = stripslashes(preg_replace('/\s\s+/','', $text));

if (isset($_FILES['image']['name']))
{
    $saveto = "$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;


switch($_FILES['image']['type'])
{
    case "image/gif'": $src = imagecreatefromgif($saveto); break;
    case "image/jpeg":
    case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
    case "image/png": $src = imagecreatefrompng($saveto); break;
    default: $typeok = FALSE; break;
}

if ($typeok)
{
    list($w,$h) = getimagesize($saveto);

    $max=100;
    $tw=$w;
    $th=$h;

    if ($w > $h && $max < $w)
    {
        $th = $max / $w * $h;
        $tw = $max;
    } elseif ($h > $w && $max < $h)
    {
        $tw = $max / $h * $w;
        $th = $max;
    } elseif ($max < $w)
    {
        $tw = $th = $max;
    }
    $tmp = imagecreatetruecolor($tw,$th);
    imagecopyresampled($tmp, $src, 0,0,0,0,$w,$th,$w,$h);
    imageconvolution($tmp, array(array(-1,-1,-1),
                                array(-1,16,-1), array(-1,-1,-1)), 8, 0);
    imagejpeg($tmp,$saveto);
    imagedestroy($tmp);
    imagedestroy($src);
}
}


showProfile($user);

?>

<form method='post' action='profile.php' enctype='multipart/form-data'>
 <div class="form-group">
  <label for="description">Enter or edit your details and/or upload an image</label>
  <textarea class="form-control" cols="10" rows="3" id="description"><?=$text?></textarea>
</div>
<div class="form-group">
    <label for="profilePhotoUpload">Image:</label>
    <input name="image" type="file" class="form-control-file" id="profilePhotoUpload" size="14">
  </div>
<input type='submit' class="btn btn-primary" value='Save Profile'>
</form>

<?php require 'footer.php'; ?>
