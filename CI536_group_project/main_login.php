<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: my_account.php");
    exit;
}

// Include config file
require_once "connection.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: my_account.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="stylesheet.css" />
    	<script src="index.js"></script>
		<title>Main Login</title>
	</head>

	<body class="body_form">
		<!--The 'wrapper2' contains all the page content-->
		<div class="wrapper2">
			<header class="banner2">
				<h1 class="h1_2">Sign In or Register</h1>
				<img class="img_form" src="logo.jpeg" alt="logo"/>
			</header>

			<div class="topnav2">
				<nav class="menu2"><!--The primary navigation for the page -->
					<ul>
						<li><a href="index.html">HOME</a></li>
					</ul>
				</nav>
			</div>

            <div class="box_login">
                <?php
                if(!empty($login_err)){
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h1>Sign In</h1><hr><br>
                    <div class="input_login">
                        <input id="text_login" name="username" type="text" required placeholder="Enter username" value="<?php echo $username; ?>"/><br>

                    </div>
                    <div class="input_login">
                        <input id="text_login2" name="password" type="password" required placeholder="Enter password"/><br><br>
                    </div>
                        <button type="submit" value="Login" class="btn_login">Sign In</button><br><br><hr>
                        <p>Not registered? <span><a href="register.php">Click here to register</a></span></p><hr>
                        <p><a href="index.html">Or go back to home page</a></p>
                </form>
            </div>


			<div class="parallax_form"></div>

			<footer class="footer2">
        		<p>&copy; 2020/21, CI536 | Integrated Group Project | Marketplace | By </p>
				<p>Billal Maqsoudi | Elio Leka | Rachel Ives | Salma Elkaramany | Zakariaa Hmamou | Ahmed Omar.</p>
				<p>University of Brighton.</p>
        	</footer>

		</div>
	</body>
</html>
