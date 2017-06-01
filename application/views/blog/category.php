<h1>Összes kategória</h1> <? foreach($categorys as $category){ ?>


	<a href="<? echo URL;?>blog/category/<? echo $category->categoryUrl; ?>"><? echo $category->categoryName;?></a><br>
	
<? } ?>
