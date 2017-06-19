<script type="text/x-jquery-tmpl" id="commentID">
<form  method="post" action="/comment/create" class="replyForm">

            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Комментарий</label>
                    <textarea rows="5" minlength="15" class="form-control" placeholder="Комментарий" id="message"
                              required="required" name="text"
                              aria-invalid="false">{%= user%}, </textarea>
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <input type="hidden" name="post_id" value="<?php echo $post['id'] ?>">
            <input type="hidden" name="parent_id" value="{%= id%}">
             <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
            <br>
            <div class="row">
                <div class="form-group col-xs-12">
                    <button type="submit" class="btn btn-default">Оставить комментарий</button>
                    <button class="btn btn-default cancel-comment">Отменить</button>
                </div>
            </div>
        </form>
</script>