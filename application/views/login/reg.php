<h2>Regisztráció</h2>


<form action="<?php echo URL; ?>login/regdata" method="post">
    <input type="hidden" name="regdata" value="1">


    <table style="width:100%">
        <tr>
            <td>Felhasználó név:</td>
            <td>  <input type="text" name="reg_username" pattern=".{4,25}" value="<?php if (isset($_SESSION['reg_username'])) {
    echo $_SESSION['reg_username'];
} ?>"  required="required">

            </td>		

        </tr>
        <tr>
            <td>Email:</td>
            <td>  <input type="email" name="reg_email" value="<?php if (isset($_SESSION['reg_email'])) {
    echo $_SESSION['reg_email'];
} ?>" required="required">

            </td>		

        </tr>  
        <tr>
            <td>Jelszó:</td>
            <td>  <input type="password" name="reg_password" pattern=".{8,16}"
                   required="required">

            </td>		

        </tr>
        <tr>
            <td> Jelszó még egyszer:</td>
            <td>      <input type="password" name="reg_password2"  required="required">


            </td>		

        </tr>
    </table>

    

    <br>
    <input type="submit">
</form>