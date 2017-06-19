<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="application/javascript" src="/resources/vendor/jquery/jquery-3.1.1.min.js"></script>
    <script type="application/javascript" src="/resources/vendor/bootstrap/js/bootstrap.min.js"></script>

    <link href="/resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    <link href="/resources/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet'
          type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
          rel='stylesheet' type='text/css'>

    <link href="/resources/css/clean-blog.css" rel="stylesheet">
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=axbeqd1g2oe5p8hs13anu4l965cze0y0982rqjbwx7tpwsfx"></script>

<title><?php
    if(isset($title)){
        echo $title;
    } ?></title>
    <link href='//fonts.googleapis.com/css?family=Viga' rel='stylesheet' type='text/css'/>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script type="application/javascript">
        window.csrf = { csrf_token: '<?php echo $_SESSION['csrf_token']; ?>' };
        $.ajaxSetup({
            data: window.csrf
        });
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);
        function hideURLbar() {
            window.scrollTo(0, 1);
        } </script>
    <script type="application/javascript" src="/resources/js/ru.js"></script>
    <script type="application/javascript" src="/resources/js/jquery.tmpl.js"></script>


</head>
<body>
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                Меню <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="/">Главная</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="/">Домашняя страница</a>
                </li>
                <?php if (!isset($_SESSION[USER_SESSION])) { ?>
                    <li>
                        <a href="/registration">Регистрация</a>
                    </li>
                    <li>
                        <a href="/login">Логин</a>
                    </li>
                <?php } else {
                    ?>
                    <li>
                        <a href="/profile">Профиль</a>
                    </li>
                    <li>
                        <form method="post" action="/logout/process">
                            <input type="submit" value="Выйти">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
                        </form>
                        <!--                        <a href="/logout/process">Выход</a>-->
                    </li>
                <?php } ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<header class="intro-header" style="background-image: url(<?php echo $cover ?>)">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="<?php
                if(isset($isPost)){
                    echo 'post-heading';
                }else{
                    echo 'site-heading';
                }
                ?>">
                    <h1><?php echo $title ?></h1>
                    <hr class="small">
                    <span class="subheading"><?php
                        if (isset($count)) {
                             echo "Количество записей: ".$count;
                        }elseif (isset($meta)) {
                            echo $meta;
                        }  ?>


                    </span>
                </div>
            </div>
        </div>
    </div>
</header>