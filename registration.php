<?php 
include("conn.php");

if(isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $c_password = $_POST['confirm_password'];

    if ($password !== $c_password) {
        echo "Passwords do not match.";
        exit(); 
    }

    $sql = "INSERT INTO users(name, email, phone, password) VALUES('$name', '$email', '$phone', '$password')";

    $res = mysqli_query($conn, $sql);

    if($res) {
    
      header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php include 'assets/php/nav.php';?>

    <div class="container">
        <div class="head_text"><b>Create Your Account</b></div>
        <form action="#" method="post">
            <div>
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name" required><br>
            </div>
            <div>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" required><br>
            </div>
            <div>
                <label for="phone">Phone:</label><br>
                <input type="text" id="phone" name="phone" max="10" pattern="[0-9]{10}" required><br>
            </div>
            <div>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br>
            </div>
            <div>
                <label for="confirm_password">Confirm Password:</label><br>
                <input type="password" id="confirm_password" name="confirm_password" required><br>
            </div>
            <div>
                <input type="submit" name="submit" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>
