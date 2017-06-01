<div class="blog-post">

    <h2 class="blog-post-title">Archívum</h2>
    <?php if (sizeof($posts) > 0) { ?>



        <ol>
            <?php foreach ($posts as $post) { ?>

                <p class="timestamp blog-post-meta"><?php echo $post->postDate; ?>  | 
                    <b>

                        <a href="<?php echo URL; ?>blog/<?php echo $post->postUrl; ?>">
                            <?php echo $post->postName; ?>
                        </a> 
                        | 
                        <a href="<?= URL; ?>blog/<?= $post->postUrl; ?>#comment"> 
                            <?= $blog_model->getCommentNumByPostId($post->postid); ?> hozzászólás
                        </a>

                    </b>
                    <br><font size="1"><em><?php echo $post->categoryName; ?></em></font></p>
                <?php echo $blog_model->galleryBBcode($post->postContent); ?>

            <?php } ?>
        </ol>
    <?php } else { ?>
        <ol class="list-unstyled">

            <?php
            global $getarchives;
            foreach ($getarchives as $archive) {
                ?>
                <li><a href="/blog/archives/<?= $archive->year ?>/<?= $archive->month; ?>"><?php echo $archive->year . " - " . $archive->month; ?></a>

                <?php } ?>

        </ol>

    <?php } ?>
</div>