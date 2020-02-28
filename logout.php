<!DOCTYPE html >
<html>
<head>
<meta/>
<title></title>
</head>

<body>
<?php

session_start();
unset($_SESSION['userId']);
unset($_SESSION['folderId']);
unset($_SESSION['folder_name']);
session_destroy();  
header('Location: loginForm.php');

?>
</body>
</html>