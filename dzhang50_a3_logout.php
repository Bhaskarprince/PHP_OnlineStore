<?php
//assignment #3
//Name: Donghu Zhang
//Zenit: int322_121b37
//StudentID: 064361108
//Instructor: John Samuel
//logout file
?>
<?php
    include_once("dzhang50_a3_library.php");
    session_start();
    cache_header();
    if($_SESSION['logged_in']){
        $_SESSION = array();//get rid of all session variables;
        setcookie("PHPSESSID", "", time() - 9600, "/");
        session_destroy();
        header("Location: dzhang50_a3_login.php");
    }else header("Location: dzhang50_a3_login.php");
?>