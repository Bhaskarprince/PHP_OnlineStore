<?php
//assignment #3
//Name: Donghu Zhang
//Zenit: int322_121b37
//StudentID: 064361108
//Instructor: John Samuel
?>
<?php
    session_start();
    if ($_SESSION['logged_in']){
?>
<?php
        include_once('dzhang50_a3_library.php');
        $view=$_GET[pos_page];//$view is used to get the location 
        if($view=='n'){//to differeniate different situation so the page can have different title.
            $title="view deleted page";
        }
        else if($view=='y'){
            $title="view active page";
        }else {
            $view=='a';
            $title="view all page";
        }
        myheader($title);
        top_right();//show the user on the top right
        menu($view);
        view($view);
        myfooter();
?>
<?php
    }else header("Location: dzhang50_a3_login.php");
?>