
<form id="form" method="post" action="<?php echo URL; ?>login/forgotSetPassword">
    <input type="hidden" name="new_password" value="1">

    Írd be a titkos kódot!<br>   <input type="text" size="30" name="secret_code" value="<?php
    $url2=URL_PARAMETER2;
    if (!empty($url2)) {
        echo URL_PARAMETER2;
    } elseif (isset($_SESSION['secret_code'])) {
        echo $_SESSION['secret_code'];
    }
    ?>" placeholder="Írd be a titkos kódot!" required><br><br>
    Írd be az email címedet!<br>   <input type="email" size="30" name="email" placeholder="Írd be az email címedet!" required><br><br>Írd be az új jelszavadat<br> <br>
    <input type="password" size="30"name="new_psw1" placeholder="Írd be az új jelszavadat" required><br><br>Írd be az új jelszavadat mégegyszer<br><br>
    <input type="password" size="30" name="new_psw2" placeholder="Írd be az új jelszavadat mégegyszer" required=""><br><br>
    <input type="submit" class="changepassword" name="changepassword">
</form>
<!---<div class="showError"></div>--->

<script>
    /*  $('#form').on("submit", function (e) {
     e.preventDefault();
     var psw1 = $("input[name=new_psw1]").val();
     var psw2 = $("input[name=new_psw2]").val();
     if (psw1 != psw2) {
     $(".showError").text("A két jelszó nem egyezik!");
     alert('hiba');
     return false;
     } else {
     $('.changepassword').submit();
     }
     });
     
     *
     *Ezzel az egésszel most az volt a baj, hogy nem küldte el a formot. Kellett volna ajaxot használni, dehátna.(=lustaság:D)*/
</script>
