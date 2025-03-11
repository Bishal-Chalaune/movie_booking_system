document.addEventListener("DOMContentLoaded", function() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"][name="tickets"]');
    var totalPriceElement = document.querySelector('.price .amount');
    var totalTicketsElement = document.querySelector('.price .count');

    // Initialize total price and ticket count
    var totalPrice = 0;
    var totalTickets = 0;
    var priceMovie = 1000;

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

    // Add event listener to radio buttons
    var radioButtons = document.querySelectorAll('input[name="date"]');

    radioButtons.forEach(function(radioButton) {
        radioButton.addEventListener('change', function() {
            if (this.checked) {
                times = this.value;
                load_timings(times.slice(1));
            }
        });
    });

    window.addEventListener('load', function(event) {
        for (var i = 0; i < radioButtons.length; i++) {
            if (radioButtons[i].checked) {
                times = radioButtons[i].value;
                load_timings(times.slice(1));
            }
        }
    
    });

});


function load_timings(time_index_string) {
    // Remove previous timings
    var timesDiv = document.querySelector('.times');
    if (timesDiv) {
        timesDiv.remove();
    }

    // Create a new div for timings
    var timingsDiv = document.createElement('div');
    timingsDiv.classList.add('times');

    // Array of available timings
    var times_in_day = ['11:00', '14:30', '18:00', '21:30'];

    // Convert time_index to array
    time_index = time_index_string.split('');

    // Create radio buttons for each timing
    time_index.forEach(function(time, index) {
        var input = document.createElement('input');
        input.type = 'radio';
        input.name = 'time';
        input.id = 't' + time;
        input.value = time;
        if (index === 0) {
            input.checked = true;
        }

        var label = document.createElement('label');
        label.setAttribute('for', 't' + time);
        label.classList.add('time');
        label.textContent = times_in_day[parseInt(time)]; // Use the time index to get the corresponding time from times_in_day array

        // Append input and label to timingsDiv
        timingsDiv.appendChild(input);
        timingsDiv.appendChild(label);
    });

    // Append timingsDiv to appropriate place in the DOM
    var datesDiv = document.querySelector('.dates');
    if (datesDiv) {
        datesDiv.insertAdjacentElement('afterend', timingsDiv);
    }
}
