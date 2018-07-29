<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
          integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>/views/assets/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>/views/assets/css/effects.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>/views/assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>/views/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>/views/assets/css/responsive.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.7/bootstrap-notify.min.js"></script>
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


</head>
<body>
<div class="loginBackground">
    <div>
        <br/>
        <?php echo $this->notification ?>
    </div>
    <div class="login-page wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
        <div class="form">

            <form class="register-form" method="post" action="?controller=login&action=register" onsubmit="">
                <a href="<?php echo PROJECT_DIR ?>?controller=pages&action=home"></a>
                <hr>

                <input type="email" id="username" name="email" autocomplete="email" placeholder="* Email address"
                       required/>
                <p id="result"></p>
                <input type="password" placeholder="* Password" name="pass" autocomplete="pass" required/>
                <input type="password" placeholder="* Re-enter Password" autocomplete="pass" name="re_pass" required/>
                <hr>
                <input type="submit" class="button" id="register_form" name="register_form" value="Register"/>
                <p class="message">Already registered? <a href="#">Sign In <strong>here</strong></a></p>
            </form>
            <form class="login-form" method="post" action="?controller=login&action=login">
                <p> Welcome to
                    <a href="<?php echo PROJECT_DIR ?>?controller=user&action=showHomePage"> iEat!</a></p>
                <hr>
                <input type="email" placeholder="Username" id="email" name="email" autocomplete="email" required/>
                <input type="password" placeholder="Password" id="pass" name="pass" autocomplete="pass" required/>
                <input type="submit" class="button" id="login_form" name="login_form" value="Sign In"/>
                <p class="message">Not registered? <a href="#">Sign up <strong>now</strong></a></p>
            </form>
        </div>
    </div>
</div>
</body>
<script src="<?php echo PROJECT_DIR ?>/views/assets/js/custom.js"></script>
</body>
</html>