 <script src="<? echo URL;?>public/js/ckeditor/ckeditor.js"></script>
<h1>Oldal szerkesztése</h1>

<? foreach($pages as $page){ ?>
<form action="<? echo URL;?>admin/pages/<?echo $page->id;?>/" method="post"><br>
<input type="hidden" value="<?echo $page->id;?>" name="pageid">
Oldal neve: <input type="text" name="pageName" value="<? echo $page->pageName;?>" required="required"><br>
Oldal linkje:
<input type="text" name="pageUrl" value="<? echo $page->pageUrl;?>"><br>
Tartalom: <br>
<textarea class="ckeditor" name="pageContent"><? echo $page->pageContent;?></textarea>
<input type="number" name="ordering" value="<? echo $page->ordering;?>"><br>


<a target="_blank" href="<?=URL;?>pages/<?=$page->pageUrl;?>"><h3 align="right">Megtekintés</h3></a>

<a target="_blank" href="<?=URL;?>admin/pages/pageDel/<?=$page->id;?>"><h3 align="right">Törlés</h3></a>
<a  href="<?=URL;?>admin/category/"><h3 align="right">Mégsem</h3></a>

<? } ?>	


<input type="submit">
</form>