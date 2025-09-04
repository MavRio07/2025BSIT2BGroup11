let mobileMenuOpen = false

document.addEventListener("DOMContentLoaded", () => {
  initializeApp()
  highlightActiveLink()
})

function initializeApp() {
  setupMobileMenu()
  setupModalEvents()
  setupFormValidation()

  const loginModal = document.getElementById("loginModal")
  if (loginModal && loginModal.classList.contains("show")) {
    showLoginModal()
  }
}

// -------------------- Mobile Menu --------------------
function setupMobileMenu() {
  const hamburgerBtn = document.getElementById("hamburgerBtn")
  const mobileNav = document.getElementById("mobileNav")

  if (hamburgerBtn && mobileNav) {
    hamburgerBtn.addEventListener("click", toggleMobileMenu)

    document.addEventListener("click", (e) => {
      if (mobileMenuOpen && !hamburgerBtn.contains(e.target) && !mobileNav.contains(e.target)) {
        closeMobileMenu()
      }
    })

    window.addEventListener("resize", () => {
      if (window.innerWidth > 768 && mobileMenuOpen) {
        closeMobileMenu()
      }
    })
  }
}

function toggleMobileMenu() {
  mobileMenuOpen ? closeMobileMenu() : openMobileMenu()
}

function openMobileMenu() {
  const hamburgerBtn = document.getElementById("hamburgerBtn")
  const mobileNav = document.getElementById("mobileNav")

  hamburgerBtn.classList.add("active")
  mobileNav.classList.add("active")
  mobileMenuOpen = true

  document.body.style.overflow = "hidden"
}

function closeMobileMenu() {
  const hamburgerBtn = document.getElementById("hamburgerBtn")
  const mobileNav = document.getElementById("mobileNav")

  hamburgerBtn.classList.remove("active")
  mobileNav.classList.remove("active")
  mobileMenuOpen = false

  document.body.style.overflow = ""
}

// -------------------- Active Link Underline --------------------
function highlightActiveLink() {
  const currentPage = window.location.pathname.split("/").pop()
  const allLinks = document.querySelectorAll('nav a, #mobileNav a')

  allLinks.forEach(link => {
    link.classList.remove("active")
    const linkPage = link.getAttribute("href")
    if (linkPage === currentPage || (currentPage === "" && linkPage === "index.php")) {
      link.classList.add("active")
    }
  })
}

// -------------------- Modal --------------------
function setupModalEvents() {
  const modal = document.getElementById("loginModal")
  if (!modal) return

  modal.addEventListener("click", (e) => {
    if (e.target === modal) closeLoginModal()
  })

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && modal.classList.contains("show")) closeLoginModal()
  })
}

function showLoginModal() {
  const modal = document.getElementById("loginModal")
  if (!modal) return

  modal.classList.add("show")
  modal.style.display = "flex"

  const firstInput = modal.querySelector('input[type="text"]')
  if (firstInput) setTimeout(() => firstInput.focus(), 300)

  document.body.style.overflow = "hidden"
}

function closeLoginModal() {
  const modal = document.getElementById("loginModal")
  if (!modal) return

  modal.classList.remove("show")
  setTimeout(() => modal.style.display = "none", 300)
  document.body.style.overflow = ""
}

// -------------------- Form Validation --------------------
function setupFormValidation() {
  const loginForm = document.getElementById("loginForm")
  if (!loginForm) return

  loginForm.addEventListener("submit", (e) => {
    e.preventDefault()
    submitLogin()
  })

  const inputs = loginForm.querySelectorAll("input")
  inputs.forEach((input) => {
    input.addEventListener("blur", validateField)
    input.addEventListener("input", clearFieldError)
  })
}

// -------------------- Field Validation --------------------
function validateField(e) {
  const field = e.target
  const value = field.value.trim()
  clearFieldError(e)

  if (field.type === "email" && value && !isValidEmail(value)) {
    showFieldError(field, "Please enter a valid email address")
  }

  if (field.required && !value) {
    showFieldError(field, "This field is required")
  }
}

function clearFieldError(e) {
  const field = e.target
  const errorElement = field.parentNode.querySelector(".field-error")
  if (errorElement) errorElement.remove()
  field.classList.remove("error")
}

function showFieldError(field, message) {
  clearFieldError({ target: field })
  field.classList.add("error")
  const errorElement = document.createElement("div")
  errorElement.className = "field-error"
  errorElement.textContent = message
  errorElement.style.color = "#dc3545"
  errorElement.style.fontSize = "0.875rem"
  errorElement.style.marginTop = "0.25rem"
  field.parentNode.appendChild(errorElement)
}

function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return emailRegex.test(email)
}

// -------------------- Login Submit --------------------
function submitLogin() {
  const form = document.getElementById("loginForm")
  const userTypeRadio = document.querySelector('input[name="user_type"]:checked')
  const userType = userTypeRadio ? userTypeRadio.value : "user"
  let hasErrors = false

  if (userType === "admin") {
    const usernameField = document.getElementById("modalUsernameInput")
    const passwordField = document.getElementById("modalPasswordInput")
    clearFieldError({ target: usernameField })
    clearFieldError({ target: passwordField })
    if (!usernameField.value.trim()) { showFieldError(usernameField,"Please enter your username"); hasErrors = true }
    if (!passwordField.value.trim()) { showFieldError(passwordField,"Please enter your password"); hasErrors = true }
  } else {
    const nameField = document.getElementById("modalNameInput")
    const emailField = document.getElementById("modalEmailInput")
    clearFieldError({ target: nameField })
    clearFieldError({ target: emailField })
    if (!nameField.value.trim()) { showFieldError(nameField,"Please enter your full name"); hasErrors = true }
    if (!emailField.value.trim()) { showFieldError(emailField,"Please enter your email"); hasErrors = true }
    else if (!isValidEmail(emailField.value.trim())) { showFieldError(emailField,"Please enter a valid email"); hasErrors = true }
  }

  if (!hasErrors) {
    const submitBtn = form.querySelector(".submit-btn")
    submitBtn.textContent = "Accessing..."
    submitBtn.disabled = true
    form.submit()
  }
}

// -------------------- User/Admin Field Toggle --------------------
function toggleLoginFields() {
  const userRadio = document.querySelector('input[name="user_type"][value="user"]')
  const adminRadio = document.querySelector('input[name="user_type"][value="admin"]')
  const userFields = document.getElementById("userFields")
  const adminFields = document.getElementById("adminFields")

  if (adminRadio.checked) {
    userFields.style.display = "none"
    adminFields.style.display = "block"

    document.getElementById("modalNameInput").value = ""
    document.getElementById("modalNameInput").removeAttribute("required")
    document.getElementById("modalEmailInput").value = ""
    document.getElementById("modalEmailInput").removeAttribute("required")
    document.getElementById("modalUsernameInput").setAttribute("required","required")
    document.getElementById("modalPasswordInput").setAttribute("required","required")
  } else {
    userFields.style.display = "block"
    adminFields.style.display = "none"

    document.getElementById("modalUsernameInput").value = ""
    document.getElementById("modalUsernameInput").removeAttribute("required")
    document.getElementById("modalPasswordInput").value = ""
    document.getElementById("modalPasswordInput").removeAttribute("required")
    document.getElementById("modalNameInput").setAttribute("required","required")
    document.getElementById("modalEmailInput").setAttribute("required","required")
  }
}

// -------------------- Quick Exit --------------------
function quickExit() {
  // Clear any stored data
  if (typeof(Storage) !== "undefined") {
    localStorage.clear()
    sessionStorage.clear()
  }
  
  // Clear browser history and redirect
  window.location.replace("https://www.google.com")
}

// -------------------- Service Card Interactions --------------------
document.addEventListener('DOMContentLoaded', function() {
  const serviceCards = document.querySelectorAll('.service-card')
  
  serviceCards.forEach(card => {
    // Add keyboard navigation
    card.setAttribute('tabindex', '0')
    
    card.addEventListener('keydown', function(e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault()
        card.click()
      }
    })
    
    // Add focus/blur events for better accessibility
    card.addEventListener('focus', function() {
      this.style.outline = '3px solid #667eea'
      this.style.outlineOffset = '2px'
    })
    
    card.addEventListener('blur', function() {
      this.style.outline = 'none'
    })
  })
  
  // Admin dashboard cards
  const dashboardCards = document.querySelectorAll('.dashboard-card')
  
  dashboardCards.forEach(card => {
    card.setAttribute('tabindex', '0')
    
    card.addEventListener('keydown', function(e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault()
        card.click()
      }
    })
  })
})
