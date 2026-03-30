// GSAP Animations for Super Sales Dashboard
// Professional animations to enhance user experience

// Import GSAP (if using modules, otherwise loaded via CDN)
// import { gsap } from "gsap";

// Initialize GSAP animations when DOM is loaded

document.addEventListener('DOMContentLoaded', function() {
    // Initialize animations after a short delay
    initGSAPAnimations();
});

function initGSAPAnimations() {
    // Set initial states for animations
    setInitialStates();

    // Page load animations
    animatePageLoad();

    // Setup hover effects
    setupHoverEffects();

    // Setup interactive animations
    setupInteractiveAnimations();

    // Setup number counters
    setupNumberCounters();

    // Setup form animations
    setupFormAnimations();

    // Setup dropdown animations
    setupDropdownAnimations();

    // Setup scroll animations
    // setupScrollAnimations();

    // Enhance filter buttons
    enhanceFilterButtons();

}

// Set initial states for elements that will be animated
function setInitialStates() {
    // Hide cards initially for entrance animation
    gsap.set('.card', {
        opacity: 0,
        y: 50,
        scale: 0.9
    });

    // Hide sidebar items
    gsap.set('.nav-link', {
        opacity: 0,
        x: -30
    });

    // Hide main content initially
    gsap.set('.main-content', {
        opacity: 0
    });

    // Set initial state for statistics numbers
    gsap.set('.client_number, .product_number, .sales_number , .costs_number , .profits_number span , .supply_number', {
        opacity: 0
    });
}

// Main page load animation sequence
function animatePageLoad() {
    const tl = gsap.timeline();

    // Animate main content fade in
    tl.to('.main-content', {
        opacity: 1,
        duration: 0.5,
        ease: "power2.out"
    })

    // Animate sidebar navigation items
    .to('.nav-link', {
        opacity: 1,
        x: 0,
        duration: 0.6,
        stagger: 0.1,
        ease: "back.out(1.7)"
    }, "-=0.3")

    // Animate dashboard cards with stagger effect
    .to('.card', {
        opacity: 1,
        y: 0,
        scale: 1,
        duration: 0.8,
        stagger: 0.15,
        ease: "back.out(1.7)"
    }, "-=0.4")

    // Animate statistics numbers with counter effect
    .add(() => {
        animateCounters();
    }, "-=0.2");
}

// Animate number counters with realistic counting effect
function animateCounters() {
    const counters = document.querySelectorAll('.client_number, .product_number, .sales_number, .costs_number , .supply_number , .profits_number span');

    counters.forEach(counter => {
        const finalValue = Number(counter.textContent.trim());
        const obj = { value: 0 };

        gsap.to(obj, {
            value: finalValue,
            duration: 2,
            ease: "power2.out",
            // onUpdate: function() {
            //     counter.textContent = obj.value;
            // },
            onStart: function() {
                gsap.to(counter, {
                    opacity: 1,
                    duration: 0.3
                });
            }
        });
    });
}

// Setup hover effects for interactive elements
function setupHoverEffects() {
    // Card hover effects
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            gsap.to(card, {
                scale: 1.01,
                y: -2,
                boxShadow: "0 20px 40px rgba(0,0,0,0.1)",
                duration: 0.3,
                ease: "power2.out"
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card, {
                scale: 1,
                y: 0,
                boxShadow: "0 5px 15px rgba(0,0,0,0.05)",
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });

    // Button hover effects
    const buttons = document.querySelectorAll('.btn, .filter-btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
            gsap.to(button, {
                scale: 1.05,
                duration: 0.2,
                ease: "power2.out"
            });
        });

        button.addEventListener('mouseleave', () => {
            gsap.to(button, {
                scale: 1,
                duration: 0.2,
                ease: "power2.out"
            });
        });
    });

    // Navigation link hover effects
    const navLinks = document.querySelectorAll('aside .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('mouseenter', () => {
            gsap.to(link, {
                x: 10,
                backgroundColor: "rgba(255,255,255,0.1)",
                duration: 0.3,
                ease: "power2.out"
            });
        });

        link.addEventListener('mouseleave', () => {
            gsap.to(link, {
                x: 0,
                backgroundColor: "transparent",
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });
}

// Setup interactive animations for buttons and form elements
function setupInteractiveAnimations() {
    // Filter button animations
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));

            // Add active class to clicked button
            button.classList.add('active');

            // Create ripple effect
            createRippleEffect(e, button);

            // Animate button selection
            gsap.to(button, {
                scale: 0.95,
                duration: 0.1,
                yoyo: true,
                repeat: 1,
                ease: "power2.inOut"
            });
        });
    });
}

// Create ripple effect for button clicks
function createRippleEffect(event, element) {
    const ripple = document.createElement('span');
    const rect = element.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;

    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = x + 'px';
    ripple.style.top = y + 'px';
    ripple.classList.add('gsap-ripple');

    element.appendChild(ripple);

    gsap.fromTo(ripple, {
        scale: 0,
        opacity: 0.6
    }, {
        scale: 2,
        opacity: 0,
        duration: 0.6,
        ease: "power2.out",
        onComplete: () => {
            ripple.remove();
        }
    });
}

// Setup form animations
function setupFormAnimations() {
    const inputs = document.querySelectorAll('input, select, textarea');

    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            gsap.to(input, {
                scale: 1.02,
                boxShadow: "0 0 20px rgba(13,110,253,0.3)",
                duration: 0.3,
                ease: "power2.out"
            });
        });

        input.addEventListener('blur', () => {
            gsap.to(input, {
                scale: 1,
                boxShadow: "none",
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });
}

// Setup number counters for statistics
function setupNumberCounters() {

    const counters = document.querySelectorAll('.client_number, .product_number, .sales_number , .costs_number , .supply_number, .profits_number span');

    counters.forEach(counter => {
        const finalValue = Number(counter.textContent.trim()).toFixed();
        const obj = { value: 0 };

        gsap.to(obj, {
            value: finalValue,
            duration: 2,
            ease: "power2.out",
            onStart: function() {
                gsap.to(counter, {
                    opacity: 1,
                    duration: 0.3
                });
            }
        });
    });

}

// Utility function to animate page transitions
function animatePageTransition(callback) {
    const tl = gsap.timeline();

    tl.to('.main-content', {
        opacity: 0,
        scale: 0.95,
        duration: 0.3,
        ease: "power2.in"
    })
    .add(() => {
        if (callback) callback();
    })
    .to('.main-content', {
        opacity: 1,
        scale: 1,
        duration: 0.4,
        ease: "power2.out"
    });
}

// Loading animation
function showLoadingAnimation() {
    const loader = document.createElement('div');
    loader.className = 'gsap-loader';
    loader.innerHTML = `
        <div class="gsap-spinner"></div>
        <p>Loading...</p>
    `;
    document.body.appendChild(loader);

    gsap.fromTo(loader, {
        opacity: 0
    }, {
        opacity: 1,
        duration: 0.3
    });
}

function hideLoadingAnimation() {
    const loader = document.querySelector('.gsap-loader');
    if (loader) {
        gsap.to(loader, {
            opacity: 0,
            duration: 0.3,
            onComplete: () => {
                loader.remove();
            }
        });
    }
}

// Dropdown animations
function setupDropdownAnimations() {
    const dropdowns = document.querySelectorAll('.dropdown-menu');
    dropdowns.forEach(dropdown => {
        const trigger = dropdown.previousElementSibling;

        trigger.addEventListener('click', () => {
            gsap.fromTo(dropdown, {
                opacity: 0,
                y: -10,
                scale: 0.95
            }, {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 0.3,
                ease: "back.out(1.7)"
            });
        });
    });
}

// Animate elements when they come into view
function setupScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                gsap.fromTo(entry.target, {
                    opacity: 0,
                    y: 30
                }, {
                    opacity: 1,
                    y: 0,
                    duration: 0.6,
                    ease: "power2.out"
                });
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements that should animate on scroll
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
}

// Enhanced filter button animations
function enhanceFilterButtons() {
    const filterButtons = document.querySelectorAll('.filter-btn');

    filterButtons.forEach(button => {
        // Add magnetic effect
        button.addEventListener('mousemove', (e) => {
            const rect = button.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;

            gsap.to(button, {
                x: x * 0.1,
                y: y * 0.1,
                duration: 0.3,
                ease: "power2.out"
            });
        });

        button.addEventListener('mouseleave', () => {
            gsap.to(button, {
                x: 0,
                y: 0,
                duration: 0.5,
                ease: "elastic.out(1, 0.3)"
            });
        });
    });
}

// Page loader functions
function showPageLoader() {
    const loader = document.createElement('div');
    loader.className = 'page-loader';
    loader.innerHTML = `
        <div class="loader-content">
            <div class="loader-logo">💼</div>
            <div class="loader-text">Super Sales</div>
            <div class="loader-progress">
                <div class="loader-progress-bar"></div>
            </div>
        </div>
    `;
    document.body.appendChild(loader);
}

function hidePageLoader() {
    const loader = document.querySelector('.page-loader');
    if (loader) {
        gsap.to(loader, {
            opacity: 0,
            duration: 0.5,
            ease: "power2.out",
            onComplete: () => {
                loader.remove();
            }
        });
    }
}


// Export functions for use in other scripts
window.GSAPAnimations = {
    animatePageTransition,
    createRippleEffect,
    showLoadingAnimation,
    hideLoadingAnimation,
    setupScrollAnimations,
    enhanceFilterButtons,
    showPageLoader,
    hidePageLoader,
};

