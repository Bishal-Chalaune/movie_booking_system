<?php
include 'conn.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Booking System</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <style>
    .pic{
        height: 200px;
        width: 100px;
    }
    </style>
</head>

<body>
<?php include 'assets/php/nav.php'; ?>

    <div class="container">

        <div class="head_text"><b>Movie Management Page</b></div>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Movie</th>
                    <th scope="col">Operations</th>
                  
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM movie";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <th scope='row'>{$row['id']}</th>
                        <td>{$row['name']}</td>
                        <td class='pic'><img src='./assets/pic/{$row['movie_pic']}' alt='Movie Picture' width='150' height='200'></td>
                        <td>
                        <button onclick=\"location.href='movie_update.php?id={$row['id']}'\">Update</button>
                       
                    </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No movie found</td></tr>";
            }
            ?>
            
            </tbody>
        </table>
    </div>
    
</body>
</html>

