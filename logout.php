<?php

require_once 'header.php';

if (isset($_SESSION['user'])) :

	destroySession();

?>

<span class="text-secondary mt-3">You have been logged out. Please <a href="index.php">click here</a> to refresh the screen.</span>

<?php else : ?>

<span class="text-danger mt-3">You cannot log out because you are not logged in.</span>

<?php

endif;

require 'footer.php'; ?>
