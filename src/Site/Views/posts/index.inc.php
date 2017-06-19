<?php
if(!isset($title)){
    $title = 'Блог';
}
if(!isset($cover)){
    $cover = '/resources/images/home-bg.jpg';
}
include_once SITE_PATH . "/Views/inc/header.inc.php" ?>

<!-- Main Content -->
<div class="container">
    <div class="row">
        <?php if (isset($_SESSION[USER_SESSION])) {?>
            <div  class=" col-xs-12">
                <a href="/posts/new_" style="display:table; margin: 0 auto;" type="submit" class="btn btn-default">Новый пост</a>
            </div>
        <?php } ?>
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <?php if (isset($posts)) {
                foreach ($posts as $post) {
                    ?>
                    <div class="post-preview">
                        <a href="<?php echo '/posts/show/' . $post['id'] ?>">
                            <h2 class="post-title">
                                <?php echo $post['title'] ?>
                            </h2>
                        </a>
                        <p class="post-meta">Автор <a
                                    href="<?php echo '/user/show/' . $post['user_id'] ?>"><?php echo $post['username'] ?></a>.
                            Дата создания: <?php echo date('d.m.Y G:i', strtotime($post['created'])) ?></p>
                    </div>
                    <hr>
                <?php }
            } ?>
            <!-- Pager -->
            <ul class="pager">
                <?php
                if (isset($pager)) {
                    foreach ($pager as $page) {
                        echo $page;
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<?php include_once SITE_PATH . "/Views/inc/footer.inc.php" ?>
