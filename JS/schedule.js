let selectedDate = null;

function updateDays() {
    const month = document.querySelector('.month-btn.active').dataset.month;
    const year = document.querySelector('.year-btn.active').dataset.year;
    const daysContainer = document.getElementById('days-container');
    const daysInMonth = new Date(year, month, 0).getDate();
    const today = new Date();

    daysContainer.innerHTML = '';
    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month - 1, day);
        const dayOfWeek = date.getDay();
        const isPast = date < new Date(today.getFullYear(), today.getMonth(), today.getDate());
        const isToday = date.toDateString() === today.toDateString();

        if (dayOfWeek !== 0 && dayOfWeek !== 6) { // Exclude Sundays (0) and Saturdays (6)
            const button = document.createElement('button');
            button.className = 'schedule-btn';
            button.textContent = day;
            button.dataset.day = day; // Add data attribute for the day

            if (isPast || isToday) {
                button.disabled = true;
            } else {
                button.addEventListener('click', () => {
                    selectedDate = date;
                    document.querySelectorAll('.schedule-btn').forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    document.getElementById('selected-day').value = day; // Update hidden input for the day
                    updateTimes();
                });
            }
            daysContainer.appendChild(button);
        }
    }
}

function updateTimes() {
    if (!selectedDate) {
        console.error("Error: selectedDate is null. Please select a date first.");
        return; // Exit the function if selectedDate is not set
    }

    const timeGrid = document.querySelector('.time-grid');
    const now = new Date();

    timeGrid.innerHTML = '';
    const start = new Date();
    start.setHours(8, 0, 0, 0);
    const end = new Date();
    end.setHours(18, 0, 0, 0);
    const interval = 30; // 30 minutes

    // Determine the reservation type (repair or custom)
    const reservationType = document.body.dataset.reservationType;

    // Format the selected date as YYYY-MM-DD in the correct timezone
    const selectedDateString = selectedDate.toLocaleDateString('en-CA'); // Format as YYYY-MM-DD

    fetch(`getReservedTime.php?date=${selectedDateString}&type=${reservationType}`)
        .then(response => response.json())
        .then(reservedTimes => {
            console.log("Reserved Times:", reservedTimes); // Debugging: Log reserved times
            for (let time = new Date(start); time <= end; time.setMinutes(time.getMinutes() + interval)) {
                const button = document.createElement('button');
                button.className = 'time-btn';
                button.textContent = time.toTimeString().slice(0, 5); // Format time as HH:mm

                const timeString = time.toTimeString().slice(0, 5); // Format time as HH:mm
                if (reservedTimes.includes(timeString)) {
                    button.disabled = true; // Disable reserved times
                    button.classList.add('reserved'); // Optional: Add a class for styling
                } else if (selectedDate && selectedDate.toDateString() === now.toDateString() && time < now) {
                    button.disabled = true; // Disable past times for today
                } else {
                    button.addEventListener('click', () => {
                        document.querySelectorAll('.time-btn').forEach(btn => btn.classList.remove('active'));
                        button.classList.add('active');
                        document.getElementById('selected-time').value = button.textContent.trim(); // Update hidden input for the time
                        console.log(`Selected Date: ${selectedDate}, Selected Time: ${button.textContent}`);
                    });
                }
                timeGrid.appendChild(button);
            }
        })
        .catch(error => {
            console.error("Error fetching reserved times:", error);
        });
}

function setActiveButton(buttons, activeButton) {
    buttons.forEach(button => button.classList.remove('active'));
    activeButton.classList.add('active');
    updateDays();
    updateTimes();
}

document.addEventListener('DOMContentLoaded', () => {
    const monthButtons = document.querySelectorAll('.month-btn');
    const yearButtons = document.querySelectorAll('.year-btn');
    const today = new Date();
    const currentMonth = today.getMonth() + 1; // Months are 0-indexed in JavaScript
    const currentYear = today.getFullYear();

    // Set default active buttons for month and year
    const activeMonthButton = Array.from(monthButtons).find(button => !button.disabled) || monthButtons[0];
    const activeYearButton = Array.from(yearButtons).find(button => !button.disabled) || yearButtons[0];
    activeMonthButton.classList.add('active');
    activeYearButton.classList.add('active');

    // Set default values for hidden inputs
    document.getElementById('selected-month').value = activeMonthButton.getAttribute('data-month');
    document.getElementById('selected-year').value = activeYearButton.getAttribute('data-year');

    // Update days based on the default selections
    updateDays();

    // Do not call updateTimes() here because selectedDate is not set yet

    // Add event listeners for month buttons
    monthButtons.forEach(button => {
        const month = parseInt(button.dataset.month);
        if (month < currentMonth && parseInt(button.dataset.year) === currentYear) {
            button.disabled = true;
        } else {
            button.addEventListener('click', () => {
                setActiveButton(monthButtons, button);
                document.getElementById('selected-month').value = button.getAttribute('data-month'); // Update hidden input
            });
        }
    });

    // Add event listeners for year buttons
    yearButtons.forEach(button => {
        const year = parseInt(button.dataset.year);
        if (year < currentYear) {
            button.disabled = true;
        } else {
            button.addEventListener('click', () => {
                setActiveButton(yearButtons, button);
                document.getElementById('selected-year').value = button.getAttribute('data-year'); // Update hidden input
            });
        }
    });
});

// Update hidden inputs when days are clicked
document.getElementById('days-container').addEventListener('click', event => {
    if (event.target.classList.contains('schedule-btn')) {
        document.getElementById('selected-day').value = event.target.textContent.trim();
    }
});