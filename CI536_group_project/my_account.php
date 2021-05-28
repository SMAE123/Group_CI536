<?php
require 'connection.php';
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: main_login.php");
    exit;
}

$sql = 'SELECT * FROM products';

$result = $conn->query($sql);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$products = [];
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $products[] =  $row;
    }
}

$conn->close();
?>
<!doctype html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>University Marketplace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="index.js"></script>
</head>

<body class="parallax">
<div class="topnav">
    <div style="flex: 1">
        <img src="logo.jpeg" alt="logo" height="100">
    </div>
    <div style="flex: 2">
        <a href="index.html" class="active">HOME</a>
        <a href="about_us.html">ABOUT US</a>
        <a href="contact_us.html">CONTACT US</a>
        <a href="faqs.html">FAQs</a>
        <a href="my_account.php">MY ACCOUNT</a>
        <a href="validations_&_refs.html">VALIDATIONS & REFS</a>
        <?php if ($_SESSION['username']): ?>
            <a href="logout.php">Log Out</a>
        <?php else: ?>
            <a href="main_login.php">Login/Register</a>
        <?php endif; ?>
    </div>
</div>
<!--The 'wrapper' contains all the page content-->
<div class="container my-4 py-5">
    <?php if ($_SESSION['username']): ?>
        <h1 class="my-5 text-white">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <?php endif; ?>
    <p>
    <div class="row">
        <?php foreach ($products as $p): ?>
            <div class="col m-3" style="background-color: #fff">
                <img src="<?php echo $p['image'] ?>" style="height: 200px" alt="image">
                <h1 class="h1_about mb-5" style="line-height: 0.5"><?php echo $p['name'] ?></h1>
                <p><?php echo $p['description'] ?></p>
                <a href="product_details.php?product_id=<?php echo $p['id'] ?>">View More</a>
            </div>
        <?php endforeach;?>
    </div>
</div>
<footer class="footer1">
    <p>&copy; 2020/21, CI536 | Integrated Group Project | Marketplace | By</p>
    <p>Billal Maqsoudi | Elio Leka | Rachel Ives | Salma Elkaramany | Zakariaa Hmamou | Ahmed Omar.</p>
    <p>University of Brighton.</p>
</footer>
</body>
</html>
