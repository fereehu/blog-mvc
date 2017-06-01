<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Telepítés</title>
<link rel="stylesheet" type="text/css" href="view/view.css" media="all">
<script type="text/javascript" src="view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="view/top.png" alt="">
	<div id="form_container">
	
		<h1><a>Onlineszemetes telepítése</a></h1>
		<form id="install" class="appnitro"  method="post" action="index.php">
					<div class="form_description">
			<h2>Telepítés</h2>
			<p>Kérlek minden mezőt tölts ki a sikeres telepítés érdekében.  </p>
			<p>Majdnem minden adat módosítható a későbbiekben. (Az sql nem)  </p>
		</div>		

<h3>Adatbázis adatok</h3>		
			<ul >
					<li id="li_1" >
		<label class="description" for="element_1">Adatbázis típusa </label>
		<div>
			<input id="element_1" name="db_type" class="element text large" type="text" maxlength="255" value="mysql" required="required"/> 
		</div> <p class="guidelines" id="guide_3"><small>Maradjon mysql</small></p> 
		</li>
					<li id="li_1" >
		<label class="description" for="element_1">Adatbázis felhasználó neve </label>
		<div>
			<input id="element_1" name="db_user" class="element text large" type="text" maxlength="255" value="<?=$_SESSION['db_user'];?>" required="required" /> 
		</div> <p class="guidelines" id="guide_3"><small>Pl root</small></p> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Adatbázis neve </label>
		<div>
			<input id="element_2" name="db_name" class="element text large" type="text" maxlength="255" value="<?=$_SESSION['db_name'];?>"/> <p class="guidelines" id="guide_3"><small>Muszáj, hogy létezzen az adatbázis, akkor is, ha root jogunk van. Ezt kell egyedül létrehozni az SQL-ben. </small></p> 
		</div> 
		</li>		<li id="li_3" >
		<label class="description" for="element_3">Adatbázis host</label>
		<div>
			<input id="element_3" name="db_host" class="element text large" type="text" maxlength="255" value="<?=$_SESSION['db_host'];?>" required="required"/> 
		</div> <p class="guidelines" id="guide_3"><small>Általában localhost</small></p> 
		</li>		<li id="li_4" >
		<label class="description" for="element_4">Adatbázis jelszó </label>
		<div>
			<input id="element_4" name="db_pass" class="element text large" type="text" maxlength="255" value="<?=$_SESSION['db_pass'];?>"/> 
		</div> 
		</li>		<li id="li_5" >
		<label class="description" for="element_5">Adatbázis prefix </label>
		<div>
			<input id="element_5" name="db_prefix" class="element text large" type="text" maxlength="255" value="osz_" required="required"/> 
		</div><p class="guidelines" id="guide_5"><small>Ez lesz a táblák prefixe</small></p> 
		</li>
			
			<h3>Oldal adatok</h3>		
			<ul >
					<li id="li_1" >
		<label class="description" for="element_1">Oldal URL  </label>
		<div>
			<input id="element_1" name="siteurl" class="element text large" type="text" maxlength="255" value="<?=$_SESSION['siteurl'];?>" required="required"/> 
		</div> <p class="guidelines" id="guide_3"><small>(Fontos: / legyen a végén!!!) Pl http://sajatdomain.com/asd/</small></p> 
		</li>
					<li id="li_1" >
		<label class="description" for="element_1">Oldal neve </label>
		<div>
			<input id="element_1" name="sitename" class="element text large" type="text" maxlength="255" value="<?=$_SESSION['sitename'];?>" required="required" /> 
		</div> <p class="guidelines" id="guide_3"><small>Az oldal neve, ami a címsorban, és sok helyen megjelenik. Eredetileg [Feree lomtára] volt</small></p> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Oldal leírása </label>
		<div>
			<input id="element_2" name="sitedesc" class="element text large" type="text" maxlength="255" value="<?=$_SESSION['sitedesc'];?>" required="required" /> <p class="guidelines" id="guide_3"><small>Muszáj, hogy létezzen az adatbázis, akkor is, ha root jogunk van. Ezt kell egyedül létrehozni az SQL-ben. </small></p> 
		</div> 
		</li>		<li id="li_3" >
		<label class="description" for="element_3">Oldal leírása 2</label>
		<div>
			<input id="element_3" name="sitedesc2" class="element text large" type="text" maxlength="255" value="<?=$_SESSION['sitedesc2'];?>" required="required"/> 
		</div> <p class="guidelines" id="guide_3"><small>Egy hosszabb leírás az oldalról.</small></p> 
		</li>		
			
			<h3>Admin adatok</h3>		
			<ul >
					<li id="li_1" >
		<label class="description" for="element_1">Admin felhasználó neve  </label>
		<div>
			<input id="element_1" name="adminusername" class="element text large" type="text" maxlength="255" value="<?=$_SESSION['adminusername'];?>" required="required"/> 
		</div>  
		</li>
					<li id="li_1" >
		<label class="description" for="element_1">Admin jelszó </label>
		<div>
			<input id="element_1" name="adminpassword" class="element text large" type="password" maxlength="255" value="<?=$_SESSION['adminpassword'];?>" required="required" /> 
		</div> 
		</li>		<li id="li_2" >
		<label class="description" for="element_2">Admin email címe  </label>
		<div>
			<input id="element_2" name="adminemail" class="element text large" type="email" maxlength="255" value="<?=$_SESSION['adminemail'];?>" required="required" /> 
		</div> 
		</li>		
		
		
					<li class="buttons">
			    <input type="hidden" name="form_id" value="910412" />
			    
				<input class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>



			
			
			
			
			
		</form>	

	</div>
	<img id="bottom" src="view/bottom.png" alt="">
	</body>
</html>