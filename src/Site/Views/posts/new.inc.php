<?php
$title = 'Новый пост';

if (!isset($cover)) {
    $cover = '/resources/images/home-bg.jpg';
}
include_once SITE_PATH . "/Views/inc/header.inc.php" ?>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <p style="color: red">
                <?php if (isset($notices)) {
                    foreach ($notices as $notice) echo $notice . '<br>';
                } ?>
            </p>
            <form name="sentMessage" method="post" enctype="multipart/form-data" action="/posts/create">
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Заголовок</label>
                        <input <?php if (isset($postDto)) {
                            echo 'value="' . $postDto->getTitle() . '"';
                        } ?>
                                type="text" class="form-control" minlength="5"
                                placeholder="Заголовок" id="name" required="required" name="title"
                                aria-invalid="false">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                ​

                <textarea name="text" required="required" minlength="20" id="editor" rows="10" cols="20">
                    <?php if (isset($postDto)) {
                        echo $postDto->getText();
                    } ?></textarea><br><br>
                ​
                <div class="inputBtnSection">
                    <input id="uploadFile2" class="disableInputField" placeholder="Выберите обложку"
                           disabled="disabled"/>
                    <label class="fileUpload">
                        <input required="required" id="uploadBtn2" name="cover" type="file" class="upload"/>
                        <span class="uploadBtn">Выберите файл ..</span>
                    </label>
                </div>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"/>
                <br><br>
                <div class="row">
                    <div class="form-group col-xs-12">
                        <button name="submit" type="submit" class="btn btn-default">Создать</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    tinymce.init({selector: '#editor', directionality: 'ru'});
    document.getElementById("uploadBtn2").onchange = function () {
        document.getElementById("uploadFile2").value = this.value;
    };
</script>
<style rel="stylesheet">
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
    }

    .inputBtnSection {
        display: inline-block;
        vertical-align: top;
        font-size: 0;
        font-family: Lora, 'Times New Roman', serif;
    }

    .disableInputField {
        display: inline-block;
        vertical-align: top;
        height: 27px;
        margin: 0;
        font-size: 14px;
        padding: 0 3px;
    }

    .fileUpload {
        position: relative;
        overflow: hidden;
        border: solid 1px gray;
        display: inline-block;
        vertical-align: top;
    }

    .uploadBtn {
        display: inline-block;
        vertical-align: top;
        background: rgba(0, 0, 0, 0.5);
        font-size: 14px;
        padding: 0 10px;
        height: 25px;
        line-height: 22px;
        color: #fff;
    }

    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }
</style>
<?php include_once SITE_PATH . "/Views/inc/footer.inc.php" ?>
