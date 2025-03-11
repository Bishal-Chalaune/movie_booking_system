<?php
include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Booking System</title>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="styles.css">

    <style>
     

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    width: 25%;
    margin: 20px auto;
    
}


.head_text {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    border: solid;
}

.table th,
.table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    border: solid;
}

.table th {
    background-color: #f2f2f2;
}

    </style>

</head>

<body>
<?php include 'assets/php/nav.php'; ?>

    <div class="container">

        <div class="head_text"><b>User  Management System</b></div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Users </th>
                 
                 
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM users";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    echo "<tr>
                            
                            <td><a href ='user_personal_details.php?id={$id}'>  {$row['name']}</a></td>
                        
                       
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No users found</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>

