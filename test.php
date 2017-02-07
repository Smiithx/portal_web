

<?php 

require "lib/PasswordHash.php";
$hasher = new PasswordHash(8,FALSE);
$hash = $hasher->HashPassword("2637375846s");
echo $hash;



?>