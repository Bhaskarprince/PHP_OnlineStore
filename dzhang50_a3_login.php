<?php
//assignment #3
//Name: Donghu Zhang
//Zenit: int322_121b37
//StudentID: 064361108
//Instructor: John Samuel
//login file
?>
<?php
    include_once('dzhang50_a3_library.php');
    $title = 'You are in Log in page';
    $self = $_SERVER['PHP_SELF'];
    
    if(empty($_POST)){
        myheader($title);
        //menu($page);
        login();
        //myfooter();
    }
    else{
        $username=$_POST['uname'];
        $password=$_POST['password'];
        DataCode();
        $q=sprintf("select role, password from users where username='%s'", mysql_real_escape_string($username));
        $response=mysql_query($q) or die("Could not query: " . mysql_error());
        $row=mysql_fetch_assoc($response);
        mysql_close();//close sql
        if(mysql_num_rows($response)==1){//if ture, encrypt password
            $checkPassword=$row[password];//store the encrypted password
            $checkUser=$row[role];
            if($checkPassword == crypt($password,$checkPassword)){// if match, login. else return to login page!
                session_start();//must be called first if you want to use session
                cache_header();//print no-caching header
                setcookie("PHPSESSID", session_id());//the cookie would expire after you clsoe the browser
                $_SESSION['userName']=$username;//store user id, we use it in top_right functions. which will show us who login the system.
                $_SESSION['userRole']=$row[role];
                $_SESSION['logged_in'] = true;//to check if login or not
                header("Location: dzhang50_a3_view.php?pos_page=a");
            }else header("Location: $self");
        }else header("Location: $self");
    }
    myfooter();
?>