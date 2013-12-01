<?php
//assignment #3
//Name: Donghu Zhang
//Zenit: int322_121b37
//StudentID: 064361108
//Instructor: John Samuel
?>
<?php //This library includes all functions about the assignment ?>
<?php
    function myheader($title){
?>
<?php echo '<?xml version="1.0"  encoding="UTF-8" ?>'; ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
        <head>
            <title><?php echo $title; ?></title>
            <style type="text/css">
                a { text-decoration:none }
            </style>
        </head>
        <body>
            <p>
            <img src='../cname.jpg' alt='made by donghu zhang' width='1000' /></p>
<?php } ?>
<?php function menu($page){ ?>
            <table border='0'>
                <tr><td><a href="http://zenit.senecac.on.ca/~int322_121b37">Home Page</a></td>
                    <td></td>
                    <td></td>
                    <td><a href="dzhang50_a3_add.php?pos_page=<?php echo $page; ?>">Add Page</a></td>
                    <td></td>
                    <td></td>
                    <td><a href="dzhang50_a3_view.php?pos_page=a">View All Items</a></td>
                    <td></td>
                    <td></td>
                    <td><a href="dzhang50_a3_view.php?pos_page=n">View Deleted Items</a></td>
                    <td></td>
                    <td></td>
                    <td><a href="dzhang50_a3_view.php?pos_page=y">View Active Items</a></td>
                    <td></td>
                    <td></td>
                    <td><a href="dzhang50_a3_logout.php">Click to Logout</a></td>
                </tr>
            </table>
<?php } ?>
<?php function myfooter(){
?>
    <p>
     <a href="http://validator.w3.org/check?uri=referer">
     <img src="http://www.w3.org/Icons/valid-xhtml10"
     alt="Valid XHTML 1.0 Strict" height="31" width="88" />
     </a>
     <a href="http://jigsaw.w3.org/css-validator/check/referer">
     <img style="border:0;width:88px;height:31px"
     src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
     alt="Valid CSS!" />
     </a>
     </p>
        </body>
    </html>
<?php
    }
?>
<?php
    function form($getID){
        $all=array();
        if(!empty($_POST[Checkbox_Arr])) $all=$_POST[Checkbox_Arr];//if the checkbox is not empty, assign the name to $all
        ?>
      <form action="<?php echo $_SERVER['PHPSELF']; ?>" method="post">
        <table border="0" witdth=100%>
<?php
        if(!empty($getID) && empty($_POST)){//this code is to find out weather the ID is exist or not, if the id exsit, excute attach id to the form, otherwise not.
            DataCode();
            $idQ="select * from inventory where id=$getID";
            $response=mysql_query($idQ);
            $row=mysql_fetch_assoc($response);
            $_POST = $row;
            if ($_POST[sale] == 'y') {//to assgin the 'Sales' and 'Discount' to $all because I use the array method to modify the checkbox
                array_push($all, "Sales");
                }
            if ($_POST[discont] == 'y') {
                array_push($all, "Discount");
                }
            
?>
            <tr>
                <td align="right">Item ID: </td>
                <td><input type="text" name="itemID" size="8" readonly="readonly" value="<?php echo htmlentities($getID); ?>" /></td>
            </tr>
<?php
        }
?>
            <tr>
                <td align="right">Item Name: </td>
                <td>
                    <input type="text" name="name" size="30" value="<?php echo htmlentities($_POST[name]); ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">Manufacture: </td>
                <td><input type="text" name="manufac" size="30" value="<?php echo htmlentities($_POST[manufac]); ?>" /></td>
            </tr>
            <tr>
                <td align="right">Model: </td>
                <td><input type="text" name="model" size="30" value="<?php echo htmlentities($_POST[model]); ?>" /></td>
            </tr>
            <tr>
                <td align="right">Description: </td>
                <td><textarea rows="3" cols="40" name="descrip"><?php echo htmlentities($_POST[descrip]); ?></textarea></td>
            </tr>
            <tr>
                <td align="right">On Hand Number: </td>
                <td><input type="text" name="onhand" size="15" value="<?php echo htmlentities($_POST[onhand]); ?>" /></td>
            </tr>
            <tr>
                <td align="right">Record Level: </td>
                <td><input type="text" name="reorder" size="15" value="<?php echo htmlentities($_POST[reorder]); ?>" /></td>
            </tr>
            <tr>
                <td align="right">Cost: </td>
                <td><input type="text" name="cost" size="20" value="<?php echo htmlentities($_POST[cost]); ?>" /></td>
            </tr>
            <tr>
                <td align="right">Price: </td>
                <td><input type="text" name="price" size="20" value="<?php echo htmlentities($_POST[price]); ?>" /></td>
            </tr>
            <tr>
                <td align="right">Sales Item: </td>
                <td><input type="checkbox" name="Checkbox_Arr[]" value="Sales" <?php if(in_array('Sales',$all)) echo 'checked="checked"'; ?> /></td>
            </tr>
            <?php //change checkArr to Checkbox_Arr so that easy to understand ?>
            <tr>
                <td align="right">Sales Disctount: </td>
                <td><input type="checkbox" name="Checkbox_Arr[]" value="Discount" <?php if(in_array('Discount', $all)) echo 'checked="checked"'; ?> /></td>
            </tr>
        </table>
        <h2><input type="submit" value="<?php echo empty($getID)?'  Submit The Form   ':'  Change The Form  ' ?>"/></h2>
      </form>
<?php
      }
?>
<?php
    function DataCode(){//cennect to the database.
        $user='int322_121b37';
        $psw='qkAJ4855';
        $link = mysql_connect("db-mysql.zenit", $user,$psw) or die("Database cannot connect: " . mysql_error());
        mysql_select_db($user) or die("Database cannot be selected: " . mysql_error());
    }
?>
<?php
    function View($trans_page){
        DataCode();
        if($trans_page!='a'){
        $info="select * from inventory where deleted='$trans_page' order by id asc";
        }else {
            $info="select * from inventory order by id asc";
        }
        $respond=mysql_query($info) or die("Could not query the database: " . mysql_error());
        if(!empty($respond)){
            echo '<table border="1">';
                echo "<tr>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>Manufacturer</th>
                        <th>Model</th>
                        <th>Description</th>
                        <th>On Hand Number</th>
                        <th>Reorder</th>
                        <th>Cost</th>
                        <th>Selling Price</th>
                        <th>On Sale</th>
                        <th>Sales Discount</th>
                        <th>Delete or Restore</th>
                    </tr>";
            while($row=mysql_fetch_assoc($respond)){
                $delShow='Delete';
                if($row[deleted] =='n')
                    $delShow ='Restore';
                echo "<tr>
                        <td><a href='dzhang50_a3_add.php?idd=$row[id]&amp;pos_page=$trans_page'>$row[id]</a></td>
                        <td>$row[name]</td>
                        <td>$row[manufac]</td>
                        <td>$row[model]</td>
                        <td>$row[descrip]</td>
                        <td>$row[onhand]</td>
                        <td>$row[reorder]</td>
                        <td>$row[cost]</td>
                        <td>$row[price]</td>
                        <td>$row[sale]</td>
                        <td>$row[discont]</td>
                        <td><a href='dzhang50_a3_delete.php?idd=$row[id]&amp;tdel=$row[deleted]&amp;pos_page=$trans_page'>$delShow</a></td>
                    </tr>";
                }
            echo "</table>";
        }
        else{
            die("Database cannot be selected: " . mysql_error());
        }
    }
?>
<?php
    function cache_header(){
	header("Cache-Control: no-cache, no-store, must-revalidate");
    }
?>
<?php function login() { ?>
    <fieldset>
        <form method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table border='0'>
                <tr><td align='right'>User name:</td><td><input type='text' name='uname'/></td></tr>
                <tr><td align='right'>Password:</td><td><input type='password' name='password'/></td></tr>
            </table>
        <div>
            <input type="submit" value='Login'/>
            <input type="reset" value='Reset'/>
        </div>
        </form>
    </fieldset>
<?php } ?>
<?php function top_right(){?>
    <table width=80% border=0 cellspacing=0>
        <tr>
            <td valign=top align=right>
                User: <?php echo $_SESSION[userName]?>
            </td>
        </tr>
        <tr>
            <td valign=top align=right>
                Role: <?php echo $_SESSION[userRole]?>
            </td>
        </tr>
    </table>
<?php } ?>