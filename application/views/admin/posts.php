 
<h1>Bejegyzések szerkesztése</h1>

<? foreach($posts as $post){ ?>


<? echo $post->postDate;?>	<a href="<? echo URL;?>admin/posts/<? echo $post->id; ?>"><? echo $post->postName;?></a>

[<a href="<? echo URL;?>admin/posts/postDel/<? echo $post->id; ?>">X</a>]
<br>
	
<? } ?>
