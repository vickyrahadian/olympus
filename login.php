<?php
session_start();
require('fungsi.php');
konek_db();
?>

<html>
    <head>
        <style type="text/css">
            
            html { 
            background: url(asset/images/bg.jpg) no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
          }

            body {
                font: 13px/20px "Lucida Grande", Tahoma, Verdana, sans-serif;
                color: #404040; 
            }
            .container {
                margin: 150px auto;
                width: 640px;
            }

            .login {
                position: relative;
                margin: 0 auto;
                padding: 20px 20px 20px;
                width: 310px;
                background: white;
                border-radius: 3px;
                -webkit-box-shadow: 0 0 200px rgba(255, 255, 255, 0.5), 0 1px 2px rgba(0, 0, 0, 0.3);
                box-shadow: 0 0 200px rgba(255, 255, 255, 0.5), 0 1px 2px rgba(0, 0, 0, 0.3);
            }

            .login:before {
                content: '';
                position: absolute;
                top: -8px;
                right: -8px;
                bottom: -8px;
                left: -8px;
                z-index: -1;
                background: rgba(0, 0, 0, 0.08);
                border-radius: 4px;
            }

            .login h1 {
                margin: -20px -20px 21px;
                line-height: 40px;
                font-size: 15px;
                font-weight: bold;
                color: #555;
                text-align: center;
                text-shadow: 0 1px white;
                background: #f3f3f3;
                border-bottom: 1px solid #cfcfcf;
                border-radius: 3px 3px 0 0;
                background-image: -webkit-linear-gradient(top, whiteffd, #eef2f5);
                background-image: -moz-linear-gradient(top, whiteffd, #eef2f5);
                background-image: -o-linear-gradient(top, whiteffd, #eef2f5);
                background-image: linear-gradient(to bottom, whiteffd, #eef2f5);
                -webkit-box-shadow: 0 1px whitesmoke;
                box-shadow: 0 1px whitesmoke;
            }

            .login p {
                margin: 20px 0 0;
            }

            .login p:first-child {
                margin-top: 0;
            }

            .login input[type=text], .login input[type=password] {
                width: 278px;
            }          

            .login p.submit {
                text-align: right;
            }

            .login p.wrong{
                color:red;
            }

            :-moz-placeholder {
                color: #c9c9c9 !important;
                font-size: 13px;
            }

            ::-webkit-input-placeholder {
                color: #ccc;
                font-size: 13px;
            }

            input {
                font-family: 'Lucida Grande', Tahoma, Verdana, sans-serif;
                font-size: 14px;
            }

            input[type=text], input[type=password] {
                margin: 5px;
                padding: 0 10px;
                width: 200px;
                height: 34px;
                color: #404040;
                background: white;
                border: 1px solid;
                border-color: #c4c4c4 #d1d1d1 #d4d4d4;
                border-radius: 2px;
                outline: 5px solid #eff4f7;
                -moz-outline-radius: 3px;
                -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12);
                box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12);
            }

            input[type=text]:focus, input[type=password]:focus {
                border-color: #7dc9e2;
                outline-color: #dceefc;
                outline-offset: 0;
            }

            input[type=submit] {
                padding: 0 18px;
                height: 29px;
                font-size: 12px;
                font-weight: bold;
                color: #527881;
                text-shadow: 0 1px #e3f1f1;
                background: #cde5ef;
                border: 1px solid;
                border-color: #b4ccce #b3c0c8 #9eb9c2;
                border-radius: 16px;
                outline: 0;
                -webkit-box-sizing: content-box;
                -moz-box-sizing: content-box;
                box-sizing: content-box;
                background-image: -webkit-linear-gradient(top, #edf5f8, #cde5ef);
                background-image: -moz-linear-gradient(top, #edf5f8, #cde5ef);
                background-image: -o-linear-gradient(top, #edf5f8, #cde5ef);
                background-image: linear-gradient(to bottom, #edf5f8, #cde5ef);
                -webkit-box-shadow: inset 0 1px white, 0 1px 2px rgba(0, 0, 0, 0.15);
                box-shadow: inset 0 1px white, 0 1px 2px rgba(0, 0, 0, 0.15);
            }



        </style>
        <script type="text/javascript" src="asset/js/jquery.js"></script>
        <script type="text/javascript" src="asset/js/introtzikas.js"></script>
        <title>Palangjaya Login Panel</title>
    </head>

    <body>
        <?php
        @$proses = $_GET['proses'];
        if ($proses == '') {
            $proses = 'login';
        }

        if ($proses == 'logout') {
            session_destroy();
            ?>

            <script type="text/javascript">

                $(document).ready(function() {
                    $('body').css('background', '#FFFFFF');
                });

            </script>

            <?php
        }

        if (isset($_SESSION['un'])) {
            ?>

            <script type="text/javascript">

                window.location = "index.php";

            </script>

            <?php
        } else {
            if ($proses == 'login' || $proses == 'login_wrong') {

                if ($proses == 'login') {
                    ?>

                    <script type="text/javascript">

                        $(document).ready(function() {
                            $().introtzikas();
                        });

                    </script>
                    <?php
                }
                ?>

                <div class="container">
                    <div class="login">
                        <h1>Palangjaya Login Panel</h1>
                        <form method="post" action="?proses=login_proses">
                            <p><input type="text" name="username" value="" placeholder="Username" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,15}$"></p>
                            <p><input type="password" name="password" value="" placeholder="Password" required></p>

                            <p class="submit"><input type="submit" name="commit" value="Login"></p>
                        </form>
                        <?php
                        if ($proses == 'login_wrong') {
                            echo "<p class='wrong'>Username atau Password salah!</p>";
                        }
                        ?>
                    </div>
                </div>

                <?php
            } else if ($proses == 'login_proses') {
                $username = mysqli_real_escape_string($_POST['username']);
                $password = mysqli_real_escape_string($_POST['password']);
                $password = md5($password);

                $run = mysqli_query("SELECT * FROM pegawai WHERE username = '$username' AND password = '$password' AND status = 1 LIMIT 1");

                if (mysqli_num_rows($run) > 0) {
                    while ($row = mysql_fetch_array($run)) {
                        $_SESSION['un'] = $row['username'];
                        $_SESSION['id'] = $row['id_pegawai'];
                        $_SESSION['po'] = $row['id_posisi'];
                        ?>

                        <script type="text/javascript">

                            window.location = "index.php";

                        </script>

                        <?php
                    }
                } else {
                    ?>

                    <script type="text/javascript">

                        window.location = "login.php?proses=login_wrong";

                    </script>

                    <?php
                }
            }
        }
        ?>

    </body>
</html>
