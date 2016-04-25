<?php

error_reporting(-1);
ini_set('display_errors', 'On');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>"H" of Customer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="../css/footer-distributed.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css" media="screen">
</head>
<body style="background-color: #f5f5f5">
<img id="image" src="../images/under-construction.jpg" style="margin-top:3%">
</body>
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
            <a href="index.php">Troubleshoot</a>
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

<script type="text/javascript">

    /**
     * use javascript to change the size of the picture dynamically
     */
    function size_calculate(){
        var globalW = document.body.offsetWidth;
        var imageW = document.getElementById("image").offsetWidth;
        var percentage = (globalW-imageW)/2/globalW*100;
        document.getElementById("image").style.marginLeft = percentage+"%";
    }
    window.onload = size_calculate();
</script>

</html>
