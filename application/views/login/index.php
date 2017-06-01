<h1>Bejelentkezés</h1>
<form action="<?php echo URL;?>login/getlogin" method="post">
<input type="hidden" name="getLogin" value="1">
<table style="width:100%">
  <tr>
    <td>Email:</td>
    <td> <input type="email" name="email"  required="required">
</td>		

  </tr>
  <tr>
    <td>Jelszó:</td>
    <td> <input type="password" name="password"  required="required">
</td>		

  </tr>

</table>
<br>

<br>
<input type="submit">
</form>

<a href="<?=URL?>login/forgotpassword">Jelszó emlékeztető</a>