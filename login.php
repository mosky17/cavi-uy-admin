<?php

/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

session_start();

require_once(dirname(__FILE__) . '/config.php');

?>

<script type="text/javascript">
    var GLOBAL_domain = "<?php echo $GLOBALS['domain']; ?>";
</script>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>CAVI System</title>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="scripts1.0/toolbox.js"></script>
    <script src="scripts1.0/login.js"></script>

    <link rel="stylesheet" type="text/css" href="http://assets.tumblr.com/fonts/arquitecta/stylesheet.css?v=3">
    <link rel="stylesheet" type="text/css" href="http://assets.tumblr.com/fonts/gibson/stylesheet.css?v=3">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link href="styles1.0/main.css" rel="stylesheet">

    <style type="text/css">

        body {
            background-color: #333366;
            padding-top: 40px;
            font-family:  'Gibson', sans-serif, georgia, serif;
            font-weight: normal;
        }

        .card-container.card {
            max-width: 350px;
            padding: 40px 40px;
        }

        .card {
            background-color: #F7F7F7;
            /* just in case there no content*/
            padding: 20px 25px 30px;
            margin: 0 auto 25px;
            margin-top: 50px;
            /* shadows and rounded borders */
            -moz-border-radius: 2px;
            -webkit-border-radius: 2px;
            border-radius: 2px;
            -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        }

        .profile-img-card {
            width: 100%;
            margin: 0 auto 25px;
        }

        .form-signin input[type=email],
        .form-signin input[type=password],
        .form-signin input[type=text],
        .form-signin button {
            width: 100%;
            display: block;
            margin-bottom: 10px;
            z-index: 1;
            position: relative;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        .btn.btn-signin {
            background-color: #333366;
            padding: 0px;
            font-size: 14px;
            height: 36px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            border: none;
            -o-transition: all 0.218s;
            -moz-transition: all 0.218s;
            -webkit-transition: all 0.218s;
            transition: all 0.218s;
            margin: 10px 0 0 0;
        }

        .btn.btn-signin:hover,
        .btn.btn-signin:active,
        .btn.btn-signin:focus {
            background-color: #ffcc00;
        }

        .forgot-password {
            color: #333366;
            font-size: 14px;
        }

        .forgot-password:hover,
        .forgot-password:active,
        .forgot-password:focus{
            color: #ffcc00;
        }

        .fa-exclamation-circle {
            float: left;
            margin-right: 10px;
            font-size: 22px;
        }

    </style>

</head>
<body>

<div class="container">
    <div class="card card-container">
        <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
        <img id="profile-img" class="profile-img-card" src="images/logo_cavi.png" />
        <div id="feedbackContainer"></div>
        <form id="loginForm" class="form-signin" action="<?php echo $GLOBALS['domain']; ?>" method="POST">
            <input type="text" id="loginEmail" class="form-control" placeholder="Username" name="username" required autofocus>
            <input type="password" id="loginPassword" class="form-control" name="password" placeholder="Password" required>
            <div id="remember" class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me" name="remember"> Remember me
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" id="loginBtnIngresar" onClick="Login.Login();">Sign in</button>
        </form><!-- /form -->
        <a href="#" class="forgot-password">
            Forgot the password?
        </a>
    </div><!-- /card-container -->
</div><!-- /container -->

</body>
</html>
