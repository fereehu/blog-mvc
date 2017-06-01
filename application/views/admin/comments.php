<? foreach($getComments as $comment){ ?>
<script type="text/javascript">
<!--
function confirm<?=$comment->commentid;?>() {
	var answer = confirm("Valóban törölni szeretnéd a <? echo $comment->commentid;?>. számú kommentet? \n\n Nem visszavonható!")
	if (answer){
		window.location = "<? echo URL;?>admin/comments/delComment/<? echo $comment->commentid;?>";
	}
}
//-->
</script>

<p></p>
#<?=$comment->commentid;?><font id="<?=$comment->commentid;?>" size="3"><b>
<? if($comment->userurl){ ?>
<a href="<?=$comment->userurl;?>">
	<?=$comment->username;?>
</a><? }else echo $comment->username;?>

</b></font> 
		<font><a href="<?=URL;?>blog/<?=$comment->postUrl;?>#<?=$comment->commentid;?>"><?=$comment->commentdate;?></a></font>
<a href="<?=URL;?>blog/<?=$comment->postUrl;?>"><?=$comment->postName;?></a> [<a href="<?=URL;?>admin/comments/delComment/<?=$comment->commentid;?>" onclick="confirm<?=$comment->commentid;?>();">X</a>]
<p class='block'> <?=nl2br($comment->comment);?></p>


<? } ?>
