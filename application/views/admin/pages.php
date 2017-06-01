  
<h1>Oldalak szerkesztése</h1>

<? foreach($pages as $page){ ?>


<? echo $page->pageDate;?>	<a href="<? echo URL;?>admin/pages/<? echo $page->id; ?>"><? echo $page->pageName;?></a>

[<a href="<? echo URL;?>admin/pages/pageDel/<? echo $page->id; ?>">X</a>]
<br>
	
<? } ?>
