<?php
$dsh="mysql:host=localhost; dbname=imagegallery; charset=utf8mb4";

$options=[
    PDO::ATTR_EMULATE_PREPARES=>false,
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
];

try {
   $pdo=new PDO ($dsh,'root','', $options);
} catch(Exceptions $e) {
   error_log($e->getMessage());
   exit();
}
?>