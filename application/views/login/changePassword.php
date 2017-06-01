<h2 class="blog-post-title">Jelszó változtatás</h2>

<form method="post" action="<?php echo URL;?>login/setPassword">
    
    <input type="password" name="old_password" placeholder="Régi jelszó">
    <br>
    <br>
    <input type="password" name="new_password1" placeholder="Új jelszó">
    <br>
    <br>
    <input type="password" name="new_password2" placeholder="Új jelszó mégegyszer">
    <br>
    <br>
    <input type="submit">
</form>