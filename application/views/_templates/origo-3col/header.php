<!DOCTYPE html>

<head>
	<meta http-equiv="content-type">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?php echo  URL; ?>public/css/origo/origo.css" media="">
		<link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css' />
    <link href="<?php echo URL; ?>public/css/origo/style.css" rel="stylesheet">
    <link href="<?php echo URL; ?>public/css/globalstyle.css" rel="stylesheet">
    <meta name="description" content="<?php echo SITEDESC;?>">
	<?php include_once("./application/views/_templates/global.php"); ?>	




<title><?php echo SITENAME; ?></title>


</head>

<body class="light blue smaller freestyle01">
<div id="layout">
 
	<div class="row smaller">
		<div class="col c5 smaller">
		<h1><a href="<?php  echo SITEURL;?>"><?php echo SITENAME; ?></a></h1>
		</div>
		
		<div class="col c7 aligncenter">
			<p class="slogan"><?php echo SITEDESC;?></p>
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
  <?php global $showpages;
  foreach($showpages as $page){ ?>		
			<li><a class="navitab" href="<?php echo URL;?>pages/<?=$page->pageUrl;?>"><?=$page->pageName;?></a>
<?php } ?>
		</ul>
		
		<h3><a href="<?=URL;?>blog/search/?search=">Keresés</a></h3>
	
<form method="get" action="<?php echo URL;?>blog/search/">
<input type="text" name="search" size="15">
<input type="submit" value="Keresés">
</form>
<?php if(LOGGED_IN == 1){ ?>
<h3 align="right">Szia <i><?php echo USERNAME;?></i>!</h3>
<?php } ?> 

		
	<ul class="menu">
<?php if(RANK == 10){ ?><li><a href="<?php echo URL?>admin">Admin menü</a></li><?php } ?>
<?php if(LOGGED_IN != 1){ ?><li><a href="<?php echo URL?>login">Belépés</a></li><?php } ?>
<?php if(LOGGED_IN != 1){ ?><li><a href="<?php echo URL?>login/reg">Regisztráció</a></li><?php } ?>
<?php if(LOGGED_IN == 1){ ?> <li><a href="<?php echo URL?>login/profil">Profil</a></li> <?php } ?>
<?php if(LOGGED_IN == 1){ ?> 
				<ul class="subpages">
					<li><a href="<?php echo URL?>login/logout">Kilépés</a></li> 
				</ul>
<?php } ?>
				</ul>	
			<ul class="menu">
 <h3><a href="<?php echo URL;?>blog/category" >Kategóriák</a></h3> 

<ul class="sidelink">
<?php 
global $catAll; 
foreach($catAll as $cat){ ?>
	<li><a href="<?php echo URL; ?>blog/category/<?php echo $cat->categoryUrl;?>"><?php echo $cat->categoryName;?></a></li>
	
	
<?php } ?>
</ul>



			
			
			</ul>

		</div>
 
		<div class="col c8 mainContainer">

