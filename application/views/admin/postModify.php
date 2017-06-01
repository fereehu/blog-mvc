 <script src="<? echo URL;?>public/js/ckeditor/ckeditor.js"></script>
<h1>Post szerkesztése</h1>

<? foreach($posts as $post){ ?>
<form action="<? echo URL;?>admin/posts/<?echo $post->id;?>/" method="post"><br>
<input type="hidden" value="<?echo $post->id;?>" name="postid">
Bejegyzés neve: <input type="text" name="postName" value="<? echo $post->postName;?>" required="required"><br>
Bejegyzés linkje:
<input type="text" name="postUrl" value="<? echo $post->postUrl;?>"><br>
Tartalom: <br>
<textarea class="ckeditor" name="postContent"><? echo $post->postContent;?></textarea>
<br>
Kategória: 	<select name="postCategory"><? foreach($categorys as $category){ ?>


		<option value="<? echo $category->id;?>" <?
		if($category->id == $post->postCategory){ echo "selected=\"selected\""; }
		?>><? echo $category->categoryName;?>

<? } ?></select><a target="_blank" href="<?=URL;?>blog/<?=$post->postUrl;?>"><h3 align="right">Megtekintés</h3></a>

<a target="_blank" href="<?=URL;?>admin/posts/postDel/<?=$post->id;?>"><h3 align="right">Törlés</h3></a>
<a href="<?=URL;?>admin/posts/"><h3 align="right">Mégsem</h3></a>

<? } ?>	


<input type="submit">

</form>