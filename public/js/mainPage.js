document.addEventListener('DOMContentLoaded', function () {
    // Get the route of the page and store it in 'pageName'
    const path = window.location.pathname;
    // Remove leading/trailing slashes and split by '/'
    const segments = path.replace(/^\/+|\/+$/g, '').split('/');
    // Get the last segment as the page name, or empty string if root

    // Define Page Name
    let pageName;

    if (!isNaN(Number(segments[segments.length - 1]))) {
        pageName = segments[segments.length - 2];
    } else {
        switch (segments[segments.length - 1]) {
            case 'create':
            case 'edit' :
            case 'show':
            case 'update':
                pageName = segments[segments.length - 2];
                break;
            default:
                pageName = segments[segments.length - 1];
                break;
        }
        pageName = segments.length > 0 ? segments[segments.length - 1] : 'dashboard';
    }


    // If The Page Is RTL Change The pageName Into Arabic
    if (document.documentElement.dir == 'rtl') {
        pageName = swithNamesToArabic(pageName);
    }
    pageName = pageName.slice(0, 1).toUpperCase() + pageName.slice(1);



    // Change The Title Name
    document.title = pageName + ' | Super Sales';
    const pageNameElements = document.querySelectorAll('.page-name-e');
    pageNameElements.forEach(e => {
        e.textContent = pageName;
    });

    // Add active class to the current page link in the sidebar
    const links = document.querySelectorAll('.nav-link');
    links.forEach(link => {
        let name = link.getAttribute('href').split('/').pop();
        if (document.documentElement.dir == 'rtl') {
            name = swithNamesToArabic(name);
        }

        if (name.toLowerCase() === pageName.toLowerCase()) {
            link.classList.add('active');
        }
    });

    // Enhanced filter button functionality
    setupEnhancedFilterButtons();
});

function swithNamesToArabic(theName) {
    // If The Page Is RTL Change The pageName Into Arabic
    if (document.documentElement.dir == 'rtl') {
        switch (theName) {
            case 'dashboard':
                theName = 'لوحة التحكم';
                break;
            case 'clients':
                theName = 'العملاء';
                break;
            case 'products':
                theName = 'المنتجات';
                break;
            case 'sales':
                theName = 'المبيعات';
                break;
            case 'costs':
                theName = 'التكاليف';
                break;
            case 'supply':
                theName = 'الموردين';
                break;
            case 'projects':
                theName = 'المشاريع';
                break;
            case 'search':
                theName = 'البحث';
                break;
            case 'settings':
                theName = 'الإعدادات';
                break;
            case 'profile':
                theName = 'الملف الشخصي';
                break;
            case 'kitchen':
                theName = 'المطبخ';
                break;
        }
        return theName;
    }
}
// Enhanced filter button functionality
function setupEnhancedFilterButtons() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const daysInput = document.querySelector('.days-input');
    const formDaysInput = document.querySelector('.form-days-input');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to clicked button
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');
            let days = 1;

            // Determine days based on filter
            switch(filter) {
                case 'last_day':
                    days = 1;
                    break;
                case 'last_week':
                    days = 7;
                    break;
                case 'last_month':
                    days = 30;
                    break;
                case 'custom':
                    days = parseInt(daysInput.value) || 10;
                    // Show custom input
                    if (daysInput) {
                        daysInput.style.opacity = '1';
                    }
                    break;
            }

            // Hide custom input for other filters
            if (filter !== 'custom' && daysInput) {
                daysInput.style.opacity = '0';
            }

            // Update form input
            if (formDaysInput) {
                formDaysInput.value = days;
            }

            // Update statistics
            updateStatistics(days);
        });
    });

    // Custom days input handler
    if (daysInput) {
        daysInput.addEventListener('input', function() {
            const days = parseInt(this.value) || 10;
            if (formDaysInput) {
                formDaysInput.value = days;
            }
            updateStatistics(days);
        });
    }
}

// Update statistics with smooth animations
function updateStatistics(days) {
    // This would typically make an AJAX call to get new data
    // For now, we'll just animate the existing numbers
    const counters = document.querySelectorAll('.client_number, .product_number, .sales_number , .profits_number span , .costs_number , .supply_number');

    // You can add your statistics update logic here
    console.log('Updating statistics for', days, 'days');
}