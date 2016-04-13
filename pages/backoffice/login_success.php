<?php

session_start();

$module = '';
if(isset($_GET['module']))
    if(!is_null($_GET['module']))
    {
        $module = $_GET['module'];
    }

if(!isset($_SESSION['username'])){
    //header('Location: '.'index.php');
    die();
}

//else{
//    echo($_SESSION['username']);
//}

?>

    <div class="main">
        <nav id="cbp-hrmenu" class="cbp-hrmenu">
            <ul>
                <li>
                    <a href="#">Element Management</a>
                    <div class="cbp-hrsub">
                        <div class="cbp-hrsub-inner">
                            <div>
                                <h4>Page</h4>
                                <ul>
                                    <li><a href="index.php?p=login_success&module=page">List the data</a></li>
                                </ul>
                            </div>
                            <div>
                                <h4>Functionality</h4>
                                <ul>
                                    <li><a href="index.php?p=login_success&module=functionality">List the data</a></li>
                                </ul>
                            </div>
                        </div><!-- /cbp-hrsub-inner -->
                    </div><!-- /cbp-hrsub -->
                </li>
                <li>
                    <a href="#">User Settings</a>
                    <div class="cbp-hrsub">
                        <div class="cbp-hrsub-inner">
                            <div>
                                <h4>Account</h4>
                                <ul>
                                    <li><a href="../../php/Controllers/logout.php">Logout</a></li>
                                </ul>
                            </div>
                        </div><!-- /cbp-hrsub-inner -->
                    </div><!-- /cbp-hrsub -->
                </li>
            </ul>
        </nav>
    </div>

    <?php
    switch($module) {
        case 'page':
            include 'success_modules/page_list.php';
            break;
        case 'functionality':
            include 'success_modules/function_list.php';
            break;
        default:
            break;
    }
    ?>
