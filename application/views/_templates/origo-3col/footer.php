	</div>	<div class="col c2">
<? if(COMMENTNUMSIDEBAR != 0){ ?>
<h3>Hozzászólások</h3>

<? global $showcomments;
foreach($showcomments as $comments){ ?>
    <b> <?=$comments->username;?></b><br> írta:
    <font style="color:#f5f5f5;"  size="1">
 <span	class="onmouse"><?=$comments->commentdate;?><br><a href="<?=URL;?>blog/<?=$comments->postUrl;?>#<?=$comments->commentid;?>"><?=$comments->comment;?></a></span>
	<br><br>
	</font>

<? 	} 
	}?>
			<p><?=SITEDESC2;?></p>
<img class="photo" src="<? echo URL;?>public/img/vote.png" height="100" alt="" width="130" >
			Bejegyzések száma: 
<b><?
global $amount_of_posts;
echo $amount_of_posts;
?></b>

Hozzászólások: <b><?
global $amount_of_comments;
echo $amount_of_comments;
?></b>

			<ul class="sidelink">
<? if(LINKHEADER1 != null and LINKHEADER2 != null and LINKHEADER3 != null) { ?>
<div id="toptabs">
 <h3>Linkek</h3> 
<?if(LINKHEADER1 != null AND LINKHEADERURL1 != null){ ?>
<li><a class="toptab" href="<? echo LINKHEADERURL1;?>"><? echo LINKHEADER1; ?></a><span class="hide"> | </span>
<?}?>
<?if(LINKHEADER2 != null AND LINKHEADERURL2 != null){ ?>
<li><a class="toptab" href="<? echo LINKHEADERURL2;?>"><? echo LINKHEADER2; ?></a><span class="hide"> | </span>
<?}?>
<?if(LINKHEADER3 != null AND LINKHEADERURL3 != null){ ?>
<li><a class="toptab" href="<? echo LINKHEADERURL3;?>"><? echo LINKHEADER3; ?></a><span class="hide"> | </span>
<?}?>
</div>
<? } ?>
</ul>
			
			
		</div>
	</div>
 
	<div id="footer" class="row">
		<div class="col c12 aligncenter">
       <?php include_once("./application/views/_templates/global_footer.php"); ?>	

		</div>
	</div>
 </div>
</body>
</html>