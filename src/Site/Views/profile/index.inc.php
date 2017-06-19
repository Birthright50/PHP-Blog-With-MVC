<?php
$title = $_SESSION[USER_SESSION]->getUsername();
$cover = $_SESSION[USER_SESSION]->getCover();
include_once SITE_PATH . "/Views/inc/header.inc.php" ?>
<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class=" col-xs-12">
            <a href="/posts/new_" style="display:table; margin: 0 auto;" type="submit" class="btn btn-default">Новый
                пост</a>
        </div>
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
                        <p class="post-meta"><a style="color:red; cursor: pointer" data-id="<?php echo $post['id'] ?>"
                                    >Удалить?</a>.
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
<script type="application/javascript">
    $(document).ready(function () {
        $('.post-meta').find('a').on('click', function () {
            let id = $(this).data('id');
            if (confirm('Вы уверены, что хотите удалить данную запись?')) {
                $.ajax({
                    url: '/posts/delete/' + id,
                    type: "POST",
                    success: function (result) {
                        if (result === 'OK') {
                            window.location.href = "/profile";
                        }
                    }
                });
            }
        });
    })
</script>
<?php include_once SITE_PATH . "/Views/inc/footer.inc.php" ?>
