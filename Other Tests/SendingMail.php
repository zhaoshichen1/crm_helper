<?php
$p = 'loyalty';
if(isset($_GET['p']))
    if(!is_null($_GET['p']))
    {
        $p = $_GET['p'];
    }

error_reporting(-1);
ini_set('display_errors', 'On');
include 'php/credential.php';
include 'php/Manager.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>CRM helper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="../css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="../css/jquery-ui.min.css" media="screen">
    <link rel="stylesheet" href="../css/jquery-ui.structure.min.css" media="screen">
    <link rel="stylesheet" href="../css/jquery-ui.theme.min.css" media="screen">
    <link rel="stylesheet" href="../css/font-awesome.min.css" media="screen">
      <script src="../js/jquery.js"></script>
  </head>
  <body style="background-color: #f5f5f5">
  <!--
  NAVABR
  -->
  <?php
  // class active pour le menu
  $loyaltyClass = "";
  $dkcardClass = "";
  $customerClass = "";

  switch($p){
      case 'loyalty':
          $loyaltyClass = " class=\"active\"";
          break;
      case 'customer':
          $customerClass = " class=\"active\"";
          break;
      case 'dkcard':
          $dkcardClass = " class=\"active\"";
          break;
      default:
          $dkcardClass = " class=\"active\"";
          break;
  }

  ?>

  <nav class="navbar navbar-default navbar-fixed-top" style="font-weight: 700;">
      <div class="container" >
          <div class="navbar-header">
              <a class="navbar-brand" href="">CRM helper</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                  <li <?php echo $dkcardClass; ?>><a href="SendingMail.php?p=dkcard">Dkcard</a></li>
                  <li <?php echo $loyaltyClass;?>><a href="SendingMail.php?p=loyalty">Loyalty</a></li>
                  <li <?php echo $customerClass;?>><a href="SendingMail.php?p=customer">Customer</a></li>
              </ul>
          </div>
      </div>
  </nav>

  <!--
 //NAVABR
 -->
  <div class="container-fluid" style="padding-top: 80px;">
  <?php
  switch($p){
      case 'dkcard':
          include 'pages/dkcard.php';
          break;
      case 'loyalty':
          include 'pages/loyalty.php';
          break;
      case 'customer':
          include 'pages/customer.php';
          break;
      case 'creator':
          echo '<br/><br/><br/><br/><br/><br/><h1 style="width: 914px; box-shadow: 13px 13px 7px #888888; background-color: #001244; margin-left: 27%; font-weight: 700; color: #00c21f; padding: 25px; border: 2px solid black; border-radius: 8px;">Made with love by Pierre Bodot  :-) </h1>';
          break;
      default:
          include 'pages/loyalty.php';
          break;
  }
  ?>
</div>

  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/jquery-ui.min.js"></script>
  <script src="../js/app.js"></script>
  </body>

</html>