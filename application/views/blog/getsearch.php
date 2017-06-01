<? include('search.php'); ?>

<? if(count($getsearch) == 0){ ?>
<h3>Sajnálom, nincs találat a következőre:</h3> <h2 align="center"><?=$_GET['search'];?></h2>
<? } ?><br>
<? foreach($getsearch as $post){ ?>
	<p class="timestamp"><? echo $post->postDate; ?>  | <b><a href="<? echo URL;?>blog/<? echo $post->postUrl; ?>"><? echo $post->postName; ?></a>			 | 
		<a href="<?=URL;?>blog/<?=$post->postUrl;?>#comment"> 
			<?=$blog_model->getCommentNumByPostId($post->postid);?> hozzászólás
		</a>
			</b><br><font size=1><em><? echo $post->categoryName; ?></em></font></p>
			<? echo $blog_model->galleryBBcode($post->postContent); ?>
	<hr>
<? } ?>