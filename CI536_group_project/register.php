<?php
// Include config file
require_once "connection.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: main_login.php");
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
		<title>Register</title>
	</head>

	<body class="body_form">
		<!--The 'wrapper2' contains all the page content-->
		<div class="wrapper2">
			<header class="banner2">
				<h1 class="h1_2">Register</h1>
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
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h1>Register</h1><hr><br>

                    <div class="input_login">
                        <input id="text_login" name="username" type="text" required placeholder="Enter username" value="<?php echo $username; ?>"/><br>

                    </div>
                    <div class="input_login">
                        <input id="text_login2" name="password" type="password" required placeholder="Enter password" value="<?php echo $password; ?>"/><br><br>
                    </div>
                    <button type="submit" value="Login" class="btn_login">Register</button><br><br><hr>
                    <p>Already registered? <span><a href="main_login.php">Click here to sign in</a></span></p><hr>
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
