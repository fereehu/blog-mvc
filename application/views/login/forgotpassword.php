<h1>Jelszó emlékeztető</h1>

<h3>
    Kérjük, add meg az e-mail címed, amellyel oldalunkra regisztráltál. A megadott címre küldünk egy linket, amelyre kattintva jelszavad módosíthatod!
</h3>

<form action="<?php echo URL; ?>login/forgotpassword" method="post">
    <input type="hidden" name="forgotpassword" value="1">

    Email: <input type="email" name="email"  required="required">

    <br>
    <input class="forgotpasswordSubmit" type="submit">
</form>
