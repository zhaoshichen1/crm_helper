<?php
/**
 * Created by PhpStorm.
 * User: zhaoshichen
 * Date: 6/2/16
 * Time: 12:16 AM
 */




?>

<html>
<body>

<form action="php/Controllers/upload_file.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<br />
<input type="submit" name="submit" value="Submit" />
</form>

</body>
</html>