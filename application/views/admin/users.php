<h1>Összes felhasználó:</h1>

<table border="1" style="width:100%;">
	<tr>
		<th>
			ID
		</th>	
		<th>
			Felhasználónév
		</th>
		<th>
			Email
		</th>
		<th>
			Regisztrálás dátuma
		</th>		
		<th>
			Rank
		</th>
	</tr>
<? foreach($users as $user){ ?>
	<tr>
		<td>
			<? echo $user->id; ?>
		</td>	
		<td>
			<b><a href="<? echo URL;?>admin/users/<? echo $user->id; ?>"><? echo $user->username;?></a></b>
		</td>
		<td>
			<? echo $user->email;?>
		</td>
		<td>
			<? echo $user->date_registered;?>
		</td>		
		<td>
			<? echo $user->rank;?>
		</td>
	</tr>
<? } ?></table>