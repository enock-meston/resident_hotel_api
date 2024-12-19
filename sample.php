<?php

$password = "123";

// Hash the password using bcrypt
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

echo $hashedPassword;


?>