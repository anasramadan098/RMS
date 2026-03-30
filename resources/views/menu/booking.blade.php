@extends('layouts.menu')

@section('title', 'حجز طاولة')

@section('content')
<style>
    .booking-container {
        min-height: 80vh;
        padding: 40px 20px;
        background: linear-gradient(135deg, var(--page) 0%, var(--white) 100%);
    }
    
    .booking-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        max-width: 600px;
        margin: 0 auto;
        animation: slideUp 0.6s ease-out;
    }
    
    .booking-header {
        background: linear-gradient(135deg, var(--green) 0%, var(--light-green) 100%);
        padding: 40px 30px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .booking-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="20" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="30" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    .booking-title {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 10px 0;
        position: relative;
        z-index: 1;
    }
    
    .booking-subtitle {
        font-size: 16px;
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 1;
    }
    
    .booking-icon {
        font-size: 48px;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
        animation: bounce 2s infinite;
    }
    
    .booking-form {
        padding: 40px 30px;
    }
    
    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
    }
    
    .form-group {
        flex: 1;
        position: relative;
    }
    
    .form-group.full-width {
        flex: 100%;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--green);
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-control {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid rgba(16, 39, 33, 0.1);
        border-radius: 15px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: var(--white);
        box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
        font-family: inherit;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--light-green);
        box-shadow: 0 0 0 3px rgba(75, 99, 67, 0.1);
        transform: translateY(-2px);
    }
    
    .form-control::placeholder {
        color: rgba(16, 39, 33, 0.4);
        font-weight: 500;
    }
    
    .form-control[type="number"] {
        -moz-appearance: textfield;
    }
    
    .form-control[type="number"]::-webkit-outer-spin-button,
    .form-control[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    .form-control[type="datetime-local"] {
        color-scheme: light;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
    }
    
    .submit-btn {
        width: 100%;
        background: linear-gradient(135deg, var(--green) 0%, var(--light-green) 100%);
        color: var(--white);
        border: none;
        padding: 18px 20px;
        border-radius: 15px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(16, 39, 33, 0.3);
        margin-top: 20px;
        position: relative;
        overflow: hidden;
    }
    
    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .submit-btn:hover::before {
        left: 100%;
    }
    
    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(16, 39, 33, 0.4);
    }
    
    .submit-btn:active {
        transform: translateY(-1px);
    }
    
    .success-message {
        background: linear-gradient(135deg, #51cf66, #40c057);
        color: white;
        padding: 20px 25px;
        border-radius: 15px;
        margin-bottom: 25px;
        display: none;
        text-align: center;
        box-shadow: 0 8px 20px rgba(81, 207, 102, 0.3);
        animation: slideDown 0.5s ease-out;
    }
    
    .error-message {
        background: linear-gradient(135deg, #ff6b6b, #fa5252);
        color: white;
        padding: 20px 25px;
        border-radius: 15px;
        margin-bottom: 25px;
        display: none;
        text-align: center;
        box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3);
        animation: shake 0.5s ease-out;
    }
    
    .input-icon {
        position: absolute;
        left: 15px;
        top: 65%;
        transform: translateY(-50%);
        color: var(--light-green);
        font-size: 18px;
        pointer-events: none;
    }
    
    .has-icon .form-control {
        padding-left: 50px;
    }
    
    .booking-info {
        background: rgba(75, 99, 67, 0.1);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        border-left: 4px solid var(--light-green);
    }
    
    .booking-info h4 {
        color: var(--green);
        margin-bottom: 10px;
        font-size: 18px;
        font-weight: 600;
    }
    
    .booking-info p {
        color: var(--light-green);
        margin: 0;
        font-size: 14px;
        line-height: 1.6;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }
    
    @media (max-width: 768px) {
        .booking-card {
            margin: 10px;
        }
        
        .booking-form {
            padding: 30px 20px;
        }
        
        .booking-header {
            padding: 30px 20px;
        }
        
        .form-row {
            flex-direction: column;
            gap: 0;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .booking-title {
            font-size: 24px;
        }
        
        .booking-icon {
            font-size: 36px;
        }
    }
</style>
<style>
    .submit-btn {
        position: relative;
        overflow: hidden;
    }
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
</style>


<div class="booking-container">
    <div class="booking-card">
        <div class="booking-header">
            <div class="booking-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <h1 class="booking-title" data-text="bookingTitle">حجز طاولة</h1>
            <p class="booking-subtitle" data-text="bookingSubtitle">احجز طاولتك الآن واستمتع بتجربة مميزة</p>
        </div>
        
        <form class="booking-form" action="{{ route('menu.book') }}" method="POST">
            @csrf
            
            <div class="success-message" id="successMessage" data-text="successMessage">
                تم إرسال طلب الحجز بنجاح! سنتواصل معك قريباً لتأكيد الحجز.
            </div>
            
            <div class="error-message" id="errorMessage" data-text="errorMessage">
                حدث خطأ في إرسال طلب الحجز. يرجى المحاولة مرة أخرى.
            </div>
            
            <div class="booking-info">
                <h4 data-text="importantInfoTitle">
                    <i class="fas fa-info-circle me-2"></i>
                    معلومات مهمة
                </h4>
                <p data-text="importantInfoText">
                    • يرجى الحجز قبل 24 ساعة على الأقل من موعد الزيارة<br>
                    • سيتم تأكيد الحجز عبر الهاتف خلال ساعات العمل<br>
                    • في حالة التأخير أكثر من 15 دقيقة قد يتم إلغاء الحجز
                </p>
            </div>
            
            <div class="form-row">
                <div class="form-group has-icon">
                    <label class="form-label" for="name" data-text="nameLabel">
                        <i class="fas fa-user me-1"></i>
                        الاسم الكامل
                    </label>
                    <input type="text" class="form-control" id="name" name="name" data-placeholder="namePlaceholder" placeholder="أدخل اسمك الكامل" required>
                    <i class="fas fa-user input-icon"></i>
                </div>
                
                <div class="form-group has-icon">
                    <label class="form-label" for="phone" data-text="phoneLabel">
                        <i class="fas fa-phone me-1"></i>
                        رقم الهاتف
                    </label>
                    <input type="tel" class="form-control" id="phone" name="phone" data-placeholder="phonePlaceholder" placeholder="01xxxxxxxxx" required>
                    <i class="fas fa-phone input-icon"></i>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group has-icon">
                    <label class="form-label" for="guests" data-text="guestsLabel">
                        <i class="fas fa-users me-1"></i>
                        عدد الأشخاص
                    </label>
                    <input type="number" class="form-control" id="guests" name="guests" min="1" max="20" data-placeholder="guestsPlaceholder" placeholder="عدد الأشخاص" required>
                    <i class="fas fa-users input-icon"></i>
                </div>
                
                <div class="form-group has-icon">
                    <label class="form-label" for="datetime" data-text="datetimeLabel">
                        <i class="fas fa-calendar-alt me-1"></i>
                        التاريخ والوقت
                    </label>
                    <input type="datetime-local" class="form-control" id="datetime" name="datetime" required>
                    <i class="fas fa-calendar-alt input-icon"></i>
                </div>
            </div>
            
            <div class="form-group full-width">
                <label class="form-label" for="event" data-text="eventLabel">
                    <i class="fas fa-star me-1"></i>
                    نوع المناسبة أو ملاحظات خاصة
                </label>
                <textarea class="form-control" required id="event" name="event" rows="4" data-placeholder="eventPlaceholder" placeholder="أخبرنا عن مناسبتك أو أي طلبات خاصة (عيد ميلاد، ذكرى سنوية، عشاء عمل، إلخ...)"></textarea>
            </div>
            
            <button type="submit" class="submit-btn" data-text="submitButton">
                <i class="fas fa-calendar-plus me-2"></i>
                تأكيد الحجز
            </button>
        </form>
    </div>
</div>

<script>


    document.addEventListener('DOMContentLoaded', function() {
        if (!localStorage.getItem('isLogin')) {
                location.href = '{{route('menu.auth')}}';
            }

        // Language texts for booking page
        const bookingTexts = {
            ar: {
                bookingTitle: 'حجز طاولة',
                bookingSubtitle: 'احجز طاولتك الآن واستمتع بتجربة مميزة',
                successMessage: 'تم إرسال طلب الحجز بنجاح! سنتواصل معك قريباً لتأكيد الحجز.',
                errorMessage: 'حدث خطأ في إرسال طلب الحجز. يرجى المحاولة مرة أخرى.',
                importantInfoTitle: 'معلومات مهمة',
                importantInfoText: '• يرجى الحجز قبل 24 ساعة على الأقل من موعد الزيارة<br>• سيتم تأكيد الحجز عبر الهاتف خلال ساعات العمل<br>• في حالة التأخير أكثر من 15 دقيقة قد يتم إلغاء الحجز',
                nameLabel: 'الاسم الكامل',
                phoneLabel: 'رقم الهاتف',
                guestsLabel: 'عدد الأشخاص',
                datetimeLabel: 'التاريخ والوقت',
                eventLabel: 'نوع المناسبة أو ملاحظات خاصة',
                namePlaceholder: 'أدخل اسمك الكامل',
                phonePlaceholder: '01xxxxxxxxx',
                guestsPlaceholder: 'عدد الأشخاص',
                eventPlaceholder: 'أخبرنا عن مناسبتك أو أي طلبات خاصة (عيد ميلاد، ذكرى سنوية، عشاء عمل، إلخ...)',
                submitButton: 'تأكيد الحجز',
                // Validation messages
                phoneError: 'رقم الهاتف يجب أن يكون 11 رقم ويبدأ بـ 01',
                datetimeError: 'يجب اختيار تاريخ ووقت في المستقبل',
                guestsError: 'عدد الأشخاص يجب أن يكون بين 1 و8 20',
                hoursError: 'ساعات العمل من 9 صباحاً حتى 11 مساءً'
            },
            en: {
                bookingTitle: 'Table Reservation',
                bookingSubtitle: 'Book your table now and enjoy a special experience',
                successMessage: 'Booking request sent successfully! We will contact you soon to confirm the reservation.',
                errorMessage: 'An error occurred while sending the booking request. Please try again.',
                importantInfoTitle: 'Important Information',
                importantInfoText: '• Please book at least 24 hours before your visit<br>• Reservation will be confirmed by phone during business hours<br>• If you are more than 15 minutes late, the reservation may be cancelled',
                nameLabel: 'Full Name',
                phoneLabel: 'Phone Number',
                guestsLabel: 'Number of Guests',
                datetimeLabel: 'Date and Time',
                eventLabel: 'Event Type or Special Notes',
                namePlaceholder: 'Enter your full name',
                phonePlaceholder: '01xxxxxxxxx',
                guestsPlaceholder: 'Number of guests',
                eventPlaceholder: 'Tell us about your occasion or any special requests (birthday, anniversary, business dinner, etc.)',
                submitButton: 'Confirm Booking',
                // Validation messages
                phoneError: 'Phone number must be 11 digits and start with 01',
                datetimeError: 'Please select a future date and time',
                guestsError: 'Number of guests must be between 1 and 20',
                hoursError: 'Business hours are from 9 AM to 11 PM'
            }
        };

        // Update page texts based on current language
        function updateBookingTexts() {
            const currentLang = currentLanguage;
            const texts = bookingTexts[currentLang];
            
            // Update titles and messages
            document.querySelector('[data-text="bookingTitle"]').textContent = texts.bookingTitle;
            document.querySelector('[data-text="bookingSubtitle"]').textContent = texts.bookingSubtitle;
            document.querySelector('[data-text="successMessage"]').textContent = texts.successMessage;
            document.querySelector('[data-text="errorMessage"]').textContent = texts.errorMessage;
            
            // Update info section
            document.querySelector('[data-text="importantInfoTitle"]').innerHTML = 
                '<i class="fas fa-info-circle me-2"></i>' + texts.importantInfoTitle;
            document.querySelector('[data-text="importantInfoText"]').innerHTML = texts.importantInfoText;
            
            // Update labels
            document.querySelector('[data-text="nameLabel"]').innerHTML = 
                '<i class="fas fa-user me-1"></i>' + texts.nameLabel;
            document.querySelector('[data-text="phoneLabel"]').innerHTML = 
                '<i class="fas fa-phone me-1"></i>' + texts.phoneLabel;
            document.querySelector('[data-text="guestsLabel"]').innerHTML = 
                '<i class="fas fa-users me-1"></i>' + texts.guestsLabel;
            document.querySelector('[data-text="datetimeLabel"]').innerHTML = 
                '<i class="fas fa-calendar-alt me-1"></i>' + texts.datetimeLabel;
            document.querySelector('[data-text="eventLabel"]').innerHTML = 
                '<i class="fas fa-star me-1"></i>' + texts.eventLabel;
            
            // Update placeholders
            document.querySelector('[data-placeholder="namePlaceholder"]').placeholder = texts.namePlaceholder;
            document.querySelector('[data-placeholder="phonePlaceholder"]').placeholder = texts.phonePlaceholder;
            document.querySelector('[data-placeholder="guestsPlaceholder"]').placeholder = texts.guestsPlaceholder;
            document.querySelector('[data-placeholder="eventPlaceholder"]').placeholder = texts.eventPlaceholder;
            
            // Update submit button
            document.querySelector('[data-text="submitButton"]').innerHTML = 
                '<i class="fas fa-calendar-plus me-2"></i>' + texts.submitButton;
            
            // Update document direction
            document.documentElement.dir = currentLang === 'ar' ? 'rtl' : 'ltr';
        }

        // Set minimum date to today
        const datetimeInput = document.getElementById('datetime');
        const now = new Date();
        
        // Add 1 hour to current time as minimum
        now.setHours(now.getHours() + 1);
        
        // Format datetime for input
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        
        const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        datetimeInput.min = minDateTime;


        // Phone number formatting
        formatPhoneFor(document.getElementById('phone'));

        // Form submission handling
        document.querySelector('.booking-form').addEventListener('submit', function(e) {
            const phone = document.getElementById('phone').value;
            const datetime = document.getElementById('datetime').value;
            const guests = document.getElementById('guests').value;
            
            // Validate phone number
            if (phone.length !== 11 || !phone.startsWith('0')) {
                e.preventDefault();
                const currentLang = window.currentLanguage || 'ar';
                showError(bookingTexts[currentLang].phoneError);
                return;
            }
            
            // Validate datetime is in future
            const selectedDate = new Date(datetime);
            const now = new Date();
            if (selectedDate <= now) {
                e.preventDefault();
                const currentLang = window.currentLanguage || 'ar';
                showError(bookingTexts[currentLang].datetimeError);
                return;
            }
            
            // Validate number of guests
            if (guests < 1 || guests > 20) {
                e.preventDefault();
                const currentLang = window.currentLanguage || 'ar';
                showError(bookingTexts[currentLang].guestsError);
                return;
            }
            
            // Validate business hours (9 AM to 11 PM)
            const selectedHour = selectedDate.getHours();
            if (selectedHour < 9 || selectedHour >= 23) {
                e.preventDefault();
                const currentLang = window.currentLanguage || 'ar';
                showError(bookingTexts[currentLang].hoursError);
                return;
            }
        });

        // Show error message
        function showError(message) {
            const errorElement = document.getElementById('errorMessage');
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            
            // Hide after 5 seconds
            setTimeout(() => {
                errorElement.style.display = 'none';
            }, 5000);
            
            // Scroll to top to show message
            document.querySelector('.booking-card').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }

        // Show success message (if redirected back with success)
        @if(session('success'))
            const successElement = document.getElementById('successMessage');
            successElement.style.display = 'block';
            
            // Scroll to top to show message
            document.querySelector('.booking-card').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
            
            // Hide after 8 seconds
            setTimeout(() => {
                successElement.style.display = 'none';
            }, 8000);
        @endif

        // Show error message (if redirected back with error)
        @if(session('error'))
            showError('x{{ session('error') }}');
        @endif

        // Initialize page texts when the page loads
        setTimeout(updateBookingTexts, 100);

        // Listen for language changes from the main layout
        if (window.updateTexts) {
            const originalUpdateTexts = window.updateTexts;
            window.updateTexts = function() {
                originalUpdateTexts();
                updateBookingTexts();
            };
        }

        // Animate form inputs on focus
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Add ripple effect to submit button
        document.querySelector('.submit-btn').addEventListener('click', function(e) {
            const button = this;
            const ripple = document.createElement('span');
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            button.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });

    })
</script>



@endsection