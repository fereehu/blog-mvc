<!DOCTYPE html>

<head>
	<meta http-equiv="content-type">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?php echo  URL; ?>public/css/origo/origo.css" media="">
		<link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css' />
    <link href="<?php echo URL; ?>public/css/origo/style.css" rel="stylesheet">
    <link href="<?php echo URL; ?>public/css/globalstyle.css" rel="stylesheet">
    <meta name="description" content="<? echo SITEDESC;?>">
	<? include_once("./application/views/_templates/global.php"); ?>	



<title><? echo SITENAME; ?></title>


</head>

<body class="light blue smaller freestyle01">
<div id="layout">
 
	<div class="row smaller">
		<div class="col c5 smaller">
		<h1><a href="<?  echo SITEURL;?>"><? echo SITENAME; ?></a></h1>
		</div>
		
		<div class="col c7 aligncenter">
			<p class="slogan"><? echo SITEDESC;?></p>
		</div>
	</div>
  
	<div class="row">
		<div class="col c12 aligncenter">
			<img src="<?=URL;?>/public/img/origo/front.jpg" width="960" height="240" alt="" />
		</div>
	</div>
 
	<div class="row">
		<div class="col c2 alignleft">
		<ul class="menu">
  <? global $showpages;
  foreach($showpages as $page){ ?>		
			<li><a class="navitab" href="<? echo URL;?>pages/<?=$page->pageUrl;?>"><?=$page->pageName;?></a>
<? } ?>
		</ul>
		
		<h3><a href="<?=URL;?>blog/search/?search=">Keresés</a></h3>
	
<form method="get" action="<? echo URL;?>blog/search/">
<input type="text" name="search" size="15">
<input type="submit" value="Keresés">
</form>
<? if(LOGGED_IN == 1){ ?>
<h3 align="right">Szia <i><? echo USERNAME;?></i>!</h3>
<? } ?> 

		
	<ul class="menu">
<? if(RANK == 10){ ?><li><a href="<? echo URL?>admin">Admin menü</a></li><? } ?>
<? if(LOGGED_IN != 1){ ?><li><a href="<? echo URL?>login">Belépés</a></li><? } ?>
<? if(LOGGED_IN != 1){ ?><li><a href="<? echo URL?>login/reg">Regisztráció</a></li><? } ?>
<? if(LOGGED_IN == 1){ ?> <li><a href="<? echo URL?>login/profil">Profil</a></li> <? } ?>
<? if(LOGGED_IN == 1){ ?> 
				<ul class="subpages">
					<li><a href="<? echo URL?>login/logout">Kilépés</a></li> 
				</ul>
<? } ?>
				</ul>	
			<ul class="menu">
 <h3><a href="<? echo URL;?>blog/category" >Kategóriák</a></h3> 

<ul class="sidelink">
<? 
global $catAll; 
foreach($catAll as $cat){ ?>
	<li><a href="<? echo URL; ?>blog/category/<? echo $cat->categoryUrl;?>"><? echo $cat->categoryName;?></a></li>
	
	
<? } ?>
</ul>


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
		
			</ul>

			<ul class="menu">


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

			
			
			</ul>

		</div>
 
		<div class="col c10 mainContainer">

