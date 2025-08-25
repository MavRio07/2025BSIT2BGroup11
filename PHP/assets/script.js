let mobileMenuOpen = false;

document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

function initializeApp() {
    setupMobileMenu();
    setupModalEvents();
    setupFormValidation();
    
    const loginModal = document.getElementById('loginModal');
    if (loginModal && loginModal.classList.contains('show')) {
        showLoginModal();
    }
}

function setupMobileMenu() {
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const mobileNav = document.getElementById('mobileNav');
    
    if (hamburgerBtn && mobileNav) {
        hamburgerBtn.addEventListener('click', toggleMobileMenu);
        
        document.addEventListener('click', function(e) {
            if (mobileMenuOpen && !hamburgerBtn.contains(e.target) && !mobileNav.contains(e.target)) {
                closeMobileMenu();
            }
        });
        
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && mobileMenuOpen) {
                closeMobileMenu();
            }
        });
    }
}

function toggleMobileMenu() {
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const mobileNav = document.getElementById('mobileNav');
    
    if (mobileMenuOpen) {
        closeMobileMenu();
    } else {
        openMobileMenu();
    }
}

function openMobileMenu() {
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const mobileNav = document.getElementById('mobileNav');
    
    hamburgerBtn.classList.add('active');
    mobileNav.classList.add('active');
    mobileMenuOpen = true;
    
    document.body.style.overflow = 'hidden';
}

function closeMobileMenu() {
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const mobileNav = document.getElementById('mobileNav');
    
    hamburgerBtn.classList.remove('active');
    mobileNav.classList.remove('active');
    mobileMenuOpen = false;
    
    document.body.style.overflow = '';
}

function setupModalEvents() {
    const modal = document.getElementById('loginModal');
    
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeLoginModal();
            }
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('show')) {
                closeLoginModal();
            }
        });
    }
}

function showLoginModal() {
    const modal = document.getElementById('loginModal');
    if (modal) {
        modal.classList.add('show');
        modal.style.display = 'flex';
        
        const firstInput = modal.querySelector('input[type="text"]');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 300);
        }

        document.body.style.overflow = 'hidden';
    }
}

function closeLoginModal() {
    const modal = document.getElementById('loginModal');
    if (modal) {
        modal.classList.remove('show');
        
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
        
        document.body.style.overflow = '';
    }
}
function setupFormValidation() {
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitLogin();
        });
        
        const inputs = loginForm.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('blur', validateField);
            input.addEventListener('input', clearFieldError);
        });
    }
}

function validateField(e) {
    const field = e.target;
    const value = field.value.trim();
    
    clearFieldError(e);
    
    if (field.type === 'email' && value) {
        if (!isValidEmail(value)) {
            showFieldError(field, 'Please enter a valid email address');
        }
    }
    
    if (field.required && !value) {
        showFieldError(field, 'This field is required');
    }
}

function clearFieldError(e) {
    const field = e.target;
    const errorElement = field.parentNode.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
    field.classList.remove('error');
}

function showFieldError(field, message) {
    clearFieldError({ target: field });
    
    field.classList.add('error');
    
    const errorElement = document.createElement('div');
    errorElement.className = 'field-error';
    errorElement.textContent = message;
    errorElement.style.color = '#dc3545';
    errorElement.style.fontSize = '0.875rem';
    errorElement.style.marginTop = '0.25rem';
    
    field.parentNode.appendChild(errorElement);
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function submitLogin() {
    const form = document.getElementById('loginForm');
    const nameField = document.getElementById('modalNameInput');
    const emailField = document.getElementById('modalEmailInput');
    
    clearFieldError({ target: nameField });
    clearFieldError({ target: emailField });
    
    const name = nameField.value.trim();
    const email = emailField.value.trim();
    
    let hasErrors = false;
    
    if (!name) {
        showFieldError(nameField, 'Please enter your full name');
        hasErrors = true;
    }
    
    if (!email) {
        showFieldError(emailField, 'Please enter your email address');
        hasErrors = true;
    } else if (!isValidEmail(email)) {
        showFieldError(emailField, 'Please enter a valid email address');
        hasErrors = true;
    }
    
    if (!hasErrors) {
        const submitBtn = form.querySelector('.submit-btn');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Accessing...';
        submitBtn.disabled = true;
        
        form.submit();
    }
}

function showSafetyPlan() {
    const safetyInfo = document.getElementById('safety-info');
    if (safetyInfo) {
        safetyInfo.classList.remove('hidden');
        safetyInfo.scrollIntoView({ behavior: 'smooth' });
    }
}

function hideSafetyPlan() {
    const safetyInfo = document.getElementById('safety-info');
    if (safetyInfo) {
        safetyInfo.classList.add('hidden');
    }
}

function showShelterInfo() {
    const shelterInfo = document.getElementById('shelter-info');
    if (shelterInfo) {
        shelterInfo.classList.remove('hidden');
        shelterInfo.scrollIntoView({ behavior: 'smooth' });
    }
}

function hideShelterInfo() {
    const shelterInfo = document.getElementById('shelter-info');
    if (shelterInfo) {
        shelterInfo.classList.add('hidden');
    }
}

function showCounselorInfo() {
    const counselorInfo = document.getElementById('counselor-info');
    if (counselorInfo) {
        counselorInfo.classList.remove('hidden');
        counselorInfo.scrollIntoView({ behavior: 'smooth' });
    }
}

function hideCounselorInfo() {
    const counselorInfo = document.getElementById('counselor-info');
    if (counselorInfo) {
        counselorInfo.classList.add('hidden');
    }
}

function quickExit() {
    try {
        window.location.replace('https://www.google.com');
        
        if (typeof(Storage) !== "undefined") {
            sessionStorage.clear();
        }
        
        if (window.opener) {
            window.close();
        }
    } catch (e) {
        window.location.href = 'https://www.google.com';
    }
}

function clearBrowserData() {
    try {
        if (typeof(Storage) !== "undefined") {
            sessionStorage.clear();
        }
        
        const forms = document.querySelectorAll('form');
        forms.forEach(form => form.reset());
        
    } catch (e) {
        console.warn('Could not clear all browser data');
    }
}

function announceToScreenReader(message) {
    const announcement = document.createElement('div');
    announcement.setAttribute('aria-live', 'polite');
    announcement.setAttribute('aria-atomic', 'true');
    announcement.className = 'sr-only';
    announcement.textContent = message;
    
    document.body.appendChild(announcement);
    
    setTimeout(() => {
        document.body.removeChild(announcement);
    }, 1000);
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && e.target.classList.contains('card')) {
        e.target.click();
    }
    
    if (e.key === 'Tab') {
    }
});

const style = document.createElement('style');
style.textContent = `
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }
    
    .form-group input.error {
        border-color: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }
`;
document.head.appendChild(style);
