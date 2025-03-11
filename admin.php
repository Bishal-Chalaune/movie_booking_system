<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Booking System</title>
    <link rel="stylesheet" href="styles.css">

    <style>

    .box {
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);  background: white; */
        padding: 10px;
        width: 98%;
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        flex-direction: column;
    }

    .button-container{
        /* background: red; */
        margin: 100px;
        width:300px;
        justify-content: space-evenly;
        display: flex;
    }

    .button {
        margin-right: 25px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .button:hover {
        background-color: #0056b3;
    }
</style>
</head>

<body>
    <?php include 'assets/php/nav.php'; ?>


    <div class="container">

        <div class="head_text"><b>Admin Page</b></div>
        
        <div class="box">
            <div class = "button-container">
                <button class="button" onclick="window.location.href='admin_users.php'">Users</button>


                <button class="button" onclick="window.location.href='admin_movies.php'">Movies</button>
            </div>
            
            <div class = "button-container">
                <button class="button" onclick="window.location.href='admin_bookings.php'">Bookings</button>
                <button class="button" onclick="window.location.href='admin_audis.php'">Audis</button>
            </div>
            
        </div>
    </div>
    
</body>
</html>
