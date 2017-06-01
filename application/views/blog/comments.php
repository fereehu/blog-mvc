    <h2 id="comment">Hozzászólások</h2>
    <?php foreach($getComments as $comment){ ?>
    <p></p>
    <font id="<?= $comment->id; ?>" size="3"><b>
        <?php if($comment->userurl){ ?>
        <a href="<?= $comment->userurl; ?>">
            <?= $comment->username; ?>
        </a>
            <?php }else echo $comment->username;?>

    </b></font> 
    <font size="1"><a href="#<?= $comment->id; ?>"><?= $comment->commentdate; ?></a></font>

    <p class='block'> <?php echo nl2br($comment->comment);?></p>

    <?php } ?>