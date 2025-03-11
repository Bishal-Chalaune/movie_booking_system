<?php
include 'conn.php'; // Assuming this file includes your database connection



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
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['name']}</td>
                                <td>{$row['day']}</td>
                                <td>{$row['time']}</td>";

                        // Fetching movie information using $row['m_id']
                        $movie_id = $row['m_id'];
                        $sql_movie = "SELECT * FROM movie WHERE id = $movie_id";
                        $result_movie = mysqli_query($conn, $sql_movie);

                        if ($result_movie && mysqli_num_rows($result_movie) > 0) {
                            $row_movie = mysqli_fetch_assoc($result_movie);
                            echo "<td>{$row_movie['name']}</td>";
                        } else {
                            echo "<td>No movie found</td>";
                        }

                        echo "<td>{$row['price']}</td>
                                <td>
                                    <button onclick=\"location.href='audi_update.php?id={$row['id']}'\">Update</button>
                                  
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>
