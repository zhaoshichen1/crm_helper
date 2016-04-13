<?php
/**
 * Created by PhpStorm.
 * User: zhaoshichen
 * Date: 4/4/16
 * Time: 3:28 PM
 */
?>

<script type='text/javascript'>

    var A_js = document.createElement("script");
    A_js.src = "../../js/alertify.min.js";

    document.head.appendChild(A_js);

    /**
     * show the error of login failed
     */
    setTimeout(function(){
        alertify.error("Login Failed!");
    },100);

    setTimeout(function(){
        alertify.error("Incorrect Password or Username!");
    },800)

    setTimeout(function(){
        alertify.alert('You will be redirected to the login page.').set({onclose:function(){ window.location = "index.php" }});
        document.getElementsByClassName("ajs-header")[0].textContent = "Login Failed";
    },1200)

</script>
