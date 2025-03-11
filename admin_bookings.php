<?php
include'conn.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Booking System</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.head_text {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th, .table td {
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


    </style>

<body>
<?php include 'assets/php/nav.php'; ?>

    <div class="container">

        <div class="head_text"><b>Bookings Management Page</b></div>
        <table class="table">
            <thead>
                <tr>
                   <th scope="col">User Name</th>
                    <th scope="col">Audi Name</th>                    
                    <th scope="col"> Movie Name</th>
                    <th scope="col">Price</th>
                    <th scope="col"> Booking Time</th>
                  
               
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = 'SELECT u.name AS user_name, b.Price,a.name as audi_name, created_at,m.name as movie_name
        FROM bookings b
        INNER JOIN audi a ON b.a_id = a.id
        INNER JOIN users u ON b.u_id = u.id
        INNER JOIN movie m ON a.m_id = m.id';

      
            $result = mysqli_query($conn, $sql);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                           <td>{$row['user_name']}</td>
                            <td>{$row['audi_name']}</td>                            
                            <td>{$row['movie_name']}</td>
                            <td>{$row['Price']}</td>
                            <td>{$row['created_at']}</td>
                       
                         
                          </tr>";
                }
            }   
            ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>

