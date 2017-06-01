
</div>

</div>

<div id="sidebar">
    <h3><a href="<?= URL; ?>blog/search/?search=">Keresés</a></h3>

    <form method="get" action="<?php echo URL; ?>blog/search/">
        <input type="text" name="search" size="15">
        <input type="submit" value="Keresés">
    </form>
    <?php if(LOGGED_IN == 1){ ?>
    <h3 align="right">Szia <i><?php echo USERNAME;?></i>!</h3>
    <?php } ?> 
    <ul class="sidelink">
        <?php if(RANK == 10){ ?><li><a href="<?php echo URL?>admin">Admin menü</a></li><?php } ?>
        <?php if(LOGGED_IN != 1){ ?><li><a href="<?php echo URL?>login">Belépés</a></li><?php } ?>
        <?php if(LOGGED_IN != 1){ ?><li><a href="<?php echo URL?>login/loginXML">Belépés XML</a></li><?php } ?>
        <?php if(LOGGED_IN != 1){ ?><li><a href="<?php echo URL?>login/reg">Regisztráció</a></li><?php } ?>
        <?php if(LOGGED_IN != 1){ ?><li><a href="<?php echo URL?>login/regXML">Regisztráció XML</a></li><?php } ?>
        <?php if(LOGGED_IN == 1){ ?> <li><a href="<?php echo URL?>login/profil">Profil</a></li> <?php } ?>
        <?php if(LOGGED_IN == 1){ ?> <li><a href="<?php echo URL?>login/profilXML">Profil  XML</a></li> <?php } ?>
        <?php if(LOGGED_IN == 1){ ?> <li><a href="<?php echo URL?>login/logout">Kilépés</a></li> <?php } ?>
    </ul>

    <h3 class="categories"> 
        <a  href="<?php echo URL; ?>blog/category" id="urlLinks" class="linkToContainer">Kategóriák</a></h3> 

    <ul class="sidelink">
        <?php
        global $catAll;
        foreach ($catAll as $cat) {
            ?>
            <li><a href="<?php echo URL; ?>blog/category/<?php echo $cat->categoryUrl; ?>"><?php echo $cat->categoryName;?></a></li>


            <?php } ?>

        </ul>

        <?php if (COMMENTNUMSIDEBAR != 0) { ?>
            <h3>Hozzászólások</h3>

            <?php
            global $showcomments;
            foreach ($showcomments as $comments) {
                ?>
                <b> <?= $comments->username; ?></b><br> írta:
                <font style="color:#FFF;"  size="1">
                <span	class="onmouse"><?= $comments->commentdate; ?><br><a href="<?= URL; ?>blog/<?= $comments->postUrl; ?>#<?= $comments->commentid; ?>"><?= $comments->comment; ?></a></span>
                <br><br>
                </font>

            <?php
            }
        }
        ?>

        <img class="photo" src="<?php echo URL;?>public/img/vote.png" height="100" alt="" width="130" >
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

    <div id="footer">

       <?php include_once("./application/views/_templates/global_footer.php"); ?>	
    </div>



    </div>
    


</body>
</html>