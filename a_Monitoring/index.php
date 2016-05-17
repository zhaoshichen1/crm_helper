<?php
$p = 'Dashboard';
if(isset($_GET['p']))
    if(!is_null($_GET['p']))
    {
        $p = $_GET['p'];
    }

error_reporting(-1);
ini_set('display_errors', 'On');

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>"H" of Customer</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="bower_components/morrisjs/morris.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/footer-distributed.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css" media="screen">

    <!-- Alertify CSS -->
    <link rel="stylesheet" href="../css/alertify.min.css">
    <link rel="stylesheet" href="../css/themes/default.min.css">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!--
  NAVABR

<?php
// class active pour le menu
$DashboardClass = "";
$recoverSubscriptionClass = "";

switch($p){
    case 'recoverSubscription':
        $recoverSubscriptionClass = " class=\"active\"";
        break;
    case 'Dashboard':
        $DashboardClass = " class=\"active\"";
        break;
    default:
        $DashboardClass = " class=\"active\"";
        break;
}

?>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">"H" of Customer</a>
        </div>
        <!-- /.navbar-header -->


        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li <?php echo $DashboardClass;?>>
                        <a href="index.php?p=Dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                </ul>
                <ul class="nav" id="side-menu">
                    <li <?php echo $recoverSubscriptionClass;?>>
                        <a href="index.php?p=recoverSubscription"><i class="fa fa-dashboard fa-fw"></i> Unsubscribed - CN</a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <?php
        switch($p){
            case 'Dashboard':
                include 'pages/Dashboard.php';
                break;
            case 'recoverSubscription':
                include 'pages/recoverSubscription.php';
                break;
            case 'creator':
                echo '<br/><br/><br/><br/><br/><br/><h1 style="width: 914px; box-shadow: 13px 13px 7px #888888; background-color: #001244; margin-left: 27%; font-weight: 700; color: #00c21f; padding: 25px; border: 2px solid black; border-radius: 8px;">Made with love by Pierre Bodot  :-) </h1>';
                break;
            default:
                include 'pages/Dashboard.php';
                break;
        }
        ?>
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="bower_components/raphael/raphael-min.js"></script>
<script src="bower_components/morrisjs/morris.min.js"></script>
<script src="js/morris-data.js"></script>

<!-- Custom Theme JavaScript -->
<script src="dist/js/sb-admin-2.js"></script>

<!-- incredible beautiful js file -->
<script src="../js/alertify.min.js"></script>
<script src="js/Time&Record.js"></script>
<script src="js/Display_change.js"></script>
<script src="js/Refresh_Data.js"></script>
<script src="js/Massive_Subscription_Recovery.js"></script>
<script src="http://l2.io/ip.js?var=myip"></script>

<!-- nb of execution record js -->
<script src="../js/BackOffice/nb_execution_record.js"></script>
</body>


<footer class="footer-distributed">

    <div class="footer-right">

        <a href="#"><i class="fa fa-code"></i></a>
        <a href="#"><i class="fa fa-code-fork"></i></a>
        <a href="#"><i class="fa fa-cogs"></i></a>
        <a href="#"><i class="fa fa-coffee"></i></a>

    </div>

    <div class="footer-left">

        <p class="footer-links">
            <a href="../a_Troubleshooting/index.php">Troubleshoot</a>
            ·
            <a href="../a_Reporting/index.php">Report</a>
            ·
            <a href="../a_Monitoring/index.php">Monitor</a>
            ·
            <a href=
                       "https://docs.google.com/a/decathlon.com/forms/d/1Hq3v9bzscrTPlW7e4ZnAra0K-_LTBxYTX8_gD4eWA7A/viewform">
                Contact</a>
        </p>

        <p>Provided by Decathlon IT - Asia Commerce Support Team &copy; 2016</p>
    </div>

</footer>


</html>
