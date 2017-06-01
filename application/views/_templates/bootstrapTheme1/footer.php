<!---<nav>
    <ul class="pager">
        <li><a href="#">Previous</a></li>
        <li><a href="#">Next</a></li>
    </ul>
</nav>
---->
</div><!-- /.blog-main -->

<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
    <div class="sidebar-module sidebar-module-inset">
        <h4>Recycle</h4>
        <p><?php echo SITEDESC2; ?></p>
    </div>
    <div class="sidebar-module">
        <h4>Menü</h4>
        <ol class="list-unstyled">
            <?php if (RANK == 10) { ?><li><a href="<?php echo URL ?>admin">Admin menü</a></li><?php } ?>
            <?php if (LOGGED_IN != 1) { ?><li><a href="<?php echo URL ?>login">Belépés</a></li><?php } ?>
            <?php if (LOGGED_IN != 1) { ?><li><a href="<?php echo URL ?>login/loginXML">Belépés XML</a></li><?php } ?>
            <?php if (LOGGED_IN != 1) { ?><li><a href="<?php echo URL ?>login/reg">Regisztráció</a></li><?php } ?>
            <?php if (LOGGED_IN != 1) { ?><li><a href="<?php echo URL ?>login/regXML">Regisztráció XML</a></li><?php } ?>
            <?php if (LOGGED_IN == 1) { ?> <li><a href="<?php echo URL ?>login/profil">Profil</a></li> <?php } ?>
            <?php if (LOGGED_IN == 1) { ?> <li><a href="<?php echo URL ?>login/profilXML">Profil  XML</a></li> <?php } ?>
            <?php if (LOGGED_IN == 1) { ?> <li><a href="<?php echo URL ?>login/logout">Kilépés</a></li> <?php } ?>
        </ol>   </div>  

    <div class="sidebar-module">
        <h4>Archívum</h4>
        <ol class="list-unstyled">

            <?php
            global $getarchives;
            foreach ($getarchives as $archive) {
                ?>
                <li><a href="/blog/archives/<?= $archive->year ?>/<?= $archive->month; ?>"><?php echo $archive->year . " - " . $archive->month; ?></li>

            <?php } ?>

        </ol>
    </div>
    <div class="sidebar-module">

        <h4 class="categories"> 
            <a  href="<?php echo URL; ?>blog/category" id="urlLinks" class="linkToContainer">Kategóriák</a></h4>
        <ol class="list-unstyled">
            <?php
            global $catAll;
            foreach ($catAll as $cat) {
                ?>
                <li><a class=""  href="<?php echo URL; ?>blog/category/<?php echo $cat->categoryUrl; ?>"><?php echo $cat->categoryName; ?></a></li>


            <?php } ?>

        </ol>
    </div>
    <?php if (LINKHEADER1 != null and LINKHEADER2 != null and LINKHEADER3 != null) { ?>
        <div class="sidebar-module">

            <h4>Linkek</h4>	
            <ol class="list-unstyled">
                <?php if (LINKHEADER1 != null AND LINKHEADERURL1 != null) { ?>
                    <li>         
                        <a href="<?php echo LINKHEADERURL1; ?>"><?php echo LINKHEADER1; ?></a><span class="hide"> | </span>
                    <?php } ?>
                        <?php if (LINKHEADER2 != null AND LINKHEADERURL2 != null) { ?><li>
                        <a class="toptab" href="<?php echo LINKHEADERURL2; ?>"><?php echo LINKHEADER2; ?></a><span class="hide"> | </span>
                <?php } ?><li>
                    <?php if (LINKHEADER3 != null AND LINKHEADERURL3 != null) { ?>
                        <a class="toptab" href="<?php echo LINKHEADERURL3; ?>"><?php echo LINKHEADER3; ?></a><span class="hide"> | </span>
                    <?php } ?>  


            </ol>
        </div>
    <?php } ?>

    <?php if (COMMENTNUMSIDEBAR != 0) { ?>
        <div class="sidebar-module">

            <h4>Hozzászólások</h4>

            <?php
            global $showcomments;
            foreach ($showcomments as $comments) {
                ?>
                <b> <?= $comments->username; ?></b><br> írta:
                <font style="color:#FFF;"  size="1">
                <span	class="onmouse"><?= $comments->commentdate; ?><br><a href="<?= URL; ?>blog/<?= $comments->postUrl; ?>#<?= $comments->commentid; ?>"><?= $comments->comment; ?></a></span>
                <br><br>
                </font>

            <?php } ?> </div>
    <?php } ?>           <div class="sidebar-module">

        Bejegyzések: 
        <b><?php
            global $amount_of_posts;
            echo $amount_of_posts;
            ?></b>
        <br>
        Hozzászólások: <b><?php
            global $amount_of_comments;
            echo $amount_of_comments;
            ?></b>
    </div>
</div><!-- /.blog-sidebar -->

</div><!-- /.row -->

</div><!-- /.container -->


<?php include_once("./application/views/_templates/global_footer.php"); ?>	



</body>
</html>

