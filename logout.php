<?php
session_start();
//clear session
session_destroy();
//Redirect to login page
header('location:login.php');
