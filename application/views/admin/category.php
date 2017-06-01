Összes kategória: 
<br>Kategória módosítása: (Katt rá)<br>
<? foreach($categorys as $category){ ?>
	<a href="<? echo URL;?>admin/category/<? echo $category->id; ?>"><? echo $category->categoryName;?></a><br>
	
<? } ?>