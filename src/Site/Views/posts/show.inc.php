<?php
$title = $post['title'];
$cover = $post['cover'];
$isPost = true;
$meta = '<span class="meta">Автор <a href="/user/show/' . $post['user_id'] . '">' . $post['username'] . '</a>. Дата создания: ' . date('d.m.Y G:i', strtotime($post['created'])) . '</span>';
include_once SITE_PATH . "/Views/inc/header.inc.php" ?>
<article data-comment="<?php echo $comment_id ?>" data-id="<?php echo $post['id'] ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <?php echo $post['text'] ?>
            </div>

        </div>
        <hr>
        <?php echo 'Количество комментариев: ' . $counts ?>
        <hr>
        <?php if (isset($_SESSION[USER_SESSION])) { ?>
            <ul class="pager">
                <li class="next">
                    <a href="#comment_box">Комментировать</a>
                </li>
            </ul>
        <?php }
        printComments($comments); ?>
        <br>
        <?php if (isset($_SESSION[USER_SESSION])) { ?>
            <form method="post" action="/comment/create" id="comment_box">
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Комментарий</label>
                        <textarea rows="5" minlength="10" class="form-control" placeholder="Комментарий" id="message"
                                  required="" data-validation-required-message="Введите комментарий" name="text"
                                  aria-invalid="false"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"/>
                <input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
                <br>
                <div class="row">
                    <div class="form-group col-xs-12">
                        <button type="submit" class="btn btn-default">Оставить комментарий</button>
                    </div>
                </div>
            </form>
        <?php } ?>
    </div>
</article>
<hr>
<?php
if (isset($_SESSION[USER_SESSION])) {
    include_once SITE_PATH . "/Views/templates/comment.inc.php";
    echo '<script src="/resources/js/comment.js" type="application/javascript"></script>';
}
function printComments($comments)
{
    foreach ($comments as $comment) { ?>
        <div id="<?php echo $comment['id'] ?>" class="media">
            <a class="pull-left">
                <img class="media-object" width="64px" height="64px" src="<?php echo $comment['avatar'] ?>"
                     alt="Аватар">
            </a>
            <div class="media-body" style="font-size: 16px">
                <h4 class="media-heading"><a
                            href="/user/show/<?php echo $comment['user_id'] ?>"><?php echo $comment['username'] ?></a>
                    <small><?php echo date('d.m.Y G:i', strtotime($comment['created'])) ?></small>
                </h4>
                <?php echo $comment['text'];
                if (isset($_SESSION[USER_SESSION])) { ?>
                    <br><br><a class="reply" data-user="<?php echo $comment['username'] ?>"
                               data-id="<?php echo $comment['id'] ?>"
                               style="color:steelblue; cursor: pointer">Ответить</a>
                <?php } ?>
                <hr>
                <?php if (!empty($comment['childs'])) {
                    printComments($comment['childs']);
                } ?>
            </div>
        </div>
    <?php }
}

include_once SITE_PATH . "/Views/inc/footer.inc.php" ?>

