<?php
/**
 * Created by PhpStorm.
 * User: zhaoshichen
 * Date: 4/4/16
 * Time: 3:17 PM
 */
?>

<form class="form-1" name="LoginForm" method="post" action="../../php/Controllers/login.php">
					<p class="field">
						<input type="text" id= "login" name="login" placeholder="Username or email" required="required">
						<i class="icon-user icon-large"></i>
					</p>
						<p class="field">
							<input type="password" id="password" name="password" placeholder="Password" required="required">
							<i class="icon-lock icon-large"></i>
					</p>
					<p class="submit">
						<button type="submit" name="submit" id="submit"><i class="icon-arrow-right icon-large"></i></button>
					</p>
</form>