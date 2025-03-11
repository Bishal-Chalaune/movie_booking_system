<?php
include("conn.php");
session_start();
$u_id = $_SESSION['user_id'];
echo $u_id;
if (isset($_SESSION['user_id'])) {
    if (isset($_GET['time']) && isset($_GET['day']) && isset($_GET['m_id']) && isset($_GET['tickets']) && isset($_GET['audi'])) {
        $time = $_GET['time'];
        $day = $_GET['day'];
        $movie_id = $_GET['m_id'];
        $seats = $_GET['tickets'];
        $audi = $_GET['audi'];
        $sql = "SELECT * from movie where id = $movie_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $movie_name = $row["name"];
        $sql = "SELECT * from audi where m_id=$movie_id and name = '$audi' and day = '$day' and time = '$time'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $price = $row["price"];
        $a_id = $row["id"];
        $seats = explode(',', $seats);

        $total  = $price * count($seats);

        $sql = "INSERT INTO bookings(a_id, u_id, price) VALUES('$a_id', '$u_id', '$total')";
        mysqli_query($conn, $sql);
        $inserted_id = mysqli_insert_id($conn);


        foreach ($seats as $seat) {
            $sql = "INSERT INTO seats(name, a_id, b_id) VALUES('$seat', '$a_id', '$inserted_id')";
            mysqli_query($conn, $sql);
        }
        $_SESSION['is_redirected_from_booking'] = '';
        header("Location: index.php");
    }
} else {

    header("location:./login.php");
}
