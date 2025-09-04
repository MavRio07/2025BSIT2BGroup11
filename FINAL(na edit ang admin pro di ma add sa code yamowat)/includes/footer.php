</main>
    
    <footer class="main-footer">
        <div class="footer-content">
            <div class="emergency-info">
                <h3>Emergency Contacts</h3>
                <p><strong>National Domestic Violence Hotline:</strong> 1-800-799-7233</p>
                <p><strong>Crisis Text Line:</strong> Text HOME to 741741</p>
                <p><strong>Emergency Services:</strong> 911</p>
            </div>
            
            <div class="footer-links">
                <ul>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                    <li><a href="terms.php">Terms of Service</a></li>
                </ul>
            </div>
            
            <div class="footer-message">
                <p><strong>Remember: You are not alone.</strong></p>
                <p>Help is available 24/7. Your safety matters.</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 You Are Not Alone. All rights reserved.</p>
        </div>
    </footer>
    
    <?php if (!isLoggedIn() || isset($_SESSION['show_login_modal'])): ?>
        <div id="loginModal" class="modal <?php echo (isset($_SESSION['show_login_modal']) && $_SESSION['show_login_modal']) ? 'show' : ''; ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Please Log In</h2>
                    <button class="close-btn" onclick="closeLoginModal()" aria-label="Close login modal">&times;</button>
                 </div>
                 
                <div class="modal-body">
                    <?php if (isset($_SESSION['login_error'])): ?>
                        <div class="error-message">
                            <?php echo htmlspecialchars($_SESSION['login_error']); ?>
                        </div>
                        <?php unset($_SESSION['login_error']); ?>
                    <?php endif; ?>
                    
                    <p class="login-message">To access our support resources, please provide your information. This helps us keep our services secure and confidential.</p>
                    
                    <form id="loginForm" method="POST" action="login.php">
                        <div class="form-group">
                            <label for="userType">Login As</label>
                            <label class="radio-option">
                                <input type="radio" name="user_type" value="user" checked onchange="toggleLoginFields()">
                                User
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="user_type" value="admin" onchange="toggleLoginFields()">
                                Admin
                            </label>
                        </div>
                        
                        <div id="userFields">
                            <div class="form-group">
                                <label for="modalNameInput">Full Name</label>
                                <input type="text" name="name" id="modalNameInput" placeholder="Enter your full name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="modalEmailInput">Email Address</label>
                                <input type="email" name="email" id="modalEmailInput" placeholder="Enter your email address" required>
                            </div>
                        </div>
                        
                        <div id="adminFields" style="display: none;">
                            <div class="form-group">
                                <label for="modalUsernameInput">Username</label>
                                <input type="text" name="username" id="modalUsernameInput" placeholder="Enter admin username">
                            </div>
                            
                            <div class="form-group">
                                <label for="modalPasswordInput">Password</label>
                                <input type="password" name="password" id="modalPasswordInput" placeholder="Enter admin password">
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="submit-btn">Access Resources</button>
                        </div>
                    </form>
                    
                    <div class="modal-footer-message">
                        <p><small>Your information is kept confidential and is only used to provide you with appropriate support resources.</small></p>
                    </div>
                </div>
            </div>
        </div>
        <?php 
        if (isset($_SESSION['show_login_modal'])) {
            unset($_SESSION['show_login_modal']);
        }
        ?>
    <?php endif; ?>
    
    <script src="assets/script.js"></script>
</body>
</html>
