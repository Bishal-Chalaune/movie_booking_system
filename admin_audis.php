<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audi Booking System</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <style>

        form {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="file"] {
            margin-top: 10px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }


    </style>
</head>

<body>
<?php include 'assets/php/nav.php'; ?>

    <div class="container">

        <div class="head_text"><b>Audi Management Page</b></div>

        <div class="box">
            <div class = "button-container">
                <button class="button" onclick="window.location.href='admin_audi_list.php'">Audi List</button>


                <button class="button" onclick="window.location.href='admin_audi_add.php'">Audi Add</button>
            </div>
            
        </div>
        
    </div>
    
</body>
</html>

