<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DevConnect Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin : 0;
        }
        .auth-box {
            background: white;
            padding: 25px;
            width: 350px;
            border-radius: 7px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }
        .auth-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #845;
        }
        input {
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: none;
            background: #4CAF50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        #switch-to-login{
            font-size:15px;
            color : blue;
        }
        button:hover {
            background: #45a049;
        }
        .switcher {
            font-size: 15px;
        }
    </style>
</head>
<body>

<div class="auth-box">
    <div id = "registerbox">
        <h2>DevConnect Registration</h2>

        <form action="register_process.php" method="POST">

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" required placeholder="Enter Username">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" required placeholder="Enter Email">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" required placeholder="Enter Password">
            </div>

            <button type="submit" id = "btnRegister">Register</button>

            <div class = "switcher">
                <p>Already registered? Click <a href = "#" id = "switch-to-login">Login </a> </p>
            </div>
        </form>
    </div>
    <div id = "loginbox" style = "display :none;">

         <h2>DevConnect Login</h2>

        <form action = "login_process.php" method = "POST">

            <div class = "form-group">
                <label for= "email">Email Address</label>
                <input type = "email" name = "email" placeholder = "Enter Email" required>
            </div>

            <div class = "form-group">
                <label for= "password">Password</label>
                <input type = "password" name = "password" placeholder = "Enter password" required>
            </div>

            <button type = "submit">Login</button>

            <div class = "switcher">
                <p>Don't have an account? Click <a href = "#" id = "switch-to-register">Register</a></p>
            </div>

        </form>

    </div>
</div>


<script>
    const switchToLogin = document.getElementById("switch-to-login");
    const switchToRegister = document.getElementById("switch-to-register");
    const registerBox = document.getElementById("registerbox");
    const loginBox = document.getElementById("loginbox");

    switchToLogin.addEventListener("click", function(event){
        event.preventDefault();

        registerBox.style.display = "none";
        loginBox.style.display = "block";
    });

    switchToRegister.addEventListener("click", function(event){
        event.preventDefault();

        registerBox.style.display = "block";
        loginBox.style.display = "none";
    });


</script>
</body>
</html>
