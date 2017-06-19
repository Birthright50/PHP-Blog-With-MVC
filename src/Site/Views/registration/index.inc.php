<?php
$title = 'Регистрация';
$cover = '/resources/images/home-bg.jpg';
include_once SITE_PATH . "/Views/inc/header.inc.php" ?>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <p style="color: red">
                <?php if(isset($notices)){
                    foreach ($notices as $notice) echo $notice.'<br>';
                }?>
            </p>
            <form name="sentMessage" method="post" action="/registration" enctype="multipart/form-data"
                  id="contactForm">
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Никнейм</label>
                        <input value="<?php if (isset($userDto)) echo $userDto->getUsername() ?>"

                               type="text" class="form-control" pattern="^[a-zA-Zа-яА-Я0-9_-]{3,15}$"
                               placeholder="Никнейм" id="name" required="required" name="reg[username]"
                               title="От трех до 15 символов"
                               data-validation-required-message="Введите никнейм" aria-invalid="false">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>

                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Email</label>
                        <input value="<?php if (isset($userDto)) echo $userDto->getEmail() ?>"
                               type="email" class="form-control" placeholder="Email"
                               id="email" required="required" name="reg[email]"
                               data-validation-required-message="Введите email" aria-invalid="false">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Пароль</label>
                        <input type="password" class="form-control" placeholder="Пароль"
                               pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                               id="email" required="required" name="reg[password]"
                               title="мин. 8 символов, 1 спец символ, 1 цифра, 1 большая буква"
                               data-validation-required-message="Введите пароль" aria-invalid="false">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Подтверждение пароля</label>
                        <input type="password" class="form-control" placeholder="Подтверждение пароля"
                               pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                               id="email" required="required" name="reg[matchingPassword]"
                               data-validation-required-message="Подтвердите пароль" aria-invalid="false">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <br>
                <div class="inputBtnSection">
                    <input id="uploadFile1" class="disableInputField" placeholder="Выберите аватар" disabled="disabled"/>
                    <label class="fileUpload">
                        <input required="required" id="uploadBtn1" name="avatar" type="file" class="upload"/>
                        <span class="uploadBtn">Выберите файл ..</span>
                    </label>
                </div>
                <div class="inputBtnSection">
                    <input id="uploadFile2" class="disableInputField" placeholder="Выберите обложку" disabled="disabled"/>
                    <label class="fileUpload">
                        <input required="required" id="uploadBtn2" name="cover" type="file" class="upload"/>
                        <span class="uploadBtn">Выберите файл ..</span>
                    </label>
                </div>
                <br>
                <br>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
                <div class="g-recaptcha" data-sitekey="6LfRSyIUAAAAAHZyC_5pyjkyUMDxyWTRw32s8nlk"></div>
                <br><br>
                <div class="success"></div>
                <div class="row">
                    <div class="form-group col-xs-12">
                        <button type="submit" class="btn btn-default">Зарегистрироваться</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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
<script type="application/javascript">
    for(let i = 1; i<=2; i++){
        document.getElementById("uploadBtn"+i).onchange = function () {
            document.getElementById("uploadFile"+i).value = this.value;
        };
    }

</script>
<?php include_once SITE_PATH . "/Views/inc/footer.inc.php" ?>
