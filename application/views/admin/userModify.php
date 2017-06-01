<? foreach($users as $user){ ?>
<table>

<form action="<?=URL;?>admin/users/<? echo $user->id;?>/userAction" method="post">
<input type="hidden" value="<?echo $user->id;?>" name="id">
  <tr>
    <td>Név </td>		
    <td><input type="text" name="username" value="<? echo $user->username;?>" required="required"></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><input type="email" name="email" value="<? echo $user->email;?>" required="required"></td>		
  </tr>
  <tr>
    <td>Regisztrálás időpontja</td>
    <td><? echo $user->date_registered;?></td>		
  </tr>
  <tr>
    <td>Rank</td>
    <td>
		<select name="rank">
			<option value="10" <?echo ($selected = ($user->rank == 10)) ? "selected='selected'" : ""?>>10 - Admin	
			<option value="0" <?echo ($selected = ($user->rank == 0)) ? "selected='selected'" : ""?>>0 - Sima user
		</select>
  </tr>
  <tr>
    <td></td>
    <td>
		<input type="submit">
  </tr>  
  
</table>
</form>
<script type="text/javascript">
<!--
function confirmation() {
	var answer = confirm("Valóban törölni szeretnéd a <?=$user->username;?> nevű felhasználót?")
	if (answer){
		window.location = "<? echo URL;?>admin/users/<?=$user->id;?>/delUser";
	}
}
//-->
</script>
	<a href="#" onclick="confirmation();">Felhasználó törlése (katt)</a>
<br>
<? } ?>