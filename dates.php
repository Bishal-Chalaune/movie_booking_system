<?php
    $sql = "SELECT id, day, time,name FROM audi WHERE m_id = $movie_id";
    $result = mysqli_query($conn, $sql);
    $audis = array();

    while ($row = mysqli_fetch_array($result)) {
        $audis[] = $row['name'];
    }
    $audis = array_unique($audis);
    sort($audis);
    
    echo "<div class='audi'>";
    $index = 0;
    $checked = "checked";

    foreach ($audis as $audi) {
        echo "<input type='radio' name='audi' id='audi$index' value='$audi' $checked>";
        $checked = "";
        echo "<label for='audi$index' class='audi-item'>";
        echo "<div class='audi_text'>Audi $audi</div>";
        echo "</label>";
        $index++;
    }

    echo "</div>";
    echo "<br>";
?>
<div class="dates"></div>
<div class = "times"></div>

<script>
 const radioButtons = document.querySelectorAll('input[name="audi"]');

radioButtons.forEach((radioButton) => {
    radioButton.addEventListener('change', (event) => {
        if (event.target.checked) {
            const selectedValue = event.target.value; 
            const movieId = '<?php echo $movie_id; ?>';

            const xhr = new XMLHttpRequest();
            
            // Configure it: POST-request for the URL /process_selection.php
            xhr.open('POST', './assets/php_functions/user_day_selector.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Combine the data into one string
            const data = 'selectedValue=' + encodeURIComponent(selectedValue) + 
                         '&movie_id=' + encodeURIComponent(movieId);

            // Send the request over the network
            xhr.send(data);

            // Log the response
            xhr.onload = function() {
                if (xhr.status != 200) { // analyze HTTP response status
                    console.error(`Error ${xhr.status}: ${xhr.statusText}`); // e.g. 404: Not Found
                } else { // show the result
                    console.log(`Done, response received: ${xhr.responseText}`); // response is the server
                    
                    // Parse the JSON response
                    const datesOfDay = JSON.parse(xhr.responseText);

                    // Find the container div to append the new elements
                    const container = document.querySelector('.dates');
                    container.innerHTML = ''; // Clear any previous content
                    var checked_temp = true;
                    // Create and append new elements
                    for (const [key, value] of Object.entries(datesOfDay)) {
                        const input = document.createElement('input');
                        input.type = 'radio';
                        input.name = 'day';
                        input.id = key;
                        input.value = key;
                        input.checked = checked_temp;
                        checked_temp = false;
                        const label = document.createElement('label');
                        label.htmlFor = key;
                        label.className = 'dates-item';

                        const dayDiv = document.createElement('div');
                        dayDiv.className = 'day';
                        dayDiv.textContent = key;

                        const dateDiv = document.createElement('div');
                        dateDiv.className = 'date';
                        dateDiv.textContent = value;

                        label.appendChild(dayDiv);
                        label.appendChild(dateDiv);
                        container.appendChild(input);
                        container.appendChild(label);
                    }

                    // Re-attach event listeners to the newly created day buttons
                    const dayButtons = document.querySelectorAll('input[name="day"]');
                    dayButtons.forEach((radioButton) => {
                        radioButton.addEventListener('change', (event) => {
                            if (event.target.checked) {
                                const selectedValue = event.target.value;
                                const movieId = '<?php echo $movie_id; ?>';
                                const selectedRadio = document.querySelector('input[name="audi"]:checked');

                                const xhr = new XMLHttpRequest();
            
                                xhr.open('POST', './assets/php_functions/user_time_selector.php', true);
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                                const data = 'day=' + encodeURIComponent(selectedValue) + 
                                            '&movie_id=' + encodeURIComponent(movieId) +
                                            '&audi_id=' + encodeURIComponent(selectedRadio.value);

                                xhr.send(data);

                                xhr.onload = function() {
                                    if (xhr.status != 200) { 
                                        console.error(`Error ${xhr.status}: ${xhr.statusText}`);
                                    } else { 
                                        console.log(`Done, response received: ${xhr.responseText}`);
                                        var times = JSON.parse(xhr.responseText); 
                                        
                                        const timesContainer = document.querySelector('.times');
                                        timesContainer.innerHTML = ''; 
                                        var checked_temp = true;
                                        times.forEach(function(time) {
                                            const input = document.createElement('input');
                                            input.type = 'radio';
                                            input.name = 'time';
                                            input.id = time;
                                            input.value = time;
                                            input.checked = checked_temp;
                                            checked_temp = false;

                                            var label = document.createElement('label');
                                            label.setAttribute('for', input.id);
                                            label.className = 'time';
                                            label.textContent = time;
                                            
                                            timesContainer.appendChild(input);
                                            timesContainer.appendChild(label);
                                        }); 
                                        
                                        const timeButtons = document.querySelectorAll('input[name="time"]');
                                        timeButtons.forEach((radioButton) => {
                                            radioButton.addEventListener('change', (event) => {
                                                if (event.target.checked) {
                                                    const time = event.target.value;
                                                    const movieId = '<?php echo $movie_id; ?>';
                                                    const audi = document.querySelector('input[name="audi"]:checked').value;
                                                    const day = document.querySelector('input[name="day"]:checked').value;
                                                    const xhr = new XMLHttpRequest();
            
                                                    xhr.open('POST', './assets/php_functions/user_price_selector.php', true);
                                                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                                                    const data = 'day=' + encodeURIComponent(day) + 
                                                                '&movie=' + encodeURIComponent(movieId) +
                                                                '&time=' + encodeURIComponent(time) +
                                                                '&audi=' + encodeURIComponent(audi);

                                                    xhr.send(data);

                                                    xhr.onload = function() {
                                                        if (xhr.status != 200) { 
                                                            console.error(`Error ${xhr.status}: ${xhr.statusText}`);
                                                        } else { 
                                                            console.log(`Done, response received: ${xhr.responseText}`);
                                                            const priceContainer = document.querySelector('.per_seat_price');
                                                            var data_price_seats = JSON.parse(xhr.responseText); 
                                                        
                                                            priceContainer.innerHTML = "Per Seat Price: "+data_price_seats[0];
                                                            seats_booked = data_price_seats[1];
                                                            seats_booked = seats_booked.map(numStr => parseInt(numStr, 10));

                                                            // Select the .all-seats container
                                                            let seatsContainer = document.querySelector(".all-seats");
                                                            seatsContainer.innerHTML = "";

                                                            // Loop to create 60 seats
                                                            for (let i = 0; i < 60; i++) {
                                                                if (seats_booked.includes(i)){
                                                                    booked = "booked"
                                                                }else{
                                                                    booked = ""
                                                                }

                                                                // Create the input element
                                                                let input = document.createElement("input");
                                                                input.type = "checkbox";
                                                                input.name = "tickets[]";
                                                                input.class = "tickets";
                                                                input.id = `s${i}`;
                                                                input.value = i;

                                                                // Create the label element
                                                                let label = document.createElement("label");
                                                                label.htmlFor = `s${i}`;
                                                                label.className = `seat ${booked}`;

                                                                // Append input and label to the seats container
                                                                seatsContainer.appendChild(input);
                                                                seatsContainer.appendChild(label);
                                                            }

                                                            var checkboxes = document.querySelectorAll('input[type="checkbox"][name="tickets[]"]');
                                                            var totalPriceElement = document.querySelector('.price .amount');
                                                            var totalTicketsElement = document.querySelector('.price .count');

                                                            // Initialize total price and ticket count
                                                            var totalPrice = 0;
                                                            var totalTickets = 0;
                                                            var priceMovie = parseFloat(data_price_seats);

                                                            // Function to update total price and ticket count
                                                            function updatePrice() {
                                                                totalPrice = 0;
                                                                totalTickets = 0;
                                                                checkboxes.forEach(function(checkbox) {
                                                                    if (checkbox.checked) {
                                                                        totalPrice += priceMovie; 
                                                                        totalTickets++;
                                                                    }
                                                                });
                                                                totalPriceElement.textContent = totalPrice;
                                                                totalTicketsElement.textContent = totalTickets;
                                                            }

                                                            // Add event listener to each checkbox
                                                            checkboxes.forEach(function(checkbox) {
                                                                checkbox.addEventListener('change', function() {
                                                                    updatePrice();
                                                                });
                                                            });

                                                            // Initialize price on page load
                                                            updatePrice();
                                                        }
                                                    };


                                                    xhr.onerror = function() {
                                                        console.error('Request failed');
                                                    }; 
                                                }
                                            });
                                        });      
                                    }
                                    document.querySelector('input[name="time"]:checked').dispatchEvent(new Event('change'));
                                };

                                xhr.onerror = function() {
                                    console.error('Request failed');
                                }; 
                            }
                        });
                    });
                }
                document.querySelector('input[name="day"]:checked').dispatchEvent(new Event('change'));
            };

            xhr.onerror = function() {
                console.error('Request failed');
            };        
        }
    });
});

// Trigger change event for the initially checked radio button
document.querySelector('input[name="audi"]:checked').dispatchEvent(new Event('change'));

</script>
