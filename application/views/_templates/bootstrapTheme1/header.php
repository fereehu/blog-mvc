<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">
        <?php include_once("./application/views/_templates/global.php"); ?>

        <script src="<?php echo URL; ?>public/js/bootstrap.min.js"></script>

        <title><?php echo SITENAME; ?></title>

        <link href="<?= URL; ?>public/css/bootstrapTheme1/bootstrap.min.css" rel="stylesheet">

        <link href="<?= URL; ?>public/css/bootstrapTheme1/blog.css" rel="stylesheet">

    </head>

    <body>




        <div class="blog-masthead">
            <div class="container">
                <nav class="blog-nav">
                    <?php
                    global $showpages;
                    foreach ($showpages as $page) {
                        ?>
                        <a class="blog-nav-item <?php
                           if (POSTURL == $page->pageUrl) {
                               echo "active";
                           }
                           ?> " href="<?php echo URL; ?>pages/<?= $page->pageUrl; ?>"><?= $page->pageName; ?></a>
<?php } ?>
                </nav>
            </div>
        </div>

        <div class="container">

            <div class="blog-header">
                <h1 class="blog-title"><a href="<?php echo SITEURL; ?>"><? echo SITENAME; ?></a></h1>
                <p class="lead blog-description"><?php echo SITEDESC; ?></p>
            </div>

            <div class="row">

                <div class="col-sm-8 blog-main mainContainer">

