<?php
$p = 'customer';
if(isset($_GET['p']))
    if(!is_null($_GET['p']))
    {
        $p = $_GET['p'];
    }

error_reporting(-1);
ini_set('display_errors', 'On');

echo $p

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>"H" of Customer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/jquery-ui.min.css" media="screen">
    <link rel="stylesheet" href="css/jquery-ui.structure.min.css" media="screen">
    <link rel="stylesheet" href="css/jquery-ui.theme.min.css" media="screen">
    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/themes/default.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/footer-distributed.css">
    <script src="js/jquery.js"></script>
  </head>
  <body style="background-color: #f5f5f5">
  <!--
  NAVABR
  -->
  <?php
  // class active pour le menu
  $loyaltyClass = "";
  $customerClass = "";
  $voucherClass = "";
  $purchaseClass = "";
  $pointsClass = "";

  switch($p){
      case 'loyalty':
          $loyaltyClass = " class=\"active\"";
          break;
      case 'customer':
          $customerClass = " class=\"active\"";
          break;
      case 'purchase':
          $purchaseClass = " class=\"active\"";
          break;
      case 'voucher':
          $voucherClass = " class=\"active\"";
          break;
      case 'points':
          $pointsClass = " class=\"active\"";
          break;
      default:
          $customerClass = " class=\"active\"";
          break;
  }

  ?>

  <nav class="navbar navbar-default navbar-fixed-top" style="font-weight: 700;">
      <div class="container" >
          <div class="navbar-header">
              <a class="navbar-brand" href="">"H" of Customer</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                  <li <?php echo $loyaltyClass;?>><a href="index.php?p=loyalty">Loyalty</a></li>
                  <li <?php echo $voucherClass;?>><a href="index.php?p=voucher">Voucher</a></li>
                  <li <?php echo $pointsClass;?>><a href="index.php?p=points">Points</a></li>
                  <li <?php echo $purchaseClass;?>><a href="index.php?p=purchase">Purchase</a></li>
                  <li <?php echo $customerClass;?>><a href="index.php?p=customer">Customer</a></li>
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
      case 'loyalty':
          include 'pages/loyalty.php';
          break;
      case 'customer':
          include 'pages/customer.php';
          break;
      case 'points':
          include 'pages/points.php';
          break;
      case 'purchase':
          include 'pages/purchase.php';
          break;
      case 'voucher':
          include 'pages/voucher.php';
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

  <footer class="footer-distributed">

      <div class="footer-right">

          <a href="#"><i class="fa fa-code"></i></a>
          <a href="#"><i class="fa fa-code-fork"></i></a>
          <a href="#"><i class="fa fa-cogs"></i></a>
          <a href="#"><i class="fa fa-coffee"></i></a>

      </div>

      <div class="footer-left">

          <p class="footer-links">
              <a href="#"></a>

              <a href="https://docs.google.com/spreadsheets/d/1YI82ZDBDmFSFRalvvcYVZAUpkTi2EmoXUuWCOr7sfGY/edit#gid=2022421715">
                  Project</a>
              ·
              <a href="mailto:shichen.zhao@decathlon.com">Contact</a>
          </p>

          <p>Provided by Decathlon IT - Asia Commerce Support Team &copy; 2016</p>
      </div>

  </footer>

  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>

  <!-- load all the main page JS files -->
  <script src="js/Main_page/Display.js"></script>
  <script src="js/Main_page/Select_Scripts.js"></script>
  <script src="js/Main_page/Time&Record.js"></script>
  <script src="js/Main_page/Triggers.js"></script>
  <script src="js/Main_page/Update_Scripts.js"></script>
  <script src="js/Main_page/Waiting.js"></script>

  <!-- incredible beautiful js file -->
  <script src="js/alertify.min.js"></script>

  <!-- nb of execution record js -->
  <script src="js/BackOffice/nb_execution_record.js"></script>
  </body>

</html>