<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'sessions') or die('Unable to connect');

if (!isset($_SESSION["Username"]) && isset($_COOKIE["remember_username"]) && isset($_COOKIE["remember_password"])) {
    $cookieUser = mysqli_real_escape_string($conn, $_COOKIE["remember_username"]);
    $cookiePass = mysqli_real_escape_string($conn, $_COOKIE["remember_password"]);

    $select = mysqli_query($conn, "SELECT * FROM session WHERE username = '$cookieUser' AND password = '$cookiePass'");
    $row = mysqli_fetch_array($select);

    if (is_array($row)) {
        $_SESSION["Username"] = $row["username"];
        header("Location: login.php");
        exit();
    }
}

if (isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 40px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 40px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 30px;
            color: #333;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #667eea;
            outline: none;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .checkbox-group input[type="checkbox"] {
            margin-right: 10px;
        }

        .forgot {
            margin-bottom: 20px;
            text-align: center;
        }

        .forgot a {
            color: #667eea;
            text-decoration: none;
        }

        .forgot a:hover {
            text-decoration: underline;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px 15px;
            background: #667eea;
            border: none;
            color: white;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #5a67d8;
        }

        .error-message {
            color: #e53e3e;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body id="LoginForm">
    <div class="login-container">
        <h2>Please login</h2>
        <form action="index.php" method="post">
            <div class="form-group">
                <input type="text" value="<?php echo isset($_COOKIE["remember_username"]) ? htmlspecialchars($_COOKIE["remember_username"]) : ''; ?>" name="Username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" value="<?php echo isset($_COOKIE["remember_password"]) ? htmlspecialchars($_COOKIE["remember_password"]) : ''; ?>" name="Password" placeholder="Password" required>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" name="remember" <?php if (isset($_COOKIE["remember_username"]) && isset($_COOKIE["remember_password"])) { echo "checked"; } ?>>
                <label>Remember Me</label>
            </div>
            <div class="forgot">
                <a href="#">Forgot password</a>
            </div>
            <input type="submit" name="login" value="Login">
        </form>

        <?php
        if (isset($_POST['login'])) {
            $Username = mysqli_real_escape_string($conn, $_POST['Username']);
            $Password = mysqli_real_escape_string($conn, $_POST['Password']);

            $select = mysqli_query($conn, "SELECT * FROM session WHERE username = '$Username' AND password = '$Password'");
            $row = mysqli_fetch_array($select);

            if (is_array($row)) {
                $_SESSION["Username"] = $row["username"];
                $_SESSION["activity"] = isset($_SESSION["activity"]) ? $_SESSION["activity"] : [];
                array_unshift($_SESSION["activity"], "Logged in on " . date('Y-m-d H:i:s'));
                $_SESSION["activity"] = array_slice($_SESSION["activity"], 0, 5);

                if (isset($_POST['remember'])) {
                    setcookie("remember_username", $row["username"], time() + (30 * 24 * 60 * 60), "/", "", false, true);
                    setcookie("remember_password", $row["password"], time() + (30 * 24 * 60 * 60), "/", "", false, true);
                } else {
                    setcookie("remember_username", "", time() - 3600, "/");
                    setcookie("remember_password", "", time() - 3600, "/");
                }

                header("Location: login.php");
                exit();
            } else {
                echo '<p class="error-message">Invalid Username or Password</p>';
            }
        }
        ?>
    </div>
</body>
</body>
</html>
