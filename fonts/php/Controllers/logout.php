<?php
/**
 * Created by PhpStorm.
 * User: zhaoshichen
 * Date: 4/4/16
 * Time: 6:05 PM
 */

    unset($_SESSION['username']);
    // redirect to our login failed page
    echo "<script type='text/javascript'>
            window.location = \"../../pages/backoffice/index.php\";
        </script>";
