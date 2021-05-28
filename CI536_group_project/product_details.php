<?php
require 'connection.php';

$sql = 'SELECT * FROM products where id = ' . $_GET['product_id'];

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
        <a href="main_login.php">Login/Register</a>
    </div>
</div>
<!--The 'wrapper' contains all the page content-->
<div class="container my-4 py-5" style="background-color: #fff">
        <?php foreach ($products as $p): ?>
            <div class="col m-3" style="background-color: #fff">
                <img src="<?php echo $p['image'] ?>" style="height: 500px" alt="image">
                <h1 class="h1_about mb-5" style="line-height: 0.5"><?php echo $p['name'] ?></h1>
                <p><?php echo $p['description'] ?></p>
                <button type="button" class="btn btn-primary">
                    <img src="pp-logo.jpg" style="height: 50px; width: 100px" alt="">
                </button>
            </div>
        <?php endforeach;?>
</div>
<footer class="footer1">
    <p>&copy; 2020/21, CI536 | Integrated Group Project | Marketplace | By</p>
    <p>Billal Maqsoudi | Elio Leka | Rachel Ives | Salma Elkaramany | Zakariaa Hmamou | Ahmed Omar.</p>
    <p>University of Brighton.</p>
</footer>

<!---------This is the paypal integration----->


<script src="https://www.paypal.com/sdk/js?client-id=Ac2TsjsptvmL7x4OwvYf97ICL43VGfJPI13Q0tcUdjUP7dIrqKSGq0n6jdZEFjQipSnyuLJ4gojVTofE"></script>

<div id="paypal-button-container"></div>


<!------------ Add the checkout buttons---------------->

<script>

    paypal.Buttons({

        createOrder: function(data, actions) {

          return actions.order.create({

            purchase_units: [{

              amount: {

                value: '0.01'

              }

            }]

          });

        },

        onApprove: function(data, actions) {

          return actions.order.capture().then(function(details) {

            alert('Transaction completed by ' + details.payer.name.given_name);

          });

        }

    }).render('#paypal-button-container');

</script>
</body>
</html>
