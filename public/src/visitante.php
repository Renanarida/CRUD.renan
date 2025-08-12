<?php

session_start();

$_SESSION['visitante'] = true;

header("location: ../reunioes.php");

?>