<?php

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
                    <li>
                        <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                </ul>
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Unsubscribed - CN</a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="font-size:36px">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red" id="panel_of_unsubscription">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-close fa-5x" id="icon_of_unsubscription"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge" id="numberThirty">?</div>
                                <div>Unsubscribed - CN</br>Last 30 days</div>
                            </div>
                        </div>
                    </div>
                    <a id="fixnow" onclick="recoverSubscription()">
                        <div class="panel-footer">
                            <span class="pull-left">Fix now!</span>
                        <span class="pull-right">
                            <i class="fa fa-arrow-circle-right">
                            </i>
                        </span>
                            <div class="clearfix">
                            </div>
                        </div>
                    </a>
                    <div class="bs-example" id="progress_bar_recovery" style="display:none">
                        <div class="progress progress-striped active">
                            <div class="progress-bar" style="margin-left:1%;margin-right:1%;width: 3%"></div>
                        </div>
                    </div>
                    <a id="forceupdate" onclick="forceUpdate()">
                        <div class="panel-footer">
                            <span class="pull-left">Refresh the data</span>
                        <span class="pull-right">
                            <i class="fa fa-arrow-circle-right">
                            </i>
                        </span>
                            <div class="clearfix">
                            </div>
                        </div>
                    </a>
                    <div class="bs-example" id="progress_bar_force_update" style="display:none">
                        <div class="progress progress-striped active">
                            <div class="progress-bar" style="margin-left:1%;margin-right:1%;width: 3%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading" style="background-color: grey">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">12</div>
                                <div>To define</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading" style="background-color: grey">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">124</div>
                                <div>To define</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading" style="background-color: grey">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-support fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">13</div>
                                <div>To define</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Unsubscribed - CN - Data
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    Last 7 days
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li><a>Last 7 days</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div id="morris-area-chart"></div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-8 -->
        </div>
        <!-- /.row -->
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
