<?php
if (isset($_GET['movie'])) {
    $movie_id = $_GET['movie'];
    include("conn.php");
    $sql = "SELECT * FROM movie WHERE id = $movie_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $movie_details = mysqli_fetch_assoc($result);
        $movie_id = $movie_details['id'];
        $movie_name = $movie_details['name'];
        $movie_description = $movie_details['description'];
        $movie_pic = $movie_details['movie_pic'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Movie ID not provided.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticket Booking</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>

<body>
    <?php include 'assets/php/nav.php'; ?>
    <div class="container">
        <div class="head_text"><b>Book Your Movies</b></div>

        <div class="main">
            <div class="book-movie">
                <img src="assets/pic/<?php echo $movie_pic; ?>" alt="<?php echo $movie_name; ?>" class="movie-image-book">
                <div class="movie-details">
                    <h1 class="movie-title"><?php echo $movie_name; ?></h1>
                    <p class="description"><?php echo $movie_description; ?></p>
                </div>
            </div>
            <form action="process_booking.php" method="post" class="nocss" onsubmit='return validateSeats()'>
                <div class="ticket-main">
                    <div class="tickets">
                        <div class="ticket-selector">
                            <div class="title">
                                <?php echo $movie_name; ?>
                            </div>
                            <div class="seats">
                                <div class="status">
                                    <div class="item">Available</div>
                                    <div class="item">Booked</div>
                                    <div class="item">Selected</div>
                                </div>
                                <div class="all-seats">
                                </div>
                            </div>
                            <div class="screentext">SCREEN</div>
                            <div class="timings">
                                <?php include 'dates.php'; ?>
                            </div>
                        </div>
                        <div class="price">
                            <div class="total">
                                <div class="per_seat_price">Per Ticket Price:</div>
                                <br>
                                <span><span class="count">0</span> Tickets</span>
                                <div>Rs<div class="amount">0</div>
                                </div>
                            </div>

                            <input type="hidden" name="m_id" value=<?php echo $movie_id ?>>
                            <button type="submit">Book</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
</body>

</html>


<script>
    function validateSeats() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"][name="tickets[]"]');
        var checked = false;

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                checked = true;
            }
        });

        if (!checked) {
            alert("Please select at least one option.");
            return false;
        }

        return true;
    }
</script>