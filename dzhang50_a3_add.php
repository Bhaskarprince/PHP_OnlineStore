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
<?php require 'dzhang50_a3_library.php';
        $getID=$_GET[idd];
        $page=$_GET[pos_page];//$page is used to let the brower know where the browse is, it could be y,n and a.
?>
<?php
        if (empty($_POST)){
            if(empty($getID)){
                $title="Item Adding";
            }
                else $title="Item changeing";
            myheader($title);
                        top_right();
            menu($page);
            form($getID);
            //myfooter;
        }
        else{
            $Error_Hold=array();//$Error_Hold is to hold the error message
            if(!preg_match("/^([a-z0-9]+[ ]*)+$/i", $_POST[name])){//form validation
                array_push($Error_Hold, "Name: The name you input is invalid -- letters and space only!");
            }
            if(!preg_match("/^[a-z]+[a-z _-]+$/i", $_POST[manufac])){
                array_push($Error_Hold, "Manufacture: The manufacture is invalid -- etters, spaces, and dasher only!");
            }
            if(!preg_match("/^[a-z0-9 -]+$/i", $_POST[model])){
                array_push($Error_Hold, "Model: The model is invalid -- letters, digits, dasher, and sapces only!");
            }
            if(!preg_match("/^[a-z0-9,. -]+$/i", $_POST[descrip])){
                array_push($Error_Hold, "Description: The description is invalid -- letters, digits, periods, commas, and spaces only!");
            }
            if(!preg_match("/^[0-9]+$/", $_POST[onhand])){
                array_push($Error_Hold, "On Hand: The onhand is invalid -- numbers only!");
            }
            if(!preg_match("/^[0-9]+$/", $_POST[reorder])){
                array_push($Error_Hold, "Reorder: The record is invalid -- Number only!");
            }
            if(!preg_match("/^[0-9]+\.([0-9][0-9])$/", $_POST[cost])){
                array_push($Error_Hold, "Cost: The cost is invalid. It should like: 17.00!");
            }
            if(!preg_match("/^[0-9]+\.([0-9][0-9])$/", $_POST[price])){
                array_push($Error_Hold, "Price: The price is invalid. It should like: 17.00!");
            }
            if(empty($Error_Hold)){//if $Error_Hold is empty, which means pass all the validation
                DataCode();//connect to database
                $chkArr=array();//declare empty array, so when blank form is shown for first time,  in_array wool not casue warining.
                if(!empty($_POST[Checkbox_Arr])) $chkArr=$_POST[Checkbox_Arr];//to check the checkbox is selected or not
                $chkSale='n';
                $chkDiscnt='n';
                $del='y';//change something in here..
                if(in_array('Sales',$chkArr)) $chkSale='y';
                if(in_array('Discount',$chkArr)) $chkDiscnt='y';
                if(empty($getID)){//if there is a id, update the data; otherwise to insert new data
                    //$Insert_Q=sprintf("insert into inventory(name,manufac,model,descrip,onhand,reorder,cost,price,sale,discont,deleted) values('$_POST[name]', '$_POST[manufac]', '$_POST[model]', '$_POST[descrip]', '$_POST[onhand]', '$_POST[reorder]', '$_POST[cost]', '$_POST[price]', '$chkSale', '$chkDiscnt', '$del')");
                        $Insert_Q=sprintf("insert into inventory values ('$id', '%s', '%s', '%s', '%s', '%s', '%s','%s', '%s', '%s', '%s', '%s')",
                                    mysql_real_escape_string($_POST[name]),
                                    mysql_real_escape_string($_POST[manufac]),
                                    mysql_real_escape_string($_POST[model]),
                                    mysql_real_escape_string($_POST[descrip]),
                                    mysql_real_escape_string($_POST[onhand]),
                                    mysql_real_escape_string($_POST[reorder]),
                                    mysql_real_escape_string($_POST[cost]),
                                    mysql_real_escape_string($_POST[price]),
                                    mysql_real_escape_string($chkSale),
                                    mysql_real_escape_string($chkDiscnt),
                                    mysql_real_escape_string($del));

                }else{
                    //$Insert_Q="update inventory set name='$_POST[name]', manufac='$_POST[manufac]', model='$_POST[model]', descrip='$_POST[descrip]', onhand='$_POST[onhand]', reorder='$_POST[reorder]', cost='$_POST[cost]', price='$_POST[price]', sale='$chkSale', discont='$chkDiscnt' where id=$getID";
                    $Insert_Q=sprintf("update inventory set name='%s', manufac='%s',model='%s', descrip='%s', onhand='%s', reorder='%s',cost='%s', price='%s', sale='%s', discont='%s' where id='%s'",
                                    mysql_real_escape_string($_POST[name]),
                                    mysql_real_escape_string($_POST[manufac]),
                                    mysql_real_escape_string($_POST[model]),
                                    mysql_real_escape_string($_POST[descrip]),
                                    mysql_real_escape_string($_POST[onhand]),
                                    mysql_real_escape_string($_POST[reorder]),
                                    mysql_real_escape_string($_POST[cost]),
                                    mysql_real_escape_string($_POST[price]),
                                    mysql_real_escape_string($chkSale),
                                    mysql_real_escape_string($chkDiscnt),
                                    mysql_real_escape_string($getID));
                }
                mysql_query($Insert_Q) or die("Could not query: " . mysql_error());
                if(!empty($page)){
                    header("Location: dzhang50_a3_view.php?pos_page=$page");//to me: return is right.
                }else{header("Location: dzhang50_a3_view.php?pos_page=a");}
            }
            else{
                myheader("error page");
                menu($_POST[$page]);
                echo "<fieldset><legend>Errors:</legend>";
                foreach($Error_Hold as $err) {echo "$err<br/>";}
                echo "</fieldset>";
                form($getID);
            }
        }
?>
<?php
    myfooter();
?>
<?php
    }else header("Location: dzhang50_a3_login.php");
?>