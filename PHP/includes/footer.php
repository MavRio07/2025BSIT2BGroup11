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
                    <button class="close-btn" onclick="closeLoginModal()">&times;</button>
                 </div>
                
                <div class="modal-body">
                    <p class="login-message">To access our support resources, please provide your information. This helps us keep our services secure and confidential.</p>
                    <p class="login-message">Please provide your information to access our confidential support resources.</p>
                    
                    <form id="loginForm" method="POST" action="login.php">
                        <div class="form-group">
                            <label for="modalNameInput">Full Name</label>
                            <input type="text" name="name" id="modalNameInput" placeholder="Enter your full name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="modalEmailInput">Email Address</label>
                            <input type="email" name="email" id="modalEmailInput" placeholder="Enter your email address" required>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="submit-btn">Access Resources</button>
                            </form>
                    
                    <div class="modal-footer-message">
                        <p><small>Your information is kept confidential and is only used to provide you with appropriate support resources.</small></p>
                        <p><small>All information is kept confidential and secure.</small></p>
                    </div>
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
