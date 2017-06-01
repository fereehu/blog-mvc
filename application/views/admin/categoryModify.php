Kategória módosítása:
<br>
<? foreach($categorys as $category){ ?>

<form action="<? echo URL;?>admin/categoryAction" method="post">
<input type="hidden" name="id" value="<? echo $category->id;?>">
Név: <input type="text" name="categoryName" value="<? echo $category->categoryName;?>" required="required"><br>

Link: <input type="text" name="categoryUrl" value="<? echo $category->categoryUrl;?>" required="required">
<br>
Menüben megjelenjen? <select name="menuShow">
<option value="yes" <?  echo "".(($selected = ($category->menuShow == 'yes')) ? "selected=\"selected\"" : "").""; ?>>Igen
<option value="no" <?  echo "".(($selected = ($category->menuShow == 'no')) ? "selected=\"selected\"" : "").""; ?>>Nem
</select>
<input type="submit">


</form>	

<script type="text/javascript">
<!--
function confirmation() {
	var answer = confirm("Valóban törölni szeretnéd a <? echo $category->categoryName;?> kategóriát? \n\n A postok nem törlődnek!")
	if (answer){
		window.location = "<? echo URL;?>admin/delcategory/<? echo $category->id;?>";
	}
}
//-->
</script>
	<a href="#" onclick="confirmation();">Kategória törlése (katt)</a>
<a  href="<?=URL;?>admin/category/">Mégsem</a>

<? } ?>