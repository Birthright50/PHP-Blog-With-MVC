<?php
$title = 'Логин';
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
            <form name="sentMessage" method="post" action="/login/process/"
                  id="contactForm">
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Никнейм или Email</label>
                        <input

                               type="text" class="form-control"
                               placeholder="Никнейм или Email" id="name" required="required" name="name"
                               data-validation-required-message="Введите никнейм или Email" aria-invalid="false">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>

                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label>Пароль</label>
                        <input type="password" class="form-control" placeholder="Пароль"
                               pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                               id="email" required="required" name="password"
                               title="мин. 8 символов, 1 спец символ, 1 цифра, 1 большая буква"
                               data-validation-required-message="Введите пароль" aria-invalid="false">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="checkbox">
                    <label><input name="remember-me" type="checkbox">Запомнить меня</label>
                </div>
                <br><br>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
                <div class="row">
                    <div class="form-group col-xs-12">
                        <button name="submit" type="submit" class="btn btn-default">Войти</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once SITE_PATH . "/Views/inc/footer.inc.php" ?>
