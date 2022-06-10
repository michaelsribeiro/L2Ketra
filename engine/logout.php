<?php

$_SESSION['loggedin'] = '';
$_SESSION['login'] = '';
unset($_SESSION['loggedin']);
unset($_SESSION['login']);
session_start();
session_destroy();
header('Location: ../?pages=home');
exit;
