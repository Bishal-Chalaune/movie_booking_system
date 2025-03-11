<?php
include 'conn.php'; 

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare SQL statement to fetch user details
    $sql = "SELECT id, name, email, phone, password FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $name, $email, $phone, $password);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Prepare SQL statement to fetch booking details along with audi and movie information
    $sql2 = "SELECT a.day, a.time, m.name as movie_name, a.name as audi_name, b.id as booking_id, b.created_at
             FROM bookings b
             JOIN audi a ON a.id = b.a_id
             JOIN movie m ON m.id = a.m_id
             WHERE b.u_id = ? order by b.created_at Desc";
    
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "i", $id);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $day, $time, $movie_name, $audi_name, $booking_id, $created_at);
    $bookings = [];
    while (mysqli_stmt_fetch($stmt2)) {
        $bookings[] = [
            'day' => $day,
            'time' => $time,
            'movie_name' => $movie_name,
            'audi_name' => $audi_name,
            'booking_id' => $booking_id,
            'created_at' => $created_at];   
        
    }
    mysqli_stmt_close($stmt2);

    // Fetch seats for each booking
    foreach ($bookings as &$booking) {
        $sql3 = "SELECT s.name
                 FROM seats s
                 WHERE s.b_id = ?";
        $stmt3 = mysqli_prepare($conn, $sql3);
        mysqli_stmt_bind_param($stmt3, "i", $booking['booking_id']);
        mysqli_stmt_execute($stmt3);
        mysqli_stmt_bind_result($stmt3, $seat_name);
        $seats = [];
        while (mysqli_stmt_fetch($stmt3)) {
            $mapping = array(
                0 => 'F',
                1 => 'E',
                2 => 'D',
                3 => 'C',
                4 => 'B',
                5 => 'A'
            );
            $seat_row = (int)($seat_name / 10); 
            $seat_column = $seat_name % 10 + 1; 
            $seat_name = $mapping[$seat_row] . $seat_column;
            $seats[] = $seat_name;
        }
        mysqli_stmt_close($stmt3);
        $booking['seats'] = implode(", ", $seats);
        
    }
} else {
    // Redirect to user_personal_details.php if ID is not provided
    header("Location: user_personal_details.php"); 
    exit();
}

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* styles.css */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        .head_text {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .details {
            margin-top: 20px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .details th,
        .details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .details th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <?php include 'assets/php/nav.php'; ?>
    <div class="container">
        <div class="head_text"><b>User Details</b></div>
        <div class="details">
            <table>
                <tr>
                    <th>Name</th>
                    <td><?php echo htmlspecialchars($name); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($email); ?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?php echo htmlspecialchars($phone); ?></td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td><?php echo htmlspecialchars($password); ?></td>
                </tr>
            </table>
        </div>

        <div class="head_text"><b>Booking Details</b></div>
        <div class="details">
            <table>
                <tr>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Movie</th>
                    <th>Audi</th>
                    <th>Seats</th>
                    <th>Booking Date</th>
                </tr>
                


<?php
function generateBookingRows($bookings) {
    return array_map(function($booking) {
        return '<tr>' .
            '<td>' . htmlspecialchars($booking['day']) . '</td>' .
            '<td>' . htmlspecialchars($booking['time']) . '</td>' .
            '<td>' . htmlspecialchars($booking['movie_name']) . '</td>' .
            '<td>' . htmlspecialchars($booking['audi_name']) . '</td>' .
            '<td>' . htmlspecialchars($booking['seats']) . '</td>' .
            '<td>' . htmlspecialchars(date('Y-m-d H:i:s', strtotime($booking['created_at']))) . '</td>' .
        '</tr>';
    }, $bookings);
}

$rows = generateBookingRows($bookings);
echo implode('', $rows);
?>

            </table>


            <h1>hello</h1>
        </div>
    </div>
</body>
</html>