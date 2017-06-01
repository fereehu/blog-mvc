<!DOCTYPE html>

<head>

    <meta http-equiv="content-type">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/variant-rounded/variant-rounded.css" media="">
    <link href="<?php echo URL; ?>public/css/variant-rounded/style.css" rel="stylesheet">
    <link href="<?php echo URL; ?>public/css/globalstyle.css" rel="stylesheet">
    <meta name="description" content="<?php echo SITEDESC; ?>">
    <?php include_once("./application/views/_templates/global.php"); ?>	





    <title><?php echo SITENAME; ?></title>


</head>




<body>
    <div id="wrap">

        <div id="header">
            <h1><a href="<?= URL; ?>"><?php echo SITENAME; ?></a></h1>
            <p id="slogan"><?php echo SITEDESC; ?></p>
        </div>

        <div id="sidebar">
            <div id="sitemenu">
                <h4><?= SITEDESC2; ?></h4>
                <ul class="menu">
                    <?php global $showpages;
                    foreach ($showpages as $page) {
                        ?>		
                        <li><a class="navitab" href="<?php echo URL; ?>pages/<?= $page->pageUrl; ?>"><?= $page->pageName; ?></a>
<?php } ?>
                </ul>

                <h3><a href="<?= URL; ?>blog/search/?search=">Keresés</a></h3>

                <form method="get" action="<?php echo URL; ?>blog/search/">
                    <input type="text" name="search" size="15">
                    <input type="submit" value="Keresés">
                </form>
                <?php if (LOGGED_IN == 1) { ?>
                    <h3 align="right">Szia <i><?php echo USERNAME; ?></i>!</h3>
<?php } ?> 


                <ul>
                    <?php if (RANK == 10) { ?><li><a href="<?php echo URL ?>admin">Admin menü</a></li><?php } ?>
                    <?php if (LOGGED_IN != 1) { ?><li><a href="<?php echo URL ?>login">Belépés</a></li><?php } ?>
                    <?php if (LOGGED_IN != 1) { ?><li><a href="<?php echo URL ?>login/reg">Regisztráció</a></li><?php } ?>
                    <?php if (LOGGED_IN == 1) { ?> <li><a href="<?php echo URL ?>login/profil">Profil</a></li> <?php } ?>
<?php if (LOGGED_IN == 1) { ?> 

                        <li><a href="<?php echo URL ?>login/logout">Kilépés</a></li> 

<?php } ?>
                </ul>	
                <ul class="menu">
                    <h3><a href="<?php echo URL; ?>blog/category"   id="urlLinks" class="linkToContainer">Kategóriák</a></h3> 


                    <?php
                    global $catAll;
                    foreach ($catAll as $cat) {
                        ?>
                        <li><a href="<?php echo URL; ?>blog/category/<?php echo $cat->categoryUrl; ?>"><?php echo $cat->categoryName; ?></a></li>


<?php } ?>



                    <img class="photo" src="<?php echo URL; ?>public/img/vote.png" height="100" alt="" width="130" >


                    Bejegyzések száma: 
                    <b><?php
                        global $amount_of_posts;
                        echo $amount_of_posts;
                        ?></b>	

                    Hozzászólások: <b><?
                        global $amount_of_comments;
                        echo $amount_of_comments;
                        ?></b>	
            </div>
            <ul class="menu">


                <ul class="sidelink">
<?php if (LINKHEADER1 != null and LINKHEADER2 != null and LINKHEADER3 != null) { ?>
                        <div id="toptabs">
                            <h3>Linkek</h3> 
                            <?if(LINKHEADER1 != null AND LINKHEADERURL1 != null){ ?>
                            <li><a class="toptab" href="<?php echo LINKHEADERURL1; ?>"><?php echo LINKHEADER1; ?></a><span class="hide"> | </span>
                                <?}?>
                                <?if(LINKHEADER2 != null AND LINKHEADERURL2 != null){ ?>
                            <li><a class="toptab" href="<?php echo LINKHEADERURL2; ?>"><?php echo LINKHEADER2; ?></a><span class="hide"> | </span>
                                <?}?>
                                <?if(LINKHEADER3 != null AND LINKHEADERURL3 != null){ ?>
                            <li><a class="toptab" href="<?php echo LINKHEADERURL3; ?>"><?php echo LINKHEADER3; ?></a><span class="hide"> | </span>
                                <?}?>
                        </div>
<?php } ?>
                </ul>


                <?php if (COMMENTNUMSIDEBAR != 0) { ?>
                    <h3>Hozzászólások</h3>

    <?php global $showcomments;
    foreach ($showcomments as $comments) {
        ?>
                        <b> <?= $comments->username; ?></b><br> írta:
                        <font style="color:#f5f5f5;"  size="1">
                        <span	class="onmouse"><?= $comments->commentdate; ?><br><a href="<?= URL; ?>blog/<?= $comments->postUrl; ?>#<?= $comments->commentid; ?>"><?= $comments->comment; ?></a></span>
                        <br><br>
                        </font>

    <?php }
}
?>




            </ul>


        </div>
        <div id="content mainContainer">

