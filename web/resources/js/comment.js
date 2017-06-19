$(document).ready(function () {
    $('#commentID').template('comment_template');
    let $commentBox = $('#comment_box');
    let $comment_id = $('article').data('comment');
    if (parseInt($comment_id) !== 0) {
        $('html, body').animate({
            scrollTop: $('#' + $comment_id).offset().top
        }, 800);
    }
    let $currentComment;
    $('.reply').on('click', function () {
        $commentBox.hide();
        $currentComment = $(this);
        $currentComment.hide();
        $('.replyForm').remove();
        let $id = $currentComment.data('id');
        let $user = $currentComment.data('user');
        $.tmpl('comment_template', {id: $id, user: $user}).insertAfter($currentComment);
    });
    $('.media').on('click', '.cancel-comment', function () {
        $commentBox.show();
        $currentComment.show();
        $('.replyForm').remove();
    })
});