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
            if (isPast || isToday) {
                button.disabled = true;
            } else {
                button.addEventListener('click', () => {
                    selectedDate = date;
                    document.querySelectorAll('.schedule-btn').forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    updateTimes();
                });
            }
            daysContainer.appendChild(button);
        }
    }
}

function updateTimes() {
    const timeGrid = document.querySelector('.time-grid');
    const now = new Date();
    
    timeGrid.innerHTML = '';
    const start = new Date();
    start.setHours(8, 0, 0, 0);
    const end = new Date();
    end.setHours(18, 0, 0, 0);
    const interval = 30; // 30 minutes

    for (let time = new Date(start); time <= end; time.setMinutes(time.getMinutes() + interval)) {
        const button = document.createElement('button');
        button.className = 'time-btn';
        button.textContent = time.toTimeString().slice(0, 5);
        if (selectedDate && selectedDate.toDateString() === now.toDateString() && time < now) {
            button.disabled = true;
        } else {
            button.addEventListener('click', () => {
                document.querySelectorAll('.time-btn').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                // Proceed to the next section or perform any action needed
                console.log(`Selected Date: ${selectedDate}, Selected Time: ${button.textContent}`);
            });
        }
        timeGrid.appendChild(button);
    }
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
    const currentMonth = today.getMonth() + 1;
    const currentYear = today.getFullYear();

    monthButtons.forEach(button => {
        const month = parseInt(button.dataset.month);
        if (month < currentMonth && parseInt(button.dataset.year) === currentYear) {
            button.disabled = true;
        } else {
            button.addEventListener('click', () => setActiveButton(monthButtons, button));
        }
    });

    yearButtons.forEach(button => {
        const year = parseInt(button.dataset.year);
        if (year < currentYear) {
            button.disabled = true;
        } else {
            button.addEventListener('click', () => setActiveButton(yearButtons, button));
        }
    });

    // Set default active buttons
    const activeMonthButton = Array.from(monthButtons).find(button => !button.disabled) || monthButtons[0];
    const activeYearButton = Array.from(yearButtons).find(button => !button.disabled) || yearButtons[0];
    activeMonthButton.classList.add('active');
    activeYearButton.classList.add('active');
    updateDays();
    updateTimes();
});