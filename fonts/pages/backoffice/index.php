<?php
$p = 'login';
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
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>HOC Back Office</title>

        <link rel="stylesheet" type="text/css" href="../../css/style.css" />
		<link rel="stylesheet" href="../../css/alertify.min.css">
		<link rel="stylesheet" href="../../css/themes/default.min.css">
		<link rel="stylesheet" type="text/css" href="../../css/table/normalize.css" />
		<link rel="stylesheet" type="text/css" href="../../css/table/component.css" />
		<link rel="stylesheet" type="text/css" href="../../css/menu/component.css" />

		<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
    </head>
    <body>
        <div class="container">
			
			<header>
			
				<h1>"H" of <strong>Customer</strong> Back Office</h1>
				<h2>For the Happiness of Decathlon Customer</h2>

				<div class="support-note">
					<span class="note-ie">Sorry, only modern browsers.</span>
				</div>
				
			</header>
			
			<section class="main">
				<?php
				switch($p) {
					case 'login':
						include 'login_form.php';
						break;
					case 'login_failed':
						include 'login_failed.php';
						break;
					case 'login_success':
						include 'login_success.php';
						break;
					default:
						include 'login_form.php';
						break;
				}
				?>
			</section>
        </div>
    </body>
</html>

<script src="../../js/modernizr.custom.63321.js"></script>
<script src="../../js/jquery.js"></script>
<script src="../../js/cbpHorizontalMenu.min.js"></script>
<script src="../../js/menu/Dashboard.js"></script>
<script src="../../js/table/jquery.stickyheader.js"></script>
<script>
	$(function() {
		cbpHorizontalMenu.init();
	});

//	$('.main').click(function(){
//
//		console.log("click on Menu ~");
//		console.log(document.getElementsByClassName("cbp-hropen").length);
//
//		setTimeout(function(){
//			/**
//			 * when the menu open, put down the content
//			 */
//			if(document.getElementsByClassName("cbp-hropen").length > 0){
//				document.getElementsByClassName("component")[0].style = "margin-top:10em";
//			}
//			/**
//			 * when the menu closes, put up the content
//			 */
//			else{
//				document.getElementsByClassName("component")[0].style = "";
//			}
//		},100);
//
//	})
</script>