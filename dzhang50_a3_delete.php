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
        DataCode();
        $receive_id=$_GET[idd];//is used to track id
        $rre=$_GET[tdel];//is used to track information for items. it cound be delete or restore.
        $page=$_GET[pos_page];//to get parameter to location
        if($rre=='y')
            $rre='n';
        else
            $rre='y';
        $update_q=sprintf("update inventory set deleted='%s' where id='%s'", mysql_real_escape_string($rre), mysql_real_escape_string($receive_id));
        mysql_query($update_q) or die("Could not update:" . mysql_error());
        header("Location: dzhang50_a3_view.php?pos_page=$page");
?>
<?php
    }else header("Location: dzhang50_a3_login.php");
?>