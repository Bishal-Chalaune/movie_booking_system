<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $day = $_POST['day'];
    $time = $_POST['time'];
    $m_id = $_POST['movie'];
    $price = $_POST['price'];

    // Prepare and execute SQL insert statement
    $sql = "INSERT INTO audi (name, day, time, m_id, price) VALUES ('$name', '$day', '$time', $m_id, '$price')";
    if (mysqli_query($conn, $sql)) {
        echo "Record added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audi Booking System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        form {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
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
        <form action="#" method="post">
            <label for="name">Name:</label>
            <select id="name" name="name" required>
                <option value = "">-</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>

            <label for="day">Day:</label>
            <select id="day" name="day" required>
                <option value = "">-</option>
            </select>

            <label for="time">Time:</label>
            <select id="time" name="time" required>
                <option value = "">-</option>
            </select>


            <label for="movie">Movie:</label>
            <select id="movie" name="movie">
                <?php
                $sql = "SELECT * FROM movie";
                $res = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($res)) {
                    echo '<option value ="' . $row["id"] . '">' . $row["name"] . '</option>';
                }
                ?>
            </select><br><br>

            <label for="price">Price:</label>
            <input type="text" id="price" name="price" required><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>

</body>

</html>

<script>
    document.getElementById('day').addEventListener('change', function() {
        const selectedValue = this.value;
        const selectedAudi = document.getElementById('name').value;

        fetch('./assets/php_functions/time_selector.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'day=' + encodeURIComponent(selectedValue) + '&audi=' + encodeURIComponent(selectedAudi)
        })
        .then(response => response.json())
        .then(data => {
            const timeSelect = document.getElementById('time');
            
            timeSelect.innerHTML = '';

            const hyphenOption = document.createElement('option');
            hyphenOption.value = "";
            hyphenOption.textContent = "-";
            timeSelect.appendChild(hyphenOption);

            data.times.forEach(time => {
                const option = document.createElement('option');
                option.value = time;
                option.textContent = time;
                timeSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });


    document.getElementById('name').addEventListener('change', function() {
        const selectedValue = this.value;

        fetch('./assets/php_functions/day_selector.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'name=' + encodeURIComponent(selectedValue)
        })
        .then(response => response.json())
        .then(data => {
            const daySelect = document.getElementById('day');
            
            daySelect.innerHTML = '';

            const hyphenOption = document.createElement('option');
            hyphenOption.value = "";
            hyphenOption.textContent = "-";
            daySelect.appendChild(hyphenOption);

            data.days.forEach(day => {
                const option = document.createElement('option');
                option.value = day;
                option.textContent = day;
                daySelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>

