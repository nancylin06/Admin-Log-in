<?php
session_start();

$_SESSION['admin_name'] = null;
$_SESSION['admin_id'] = null;
header('location:../Log IN/index.php');
?>