<html>
<head>
    <meta name="google-signin-client_id" content="960318417031-3rai1932j0342j4sbf5trrbd6vv6kgf5.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
<?php
session_start();
if(!empty($_SESSION["userId"])) {
    require_once 'dashboard.php';
} else {
    require_once 'login.php';
}
?>
<title>User Login</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div>
        <form action="login.php" method="post" id="frmLogin" onSubmit="return validate();">
            <div class="demo-table">

                <div class="form-head">Login</div>
                <?php 
                if(isset($_SESSION["errorMessage"])) {
                ?>
                <div class="error-message"><?php  echo $_SESSION["errorMessage"]; ?></div>
                <?php 
                unset($_SESSION["errorMessage"]);
                } 
                ?>
                <div class="field-column">
                    <div>
                        <label for="username">Username</label><span id="user_info" class="error-info"></span>
                    </div>
                    <div>
                        <input name="user_name" id="user_name" type="text"
                            class="demo-input-box">
                    </div>
                </div>
                <div class="field-column">
                    <div>
                        <label for="password">Password</label><span id="password_info" class="error-info"></span>
                    </div>
                    <div>
                        <input name="password" id="password" type="password"
                            class="demo-input-box">
                    </div>
                </div>
                <div class=field-column>
                    <div>
                        <input type="submit" name="login" value="Login"
                        class="btnLogin"></span>
                    </div>
                </div>
            </div>
        </form>
        <form action="digest.php" method="post" id="DgstLogin">
            <div class="demo-table">
                <input type="submit" name="dgstlogin" value="Digest Authentification"
                class="btnLogin"></span>
            </div>
        </form>
        <div class="demo-table">
            <div class="g-signin2" data-onsuccess="onSignIn"></div>
        </div>
    </div>
</body>
</html>
<script>
    function onSignIn(googleUser) {
        var profile = googleUser.getBasicProfile();
        console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
        console.log('Name: ' + profile.getName());
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
        
        <?php
        $_SESSION["userName"] = profile.getName();
        
        header("Location: ./index.php");
        ?>
    }
    
    function validate() {
        var $valid = true;
        document.getElementById("user_info").innerHTML = "";
        document.getElementById("password_info").innerHTML = "";
        
        var userName = document.getElementById("user_name").value;
        var password = document.getElementById("password").value;
        if(userName == "") 
        {
            document.getElementById("user_info").innerHTML = "required";
        	$valid = false;
        }
        if(password == "") 
        {
        	document.getElementById("password_info").innerHTML = "required";
            $valid = false;
        }
        return $valid;
    }
    </script>