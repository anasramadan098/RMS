@extends('layouts.menu')

@section('title', 'تسجيل الدخول')

@section('content')
<style>
    .auth-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: linear-gradient(135deg, var(--page) 0%, var(--white) 100%);
    }
    
    .auth-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: 450px;
        position: relative;
        animation: slideUp 0.6s ease-out;
    }
    
    .auth-header {
        background: linear-gradient(135deg, var(--green) 0%, var(--light-green) 100%);
        padding: 30px 0;
        text-align: center;
        position: relative;
    }
    
    .auth-tabs {
        display: flex;
        justify-content: center;
        gap: 0;
        margin-bottom: 20px;
    }
    
    .tab-btn {
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.7);
        padding: 12px 30px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 25px 25px 0 0;
        position: relative;
    }
    
    .tab-btn.active {
        background: var(--white);
        color: var(--green);
        box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .auth-title {
        color: var(--white);
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        animation: fadeInUp 0.5s ease-out 0.2s both;
    }
    
    .auth-form {
        padding: 40px 30px;
        display: none;
    }
    
    .auth-form.active {
        display: block;
        animation: fadeIn 0.5s ease-out;
    }
    
    .form-group {
        margin-bottom: 25px;
        position: relative;
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
    
    .submit-btn {
        width: 100%;
        background: linear-gradient(135deg, var(--green) 0%, var(--light-green) 100%);
        color: var(--white);
        border: none;
        padding: 15px 20px;
        border-radius: 15px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(16, 39, 33, 0.3);
        margin-top: 10px;
    }
    
    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(16, 39, 33, 0.4);
    }
    
    .submit-btn:active {
        transform: translateY(-1px);
    }
    
    .error-message {
        background: #ff6b6b;
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: none;
        animation: shake 0.5s ease-out;
    }
    
    .success-message {
        background: #51cf66;
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: none;
        animation: fadeInUp 0.5s ease-out;
    }
    
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: none;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
    }
    
    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid rgba(16, 39, 33, 0.1);
        border-top: 3px solid var(--green);
        border-radius: 50%;
        animation: spin 1s linear infinite;
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
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
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
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    @media (max-width: 768px) {
        .auth-card {
            margin: 10px;
        }
        
        .auth-form {
            padding: 30px 20px;
        }
        
        .tab-btn {
            padding: 10px 20px;
            font-size: 14px;
        }
    }
</style>

<div class="auth-container">
    <div class="auth-card">
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner"></div>
        </div>
        
        <div class="auth-header">
            <div class="auth-tabs">
                <button class="tab-btn active"  id="loginTab" data-text="loginTab">
                    تسجيل الدخول
                </button>
                <button class="tab-btn"  id="registerTab" data-text="registerTab">
                    إنشاء حساب
                </button>
            </div>
            <h2 class="auth-title" id="authTitle" data-text="authTitle">تسجيل الدخول</h2>
        </div>
        
        <!-- Login Form -->
        <form class="auth-form active" id="loginForm">
            <div class="error-message" id="loginError"></div>
            <div class="success-message" id="loginSuccess"></div>
            
            <div class="form-group">
                <input type="tel" class="form-control" id="loginPhone" data-placeholder="loginPhonePlaceholder" placeholder="رقم الهاتف" required>
            </div>
            
            <div class="form-group">
                <input type="password" class="form-control" id="loginPassword" data-placeholder="loginPasswordPlaceholder" placeholder="كلمة المرور" required>
            </div>
            
            <button type="submit" class="submit-btn" data-text="loginSubmit">
                <i class="fas fa-sign-in-alt me-2"></i>
                تسجيل الدخول
            </button>
        </form>
        
        <!-- Register Form -->
        <form class="auth-form" id="registerForm" method="POST" action="{{ route('menu.signup') }}">
            @csrf
            <div class="error-message" id="registerError"></div>
            <div class="success-message" id="registerSuccess"></div>
            
            <div class="form-group">
                <input type="text" class="form-control" id="registerName" name="name" data-placeholder="registerNamePlaceholder" placeholder="الاسم الكامل" required>
            </div>
            
            <div class="form-group">
                <input type="tel" class="form-control" id="registerPhone" name="phone" data-placeholder="registerPhonePlaceholder" placeholder="رقم الهاتف" required>
            </div>
            
            <div class="form-group">
                <input type="email" class="form-control" id="registerEmail" name="email" data-placeholder="registerEmailPlaceholder" placeholder="البريد الإلكتروني" required>
            </div>
            
            <div class="form-group">
                <input type="password" class="form-control" id="registerPassword" name="password" data-placeholder="registerPasswordPlaceholder" placeholder="كلمة المرور" required>
            </div>
            
            <button type="submit" class="submit-btn" data-text="registerSubmit">
                <i class="fas fa-user-plus me-2"></i>
                إنشاء حساب
            </button>
        </form>
    </div>
</div>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        // Language texts for this page
        const authTexts = {
            ar: {
                loginTab: 'تسجيل الدخول',
                registerTab: 'إنشاء حساب',
                authTitle: 'تسجيل الدخول',
                authTitleRegister: 'إنشاء حساب',
                loginPhonePlaceholder: 'رقم الهاتف',
                loginPasswordPlaceholder: 'كلمة المرور',
                loginSubmit: 'تسجيل الدخول',
                registerNamePlaceholder: 'الاسم الكامل',
                registerPhonePlaceholder: 'رقم الهاتف',
                registerEmailPlaceholder: 'البريد الإلكتروني',
                registerPasswordPlaceholder: 'كلمة المرور',
                registerSubmit: 'إنشاء حساب',
                loginSuccess: 'تم تسجيل الدخول بنجاح!',
                loginError: 'حدث خطأ في تسجيل الدخول',
                registerSuccess: 'تم إنشاء الحساب بنجاح! يمكنك الآن تسجيل الدخول.',
                connectionError: 'حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.',
                n_f: 'الحساب غير موجود يرجي إنشاء حساب'
            },
            en: {
                loginTab: 'Sign In',
                registerTab: 'Sign Up',
                authTitle: 'Sign In',
                authTitleRegister: 'Sign Up',
                loginPhonePlaceholder: 'Phone Number',
                loginPasswordPlaceholder: 'Password',
                loginSubmit: 'Sign In',
                registerNamePlaceholder: 'Full Name',
                registerPhonePlaceholder: 'Phone Number',
                registerEmailPlaceholder: 'Email Address',
                registerPasswordPlaceholder: 'Password',
                registerSubmit: 'Sign Up',
                loginSuccess: 'Login successful!',
                loginError: 'Login error occurred',
                registerSuccess: 'Account created successfully! You can now sign in.',
                connectionError: 'Connection error. Please try again.',
                n_f: 'Account Not Found , Please Create Account'
            }
        };

        // Update page texts based on current language
        function updatePageTexts() {
            let currentLang = currentLanguage;
            const texts = authTexts[currentLang];
            
            // Update tabs
            document.getElementById('loginTab').textContent = texts.loginTab;
            document.getElementById('registerTab').textContent = texts.registerTab;
            
            // Update placeholders
            document.getElementById('loginPhone').placeholder = texts.loginPhonePlaceholder;
            document.getElementById('loginPassword').placeholder = texts.loginPasswordPlaceholder;
            document.getElementById('registerName').placeholder = texts.registerNamePlaceholder;
            document.getElementById('registerPhone').placeholder = texts.registerPhonePlaceholder;
            document.getElementById('registerEmail').placeholder = texts.registerEmailPlaceholder;
            document.getElementById('registerPassword').placeholder = texts.registerPasswordPlaceholder;
            
            // Update button texts
            const loginBtn = document.querySelector('#loginForm .submit-btn');
            const registerBtn = document.querySelector('#registerForm .submit-btn');
            
            loginBtn.innerHTML = `<i class="fas fa-sign-in-alt me-2"></i>${texts.loginSubmit}`;
            registerBtn.innerHTML = `<i class="fas fa-user-plus me-2"></i>${texts.registerSubmit}`;
            
            // Update title based on active tab
            const activeTab = document.querySelector('.tab-btn.active').id;
            document.getElementById('authTitle').textContent = activeTab === 'loginTab' ? texts.authTitle : texts.authTitleRegister;
            
            // Update document direction
            document.documentElement.dir = currentLang === 'ar' ? 'rtl' : 'ltr';
        }

        // Tab switching functionality
        function switchTab(tab) {
            const loginTab = document.getElementById('loginTab');
            const registerTab = document.getElementById('registerTab');
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const authTitle = document.getElementById('authTitle');
            
            // Clear any previous messages
            clearMessages();

            const texts = authTexts[currentLanguage];
            
            if (tab === 'login') {
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
                loginForm.classList.add('active');
                registerForm.classList.remove('active');
                authTitle.textContent = texts.authTitle;
            } else {
                registerTab.classList.add('active');
                loginTab.classList.remove('active');
                registerForm.classList.add('active');
                loginForm.classList.remove('active');
                authTitle.textContent = texts.authTitleRegister;
            }
        }

        document.querySelector('#loginTab').onclick = function () {
            switchTab('login');
        };
        document.querySelector('#registerTab').onclick = function () {
            switchTab('register');
        };

        
        // Clear error and success messages
        function clearMessages() {
            document.getElementById('loginError').style.display = 'none';
            document.getElementById('loginSuccess').style.display = 'none';
            document.getElementById('registerError').style.display = 'none';
            document.getElementById('registerSuccess').style.display = 'none';
        }

        // Show loading overlay
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }

        // Hide loading overlay
        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        // Show error message
        function showError(elementId, message) {
            const errorElement = document.getElementById(elementId);
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }

        // Show success message
        function showSuccess(elementId, message) {
            const successElement = document.getElementById(elementId);
            successElement.textContent = message;
            successElement.style.display = 'block';
        }

        // Login form submission
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            clearMessages();
            showLoading();
            
            const phone = document.getElementById('loginPhone').value;
            const password = document.getElementById('loginPassword').value;
            
            try {
                const response = await fetch("{{ route('menu.login') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        phone: phone,
                        password: password
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    // Success - store login status in localStorage
                    localStorage.setItem('isLogin', 'true');
                    localStorage.setItem('somi_client', JSON.stringify(data.client));
                    

                    const currentLang = currentLanguage;
                    showSuccess('loginSuccess', authTexts[currentLang].loginSuccess);
                    


                    // Redirect after 1.5 seconds
                    setTimeout(() => {
                        window.location.href = "{{ route('menu.index') }}";
                    }, 1500);
                } else {
                    // Error - show error message
                    const currentLang = currentLanguage;
                    let errorMessage = authTexts[currentLang].loginError;
                    
                    if (data.message) {
                        if (data.error = 'n_f') {
                            errorMessage = authTexts[currentLang].n_f;

                            setTimeout(() => {
                                switchTab('register');
                            }, 2000);
                        }
                    } else if (data.errors) {
                        // Handle validation errors
                        if (data.errors.phone) {
                            errorMessage = data.errors.phone[0];
                        } else if (data.errors.password) {
                            errorMessage = data.errors.password[0];
                        } else {
                            errorMessage = Object.values(data.errors)[0][0];
                        }
                    }
                    
                    showError('loginError', errorMessage);
                }
            } catch (error) {
                console.error('Login error:', error);
                const currentLang = window.currentLanguage || 'ar';
                showError('loginError', authTexts[currentLang].connectionError);
            } finally {
                hideLoading();
            }
        });

        // Register form submission (for future implementation)
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            clearMessages();
            showLoading();
            
            const name = document.getElementById('registerName').value;
            const phone = document.getElementById('registerPhone').value;
            const email = document.getElementById('registerEmail').value;
            const password = document.getElementById('registerPassword').value;

            try {
                const response = await fetch("{{ route('menu.signup') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name,
                        phone,
                        email,
                        password
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    
                    const currentLang = currentLanguage;

                    showSuccess('registerSuccess', authTexts[currentLang].registerSuccess);
                    

                    // Redirect after 1.5 seconds
                    setTimeout(() => {
                        switchTab('login');
                    }, 2500);
                } else {           
                    showError('registerError', data.message);
                }
            } catch (error) {
                const currentLang = currentLanguage;
                showError('registerError', authTexts[currentLang].connectionError);
            } finally {
                hideLoading();
            }
            

        });


        formatPhoneFor(document.getElementById('loginPhone'));
        formatPhoneFor(document.getElementById('registerPhone'));



        // Listen for language changes from the main layout
        if (window.updateTexts) {
            const originalUpdateTexts = window.updateTexts;
            window.updateTexts = function() {
                originalUpdateTexts();
                updatePageTexts();
            };
        }
    })


</script>
@endsection