<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Movie Booking System</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Three columns */
            grid-gap: 20px; /* Spacing between grid items */
        }

        .movie-item {
            text-align: center;
        }

        .movie-image {
            max-width: 60%; 
            height: 250px; 
            margin-bottom: 10px; 
        }
        
      body {
        margin: 0;
        padding: 0;
        background-color:black;
        color:white;
      }

      #slider {
        position: relative;
        height: 50vw;
        overflow: hidden;
      }

      .slide {
        position: absolute;
        width: 100%;
        z-index: 500;
        height: 90vw;
      }

      .slide img {
        object-fit: cover;
    
        object-position: center;
        width: 100%;
        
      }

      .active {
        z-index: 1000;
      }

      .slideInLeft {
        animation-name: animateInLeft;
        z-index: 1000;
      }

      .slideInRight {
        animation-name: animateInRight;
        z-index: 1000;
      }

      .slideOutLeft {
        transform: translateX(-100%);
      }

      .slideOutRight {
        transform: translateX(100%);
      }
      .header{

      }

      @keyframes animateInLeft {
        0% {
          transform: translateX(-100%);
        }
        100% {
          transform: translateX(0%);
        }
      }

      @keyframes animateInRight {
        0% {
          transform: translateX(100%);
        }
        100% {
          transform: translateX(0%);
        }
      }

      .overlay-text {
        position: absolute;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        color: white;
        top: 0;
        left: 0;
        z-index: 10000;
        opacity: 1;
      }

      .overlay-text .header {
        font-size: 50px;
        font-weight: 800;
        
      }

      .overlay-text .text {
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        font-size: 22px;
        line-height: 30px;
        max-width: 700px;
        color: white;
      }

      .overlay-text {
        background: rgba(0, 0, 0, 0.5);
        position: absolute;
        height: 100%;
        width: 100%;
      }
      .footer{
    max-width: 968px;
    margin-left: auto;
    margin-right: auto;
    display: flex;
    justify-content: space-between;
}


.copyright{
    padding: 20px;
    text-align: center;
    color: var(--bg-color);
}

    </style>
   
</head>
<body>

<?php include 'assets/php/nav.php';?>
<div id="slider">
      <div class="overlay-text">
        <span class="header">Movie Booking</span>
        <span class="text">
          Book your favorite movie tickets online and enjoy the show with your
          friends and family.
        </span>
      </div>
      <div class="slide">
        <img src="./assets/pic/home1.jpg" />
      </div>
      <div class="slide">
        <img src="./assets/pic/home2.jpg" />
      </div>
      <div class="slide active"><img src="./assets/pic/home3.jpg" /></div>
      <div class="slide"><img src="./assets/pic/home4.jpg" /></div>
      <div class="slide"><img src="./assets/pic/c5.jpg" /></div>
    </div>

    <div class="container">
        <div class="head_text"><b>NOW SHOWING</b></div>

        <div class="movie-grid">
            <?php
            include("conn.php");
            
            $sql = "SELECT DISTINCT m_id FROM audi ORDER BY m_id";
            $result = mysqli_query($conn, $sql);

            while ($row1 = mysqli_fetch_assoc($result)) {
                $sql1 = "SELECT * FROM movie where id = {$row1['m_id']}";
                $result1 = mysqli_query($conn, $sql1);
                $row = mysqli_fetch_assoc($result1);
                echo '<div class="movie-item">';
                    echo '<a href="movie.php?movie=' . $row['id'] . '"><img src="assets/pic/' . $row['movie_pic'] . '" alt="' . $row['name'] . '" class="movie-image"></a>';
                echo '<p>' . $row['name'] . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const SLIDETIME = 500;

        const backButton = document.querySelector(".slider-back-btn");
        const forwardButton = document.querySelector(".slider-next-btn");

        const allSlides = [...document.querySelectorAll(".slide")];
        let clickable = true;
        let active = null;
        let newActive = null;

        function initSlider() {
          allSlides.forEach((slide) =>
            slide.setAttribute(
              "style",
              `transition: transform ${SLIDETIME}ms ease;
                     animation-duration: ${SLIDETIME}ms`
            )
          );
        }

        function changeSlide(forward) {
          if (clickable) {
            clickable = false;
            active = document.querySelector(".active");
            const activeSlideIndex = allSlides.indexOf(active);

            if (forward) {
              newActive = allSlides[(activeSlideIndex + 1) % allSlides.length];
              active.classList.add("slideOutLeft");
              newActive.classList.add("slideInRight", "active");
            } else {
              newActive =
                allSlides[
                  (activeSlideIndex - 1 + allSlides.length) % allSlides.length
                ];
              active.classList.add("slideOutRight");
              newActive.classList.add("slideInLeft", "active");
            }
          }
        }

        allSlides.forEach((slide) => {
          slide.addEventListener("transitionend", (e) => {
            if (slide === active && !clickable) {
              clickable = true;
              active.className = "slide";
            }
          });
        });

        setInterval(() => {
          changeSlide(true);
        }, 3_000);

        initSlider();
      });
    </script>
        <section class="footer">
        <a href="" class="logo">
            <i class="bx bxs-movie"></i>Movie Booking
        </a>
     
    </section>

  
    <div class="copyright">
        <p>&#169; Movie Booking All Right Reserved</p>
    </div>


</body>
</html>


