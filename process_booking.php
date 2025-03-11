<?php
session_start();
$u_id = 0;
if (isset($_SESSION['user_id'])) {
  $u_id = $_SESSION['user_id'];
}
include("conn.php");
$movie_name = " ";
$seat_names = " ";
$time = " ";
$total = " ";
$audi = " ";
$movie_id = " ";
$day = " ";
if (isset($_SESSION['is_redirected_from_booking']) && $_SESSION['is_redirected_from_booking'] == 'yes') {
  $movie_name = $_SESSION['movie_name'];
  $seat_names = $_SESSION['seat_names'];
  $time = $_SESSION['time'];
  $total = $_SESSION['total'];
  $day = $_SESSION['day'];
  $movie_id = $_SESSION['movie_id'];
  $audi = $_SESSION['audi'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$u_id > 0) {

  $time = $_POST['time'];
  $day = $_POST['day'];
  $movie_id = $_POST['m_id'];
  $seats = $_POST['tickets'];
  $audi = $_POST["audi"];

  arsort($seats);

  $seat_names = "";
  $mapping = array(
    0 => 'F',
    1 => 'E',
    2 => 'D',
    3 => 'C',
    4 => 'B',
    5 => 'A'
  );

  foreach ($seats as $seat) {
    $seat_row = (int)($seat / 10);
    $seat_column = $seat % 10 + 1;

    $seat_name = $mapping[$seat_row] . $seat_column;

    $seat_names .= $seat_name . ", ";
  }

  $sql = "SELECT * from movie where id = $movie_id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $movie_name = $row["name"];

  $sql = "SELECT * from audi where m_id=$movie_id and name = '$audi' and day = '$day' and time = '$time'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $price = $row["price"];
  $a_id = $row["id"];
  $total  = $price * count($seats);
  $seats = implode(',', $seats);
  $_SESSION['is_redirected_from_booking'] = "yes";
  $_SESSION['movie_name'] = $movie_name;
  $_SESSION['seat_names'] = $seat_names;
  $_SESSION['time'] = $time;
  $_SESSION['total'] = $total;
  $_SESSION['day'] = $day;
  $_SESSION['movie_id'] = $movie_id;
  $_SESSION['audi'] = $audi;
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $time = $_POST['time'];
  $day = $_POST['day'];
  $movie_id = $_POST['m_id'];
  $seats = $_POST['tickets'];
  $audi = $_POST["audi"];

  arsort($seats);

  $seat_names = "";
  $mapping = array(
    0 => 'F',
    1 => 'E',
    2 => 'D',
    3 => 'C',
    4 => 'B',
    5 => 'A'
  );

  foreach ($seats as $seat) {
    $seat_row = (int)($seat / 10);
    $seat_column = $seat % 10 + 1;

    $seat_name = $mapping[$seat_row] . $seat_column;

    $seat_names .= $seat_name . ", ";
  }

  $sql = "SELECT * from movie where id = $movie_id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $movie_name = $row["name"];

  $sql = "SELECT * from audi where m_id=$movie_id and name = '$audi' and day = '$day' and time = '$time'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $price = $row["price"];
  $a_id = $row["id"];
  $total  = $price * count($seats);
  $seats = implode(',', $seats);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Booking Finalize</title>
  <style>
    .nocss {
      background-color: white;
      box-shadow: 0 0 0 rgba(0, 0, 0, 0.1);
    }

    .bill-container {
      max-width: 600px;
      margin: 50px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .bill-head-text {
      text-align: center;
    }

    .booking-details {
      margin-bottom: 20px;
    }

    .booking-details label {
      font-weight: bold;
      color: black;
    }

    .bill-total label {
      text-align: center;
      margin-top: 30px;
      color: black;
    }
  </style>
  <link rel="stylesheet" href="styles.css">
</head>

<body>

  <?php include 'assets/php/nav.php'; ?>

  <div class="bill-container">
    <h1 class="bill-head-text">Booking Finalize</h1>
    <div class="booking-details">
      <label for="movie-name">Movie Name:</label>
      <span id="movie-name"><?php echo $movie_name; ?></span>
    </div>
    <div class="booking-details">
      <label for="seat-name">Seat Name:</label>
      <span id="seat-name"><?php echo $seat_names ?></span>
    </div>
    <div class="booking-details">
      <label for="timing">Timing:</label>
      <span id="timing"><?php echo $time ?></span>
    </div>
    <div class="booking-details">
      <label for="price">Total Price:</label>
      <span id="price"><?php echo $total ?></span>
    </div>
    <form action="process_finalize.php" method="get" class="nocss">
      <input type="hidden" name="time" value="<?php echo $time; ?>">
      <input type="hidden" name="day" value="<?php echo $day; ?>">
      <input type="hidden" name="m_id" value="<?php echo $movie_id; ?>">
      <input type="hidden" name="tickets" value="<?php echo $seats; ?>">
      <input type="hidden" name="audi" value="<?php echo $audi; ?>">
      <button type="submit">Confirm Booking</button>
    </form>

  </div>


</body>

</html>