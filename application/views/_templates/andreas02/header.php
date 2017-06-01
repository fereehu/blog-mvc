<!DOCTYPE html>
<head>

    <meta http-equiv="content-type">
    <meta charset="utf-8">

    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/andreas02/andreas02.css" media="">
    <link href="<?php echo URL; ?>public/css/andreas02/style.css" rel="stylesheet">
    <link href="<?php echo URL; ?>public/css/globalstyle.css" rel="stylesheet">
    <meta name="description" content="<?php echo SITEDESC; ?>">
    <?php include_once("./application/views/_templates/global.php"); ?>	


    <title><?php echo SITENAME; ?></title>




</head>
<body>




    <?php if (LINKHEADER1 != null and LINKHEADER2 != null and LINKHEADER3 != null) { ?>
        <div id="toptabs">
            <p>Linkek:	
                <?php if (LINKHEADER1 != null AND LINKHEADERURL1 != null) { ?>
                    <a class="toptab" href="<?php echo LINKHEADERURL1; ?>"><?php echo LINKHEADER1; ?></a><span class="hide"> | </span>
                    <?php } ?>
                    <?php if (LINKHEADER2 != null AND LINKHEADERURL2 != null) { ?>
                        <a class="toptab" href="<?php echo LINKHEADERURL2; ?>"><?php echo LINKHEADER2; ?></a><span class="hide"> | </span>
                    <?php } ?>
                    <?php if (LINKHEADER3 != null AND LINKHEADERURL3 != null) { ?>
                        <a class="toptab" href="<?php echo LINKHEADERURL3; ?>"><?php echo LINKHEADER3; ?></a><span class="hide"> | </span>
                        <?php } ?>
                </div>
            <?php } ?>
            <div id="container">
                <div id="logo">
                    <h1><a href="<?php echo SITEURL; ?>"><?php echo SITENAME; ?></a></h1>


                    <p><?php echo SITEDESC; ?></p>


                </div>

                <div id="navitabs"> 
                    <?php global $showpages;
                    foreach ($showpages as $page) {
                        ?>
                        <a class="navitab" href="<?php echo URL; ?>pages/<?= $page->pageUrl; ?>"><?= $page->pageName; ?></a><span class="hide"> | </span>
        <?php } ?>




                    <div id=desc>
                        <h2>Recycle</h2>
                        <p><?php echo SITEDESC2; ?></p>
                        <p class=right>

                    </div>


                </div>



                <div id="main">
                    <div class="container mainContainer">


<?php
    // <div class="navigation">
        // <ul>
            // <li><a href="">home</a></li>

        // </ul>
    // </div>

