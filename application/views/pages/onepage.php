 <? foreach($onepage as $page){ ?>


	<h1><? echo $page->pageName; ?></h1>
			<? echo $page->pageContent; ?>	
			
			<?if(RANK==10){ ?><br>
	<em><a href="<?=URL;?>admin/pages/<?=$page->id;?>">Szerkesztés</a></em>
			<?}?>
<? } ?>
