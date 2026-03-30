document.addEventListener('DOMContentLoaded', function () {

    // Set All Elements
    const clientNumber = document.querySelector('.client_number');
    const clientPer = document.querySelector('.client_per');
    const suppliesNumber = document.querySelector('.supply_number');
    const suppliesPer = document.querySelector('.supply_per');
    const salesNumber = document.querySelector('.sales_number');
    const salesPer = document.querySelector('.sales_per');
    const costsNumber = document.querySelector('.costs_number');
    const costsPer = document.querySelector('.costs_per');
    const profitsNumber = document.querySelector('.profits_number span');
    const profitsPer = document.querySelector('.profits_per');


    const numberField = document.querySelector('.days-input');

    const filterButtons = document.querySelectorAll('#filter-buttons button');

    let days = 0;
    colorPer();



    filterButtons.forEach(btn => {

        btn.addEventListener('click', function (e) {
        // Ripple effect
        let ripple = document.createElement('span');
        ripple.className = 'ripple';
        this.appendChild(ripple);

        let rect = this.getBoundingClientRect();
        let size = Math.max(rect.width, rect.height);
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
        ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';

        setTimeout(() => {
            ripple.remove();
        }, 600);

        // Button active state
        filterButtons.forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        if (this.getAttribute('data-filter') === 'custom') {
            // Create Simple Form That Has Number Field Only         
            numberField.style.opacity = 1
        } else {
            numberField.style.opacity = 0
        }

        updateBoxes();
        
        });
    });



    function getDaysFromBtns() {
        let days = 0;
        filterButtons.forEach(btn => {
        if (btn.classList.contains('active')) {
            if (btn.getAttribute('data-filter') === 'last_day') {
            days = 1;
            } else if (btn.getAttribute('data-filter') === 'last_week') {
            days = 7;
            } else if (btn.getAttribute('data-filter') === 'last_month') {
            days = 30;
            } else if (btn.getAttribute('data-filter') === 'custom') {
            days = numberField.value;
            }
        }
        });

        return days;
    }

    numberField.addEventListener('input', function () {
        days = this.value;
        // Check if the input is a number
        if (isNaN(days) || days <= 0 || days == '') {
            days = 1;
        }
        this.value = days;

        updateBoxes();
    });


    function updateBoxes() {
        // Update the values based on the selected filter
        // Get the selected days from the filter
        let days = getDaysFromBtns();
        document.querySelector('.form-days-input').value = days;
        // Using local dummy data (no network) for development / demo
        const data = {
            client_count: 312,
            client_percentage: '+4.2%',
            supply_count: 28,
            supply_percentage: '+1.5%',
            sale_count: 874,
            sale_percentage: '+3.8%',
            cost_count: 542,
            cost_percentage: '-0.9%',
            profits_count: 12540.75,
            profits_percentage: '+7.1%'
        };

        // Populate UI with dummy data
        clientNumber.innerHTML = data.client_count;
        clientPer.innerHTML = data.client_percentage;
        suppliesNumber.innerHTML = data.supply_count;
        suppliesPer.innerHTML = data.supply_percentage;
        salesNumber.innerHTML = data.sale_count;
        salesPer.innerHTML = data.sale_percentage;
        costsNumber.innerHTML = data.cost_count;
        costsPer.innerHTML = data.cost_percentage;
        // show profits rounded with thousands if needed
        profitsNumber.innerHTML = Number(data.profits_count).toFixed(0);
        profitsPer.innerHTML = data.profits_percentage;

        // Update color based on percentage
        colorPer();
    }


    function colorPer() {
            document.querySelectorAll('.dashboard-card.stat-card .metric-change').forEach(perEl => {
                
            if (perEl.textContent.includes('+')) {
                perEl.classList.remove('text-danger');
                perEl.classList.add('text-success');
            } else {
                perEl.classList.remove('text-success');
                perEl.classList.add('text-danger');
            }
            });
    }


    filterButtons[0].click();

});