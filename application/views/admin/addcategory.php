Kategória hozzáadása:<br><br>

<form action="<? echo URL;?>admin/addcategory" method="post">
	Név: <input type="text" name="categoryName" required="required"><br>
	Link: <input type="text" name="categoryUrl" required="required">
	<br>Menüben megjelenjen? <select name="menuShow">
		<option value="yes">Igen
		<option value="no">Nem
	</select><br><br>
	<input type="submit">
</form>