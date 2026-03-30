/**
 * RTL-Aware GSAP Animations for Super Sales Dashboard
 * Handles direction-aware animations for both LTR and RTL layouts
 */

// Check if current layout is RTL
const isRTL = document.documentElement.dir === 'rtl' || document.documentElement.getAttribute('dir') === 'rtl';
const direction = isRTL ? -1 : 1; // Multiplier for direction-aware animations

// Initialize GSAP with RTL support
if (typeof gsap !== 'undefined') {
    
    // Set default ease and duration
    gsap.defaults({
        ease: "power2.out",
        duration: 0.6
    });

    // RTL-aware slide animations
    const slideInFromRight = isRTL ? 
        { x: -100, opacity: 0 } : 
        { x: 100, opacity: 0 };
    
    const slideInFromLeft = isRTL ? 
        { x: 100, opacity: 0 } : 
        { x: -100, opacity: 0 };

    // Page load animations
    gsap.registerPlugin(ScrollTrigger);

    // Animate statistics cards on scroll
    gsap.utils.toArray('.animate-on-scroll').forEach((element, index) => {
        gsap.fromTo(element, 
            {
                y: 50,
                x: 30 * direction,
                opacity: 0,
                scale: 0.9
            },
            {
                y: 0,
                x: 0,
                opacity: 1,
                scale: 1,
                duration: 0.8,
                delay: index * 0.1,
                ease: "back.out(1.7)",
                scrollTrigger: {
                    trigger: element,
                    start: "top 80%",
                    end: "bottom 20%",
                    toggleActions: "play none none reverse"
                }
            }
        );
    });

    // Animate filter buttons
    gsap.utils.toArray('.filter-btn').forEach((button, index) => {
        gsap.fromTo(button,
            {
                x: 20 * direction,
                opacity: 0,
                scale: 0.95
            },
            {
                x: 0,
                opacity: 1,
                scale: 1,
                duration: 0.5,
                delay: index * 0.05,
                ease: "power2.out"
            }
        );

        // Hover animations
        button.addEventListener('mouseenter', () => {
            gsap.to(button, {
                scale: 1.05,
                x: 5 * direction,
                duration: 0.3,
                ease: "power2.out"
            });
        });

        button.addEventListener('mouseleave', () => {
            gsap.to(button, {
                scale: 1,
                x: 0,
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });

    // Animate sidebar navigation
    gsap.utils.toArray('.sidenav .nav-item').forEach((item, index) => {
        gsap.fromTo(item,
            {
                x: -50 * direction,
                opacity: 0
            },
            {
                x: 0,
                opacity: 1,
                duration: 0.6,
                delay: index * 0.1,
                ease: "power2.out"
            }
        );
    });

    // Animate language switcher
    const languageSwitcher = document.querySelector('.language-switcher');
    if (languageSwitcher) {
        gsap.fromTo(languageSwitcher,
            {
                y: -20,
                x: 20 * direction,
                opacity: 0,
                scale: 0.9
            },
            {
                y: 0,
                x: 0,
                opacity: 1,
                scale: 1,
                duration: 0.8,
                delay: 0.5,
                ease: "back.out(1.7)"
            }
        );
    }

    // Animate dropdown menus
    function animateDropdown(dropdown, show = true) {
        if (show) {
            gsap.fromTo(dropdown,
                {
                    y: -10,
                    x: 15 * direction,
                    opacity: 0,
                    scale: 0.95
                },
                {
                    y: 0,
                    x: 0,
                    opacity: 1,
                    scale: 1,
                    duration: 0.3,
                    ease: "power2.out"
                }
            );
        } else {
            gsap.to(dropdown, {
                y: -10,
                x: 15 * direction,
                opacity: 0,
                scale: 0.95,
                duration: 0.2,
                ease: "power2.in"
            });
        }
    }

    // Animate cards on hover
    gsap.utils.toArray('.card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            gsap.to(card, {
                y: -5,
                x: 5 * direction,
                scale: 1.02,
                duration: 0.3,
                ease: "power2.out"
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card, {
                y: 0,
                x: 0,
                scale: 1,
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });

    // Animate buttons
    gsap.utils.toArray('.btn').forEach(button => {
        button.addEventListener('mouseenter', () => {
            gsap.to(button, {
                scale: 1.05,
                x: 3 * direction,
                duration: 0.2,
                ease: "power2.out"
            });
        });

        button.addEventListener('mouseleave', () => {
            gsap.to(button, {
                scale: 1,
                x: 0,
                duration: 0.2,
                ease: "power2.out"
            });
        });
    });

    // Animate icons in statistics cards
    gsap.utils.toArray('.card .icon').forEach((icon, index) => {
        gsap.fromTo(icon,
            {
                scale: 0,
                rotation: isRTL ? -180 : 180,
                opacity: 0
            },
            {
                scale: 1,
                rotation: 0,
                opacity: 1,
                duration: 0.8,
                delay: index * 0.2 + 0.3,
                ease: "back.out(1.7)"
            }
        );
    });

    // Page transition animations
    function animatePageTransition() {
        const tl = gsap.timeline();
        
        tl.to('.main-content', {
            x: 50 * direction,
            opacity: 0.7,
            duration: 0.3,
            ease: "power2.in"
        })
        .to('.main-content', {
            x: 0,
            opacity: 1,
            duration: 0.5,
            ease: "power2.out"
        });
        
        return tl;
    }

    // Language switch animation
    function animateLanguageSwitch() {
        const tl = gsap.timeline();
        
        // Fade out current content
        tl.to('body', {
            opacity: 0.7,
            scale: 0.98,
            duration: 0.3,
            ease: "power2.in"
        });
        
        return tl;
    }

    // Export functions for global use
    window.RTLAnimations = {
        animateDropdown,
        animatePageTransition,
        animateLanguageSwitch,
        isRTL,
        direction
    };

    // Initialize animations when DOM is ready
    document.addEventListener('DOMContentLoaded', () => {
        // Animate page load
        gsap.fromTo('body', 
            { opacity: 0 },
            { 
                opacity: 1, 
                duration: 0.5,
                ease: "power2.out"
            }
        );

        // Animate main content
        gsap.fromTo('.main-content',
            {
                y: 30,
                x: 20 * direction,
                opacity: 0
            },
            {
                y: 0,
                x: 0,
                opacity: 1,
                duration: 0.8,
                delay: 0.2,
                ease: "power2.out"
            }
        );
    });

    // Handle dropdown events
    document.addEventListener('shown.bs.dropdown', (event) => {
        const dropdown = event.target.querySelector('.dropdown-menu');
        if (dropdown) {
            animateDropdown(dropdown, true);
        }
    });

    document.addEventListener('hide.bs.dropdown', (event) => {
        const dropdown = event.target.querySelector('.dropdown-menu');
        if (dropdown) {
            animateDropdown(dropdown, false);
        }
    });

} else {
    console.warn('GSAP not loaded. RTL animations will not work.');
}
