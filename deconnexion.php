<?php  
session_start();

require_once 'header.php';

$_SESSION = array(); 
session_destroy();
header("location: connexion.php");// si je déconnecte,ça me dirige vers la page connexion.php
?>