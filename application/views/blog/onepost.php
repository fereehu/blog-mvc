<? foreach($onepost as $post){ ?>


	<p class="timestamp"><? echo $post->postDate; ?>  | <b><a href="<? echo URL;?>blog/<? echo $post->postUrl; ?>"><? echo $post->postName; ?></a>
				 | 
		<a href="<?=URL;?>blog/<?=$post->postUrl;?>#comment"> 
			<?=$blog_model->getCommentNumByPostId($post->postid);?> hozzászólás
		</a>
			
	</b><br>
	<font size="1"><em>
	<? if(isset($post->postEditDate) and $post->postEditDate != '0000-00-00 00:00:00'){ ?>
	Módosítva: <?=$post->postEditDate;?><br>
	<? } ?>
	<? echo $post->categoryName; ?></em></font></p>
			<? echo $blog_model->galleryBBcode($post->postContent); ?>		
			<?if(RANK==10){ ?>
	<em><a href="<?=URL;?>admin/posts/<?=$post->id;?>">Szerkesztés</a></em>
			<?}?>
<? } ?>