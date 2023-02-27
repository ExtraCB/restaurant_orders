<?php 
session_start();
session_destroy();

header('location:./../_page/general/login.php');