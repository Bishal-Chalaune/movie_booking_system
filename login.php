<?php
session_start();

include("conn.php");


if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT id,name FROM users WHERE email='$email' AND password='$password'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1 && $_SESSION['is_redirected_from_booking'] == 'yes') {
    $row = mysqli_fetch_assoc($result);

    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];
    header("location:./process_booking.php");
  } else if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];

    if ($row["id"] != 1) {
      if (isset($_SESSION['redirect_url'])) {
        header("Location: " . $_SESSION['redirect_url']);
        exit;
      }
      header("Location: index.php");
      exit;
    } else {
      if (isset($_SESSION['redirect_url'])) {
        header("Location: " . $_SESSION['redirect_url']);
        exit;
      }
      header("Location: admin.php");
      exit;
    }
  } else {
    $error = "Invalid email or password";
    echo $error;
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign in</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>

  <?php include 'assets/php/nav.php'; ?>

  <div class="container">
    <div class="head_text"><b>Log in Your Account</b></div>

    <form action="#" method="post">
      <div>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
      </div>
      <div>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
      </div>
      <div>
        <input type="submit" name="submit" value="Submit">
      </div>
    </form>
  </div>

</body>

</html>