<html>
<head>
    <meta name="google-signin-client_id" content="960318417031-3rai1932j0342j4sbf5trrbd6vv6kgf5.apps.googleusercontent.com">
<?php
session_start();
if(isset($_COOKIE["username"])){
    $_SESSION["userName"] = $_COOKIE["username"];
}

if(!empty($_SESSION["userName"])) {
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
                    <label for="remember">Remember me:</label>
                    <input type="checkbox" name="remember" id="remember" value="true">
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
                <div class=field-column>
                    <input type="submit" name="dgstlogin" value="Digest Authentification"
                    class="btnLogin"></span>
                </div>
                <div class=field-column>
                    <div class=field-column>
                    <label for="rememberDig">Remember me:</label>
                    <input type="checkbox" name="rememberDig" id="rememberDig" value="true">
                </div>
                </div>
            </div>
        </form>
        <div class="demo-table">
            <button class="btnLogin" onclick="hello('google').login()">Google Login</button>
        </div>
        <div class="demo-table">
            <button class="btnLogin" onclick="hello('google').logout()">Google Logout</button>
        </div>
        <div id="logTab" class="demo-table">
        </div>
        <div class="demo-table">
            <form action="csrfsubmit.php" method="post" >
                <input type="hidden" name="CSRFToken" value="MYJRGQTmzM12WN1GEjD2OQOMlOEjDjM4wMwmmOYYYNwxENWAl2UMQVGZ4IYhTDGZ4YJMDZZwjiwhYWJNE==">
                <label for="fname">First name:</label><br>
                <input type="text" id="fname" name="fname" required><br>
                <label for="lname">Last name:</label><br>
                <input type="text" id="lname" name="lname" required>
                <input type="submit" class="btnLogin" value="Submit"/>
            </form>
            
            <form action="csrfsubmit.php" method="post" >
                <input type="hidden" name="CSRFToken" value="mDRYQIDNNOJlYGZjjMh1hM2WMQOjVwNJWm4=YGDZTGi=ENY1GMZzMwETO2YjEwZ4JM4xYwQ2mlEAYUwDOWM">
                <label for="fname">First name:</label><br>
                <input type="text" id="1fname" name="fname" required><br>
                <label for="lname">Last name:</label><br>
                <input type="text" id="lname" name="lname" required>
                <input type="submit" class="btnLogin" value="Submit with wrong Token"/>
            </form>
        </div>
    </div>
    
    <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
</body>
</html>
<script src="hello.all.js"></script>
<script>
  hello.init({
    google: "960318417031-3rai1932j0342j4sbf5trrbd6vv6kgf5.apps.googleusercontent.com"     // not real id
  });
</script>
<script>

    hello.on('auth.login', function (auth) {

      // add a greeting and access the thumbnail and name from
      // the authorized response

      hello(auth.network).api('/me').then(function (resp) {
        var test = document.getElementById("logTab");
        var lab = document.getElementById("loggedUser");
        if (lab == null){
            var lab = document.createElement("div");
            lab.id = "loggedUser";
            lab.innerHTML = '<img src="' + resp.thumbnail + '" /> Welcome ' + resp.name;
            test.appendChild(lab);
        }
      });
    });

    // remove the greeting when we log out

    hello.on('auth.logout', function () {
      var lab = document.getElementById("loggedUser");
      if (lab != null) lab.outerHTML = "";
    });

</script>
<script>
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