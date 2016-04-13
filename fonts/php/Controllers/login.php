


<?php
/**
 * Created by PhpStorm.
 * User: SZHAO
 * Date: 4/1/2016
 * Time: 1:24 PM
 */
//include '../DB_Managers/MySQL_Manager.php';

//登录
if(!isset($_POST['submit'])){
    // redirect to our login failed page
    echo "<script type='text/javascript'>
            window.location = \"../../pages/backoffice/index.php?p=login_failed\";
        </script>";
}
else{
    InputCheck();
}

function check_login_inDB($u,$p){

//    // connection
//    $MySqlDB = new stdClass();
//    $MySqlDB->host = 'localhost';
//    $MySqlDB->user = 'root';
//    $MySqlDB->password = '19900930';
//    $MySqlDB->port = 3306;
//    $MySqlDB->dbname = 'testDB';
//    $m = new MySQL_Manager($MySqlDB->host,$MySqlDB->user,$MySqlDB->password,$MySqlDB->port,$MySqlDB->dbname);
//
//    // verify the username and the password
//    $result = $m->query(
//        "select uid from users where username='" .$u."' and password='".$p."' limit 1");
//
//    return $result;
//
    return true;
}

function InputCheck()
{
    $username = htmlspecialchars(trim($_POST['login']));
    $password = MD5(trim($_POST['password']));

    $result = check_login_inDB($username, $password);

    /**
     * if login check failed
     */
    if (!$result) {

        // redirect to our login failed page
        echo "<script type='text/javascript'>
            window.location = \"../../pages/backoffice/index.php?p=login_failed\";
        </script>";
    }

    /**
     * if login successfully
     */
    else {

        session_start();
        $_SESSION['username'] = $username;

        // redirect to our login success page
        echo "<script type='text/javascript'>
            window.location = \"../../pages/backoffice/index.php?p=login_success\";
        </script>";

    }
}

