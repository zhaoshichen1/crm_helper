<?php

error_reporting(-1);
ini_set('display_errors', 'On');

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>"H" of Customer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="../css/footer-distributed.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/component.css">
</head>
<body style="background-color: #f5f5f5">

    <form action="php/Controllers/upload_file.php" method="post"
          enctype="multipart/form-data" style="text-align:center;font-family:'Trebuchet MS'" onclick="change()">
        <br />
        <label for="file" class="custom-file-upload" id="label"><i class="fa fa-cloud-upload"></i> Choose your CSV File</label>
        <br />
            <input type="file" name="file" id="file" onclick="function(){
            document.getElementById('label').textContent = document.getElementById('file').value;
        }" />
        <br />
        <div class="upload">
        <input type="submit" name="submit" value="Submit" class="submit" />
        </div>
    </form>
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

<script>
    function change(){
        setTimeout(function(){
            document.getElementById('label').textContent = 'File Selected';
        },3000)
    }
</script>

</html>
