<?php
include 'conn.php'; // Assuming this file includes your database connection

// Handling form submission for updates
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $day = $_POST['day'];
        $time = $_POST['time'];
        $movie = $_POST['movie'];
        $price = $_POST['price'];

        // Prepare the SQL statement
        $sql_update = "UPDATE audi SET name='$name', day='$day', time='$time', movie='$movie', price=$price WHERE id=$id";

        if (mysqli_query($conn, $sql_update)) {
            echo '<script>alert("Record updated successfully!");</script>';
        } else {
            echo '<script>alert("Error updating record: ' . mysqli_error($conn) . '");</script>';
        }
    }
}

$sql = "SELECT * FROM audi ORDER BY name"; // Query to retrieve data from 'audi' table
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audi Booking System</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <style>
        .head_text {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Table */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .table td {
            vertical-align: middle;
        }

        /* Buttons */
        .table button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 5px;
        }
    </style>


    </head>
    <body>
    <?php include 'assets/php/nav.php'; ?>

    <div class="container">

        <div class="head_text"><b>Audi Management Page</b></div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Day</th>
                    <th scope="col">Time</th>
                    <th scope="col">Movie</th>
                    <th scope="col">Price</th>
                    
                </tr>
            </thead>
            <tbody>
    </body>
    </html>
