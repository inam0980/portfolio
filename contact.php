<?php
require_once 'config/db.php';

$success = false;
$error = false;
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $messageText = trim($_POST['message'] ?? '');
    
    // Validation
    if (empty($name) || empty($email) || empty($messageText)) {
        $error = true;
        $message = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $message = 'Please enter a valid email address.';
    } elseif (strlen($messageText) < 10) {
        $error = true;
        $message = 'Message must be at least 10 characters long.';
    } else {
        // Insert into database
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
            $result = $stmt->execute([$name, $email, $messageText]);
            
            if ($result) {
                $success = true;
                $message = 'Thank you for your message! I\'ll get back to you soon.';
                
                // Clear form fields on success
                $_POST = [];
            } else {
                $error = true;
                $message = 'Something went wrong. Please try again.';
            }
        } catch (PDOException $e) {
            $error = true;
            $message = 'Database error. Please try again later.';
            error_log("Contact form error: " . $e->getMessage());
        }
    }
}

$pageTitle = "Contact - Portfolio";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Get in touch for project inquiries, collaborations, or questions">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">Portfolio</a>
            
            <ul class="nav-menu">
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="about.php" class="nav-link">About</a></li>
                <li><a href="skills.php" class="nav-link">Skills</a></li>
                <li><a href="recent-projects.php" class="nav-link">Recent Projects</a></li>
                <li><a href="projects.php" class="nav-link">All Projects</a></li>
                <li><a href="certifications.php" class="nav-link">Certifications</a></li>
                <li><a href="contact.php" class="nav-link">Contact</a></li>
            </ul>
            
            <button class="menu-toggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="hero" style="min-height: 40vh; padding-top: 100px;">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title" style="font-size: clamp(2.5rem, 5vw, 3.5rem);">Get In Touch</h1>
                <p class="hero-description">Let's discuss your project or just say hello</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section">
        <div class="container">
            <div class="grid grid-2" style="gap: var(--spacing-2xl); align-items: start;">
                <!-- Contact Information -->
                <div>
                    <h2 style="margin-bottom: var(--spacing-md);">Contact Information</h2>
                    <p style="font-size: 1.1rem; line-height: 1.8; margin-bottom: var(--spacing-xl);">
                        I'm always interested in hearing about new projects and opportunities. Whether you have a question 
                        or just want to say hi, feel free to reach out!
                    </p>
                    
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                        <div class="card" style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <i class="fas fa-envelope" style="font-size: 2rem; color: var(--primary-color);"></i>
                            <div>
                                <h4 style="margin-bottom: 0.25rem;">Email</h4>
                                <a href="mailto:inampathan0000000@gmail.com" style="color: var(--primary-color);">
                                    inampathan0000000@gmail.com
                                </a>
                            </div>
                        </div>
                        
                        <div class="card" style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <i class="fas fa-phone" style="font-size: 2rem; color: var(--primary-color);"></i>
                            <div>
                                <h4 style="margin-bottom: 0.25rem;">Phone</h4>
                                <a href="tel:+918292931569" style="color: var(--primary-color);">
                                    +91 8292931569
                                </a>
                            </div>
                        </div>
                        
                        <div class="card" style="display: flex; align-items: center; gap: var(--spacing-md);">
                            <i class="fas fa-map-marker-alt" style="font-size: 2rem; color: var(--primary-color);"></i>
                            <div>
                                <h4 style="margin-bottom: 0.25rem;">Location</h4>
                                <p style="margin: 0;">India</p>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-top: var(--spacing-xl);">
                        <h3 style="margin-bottom: var(--spacing-md);">Follow Me</h3>
                        <div class="social-links" style="justify-content: flex-start;">
                            <a href="https://github.com/inam0980" class="social-link" target="_blank" rel="noopener" aria-label="GitHub">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="https://linkedin.com/in/inam-khan-757a21297" class="social-link" target="_blank" rel="noopener" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://instagram.com/inam._.pathan" class="social-link" target="_blank" rel="noopener" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="card contact-form">
                    <h2 style="margin-bottom: var(--spacing-md);">Send Me a Message</h2>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-error">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="" data-validate="true">
                        <div class="form-group">
                            <label for="name" class="form-label">Your Name *</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                class="form-control" 
                                placeholder="John Doe"
                                value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Your Email *</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-control" 
                                placeholder="john@example.com"
                                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form-label">Your Message *</label>
                            <textarea 
                                id="message" 
                                name="message" 
                                class="form-control" 
                                placeholder="Tell me about your project or inquiry..."
                                minlength="10"
                                required
                            ><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section" style="background: var(--bg-secondary);">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            
            <div style="max-width: 800px; margin: 0 auto;">
                <div class="card" style="margin-bottom: var(--spacing-md);">
                    <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-sm);">
                        <i class="fas fa-question-circle"></i> What services do you offer?
                    </h3>
                    <p>I offer full-stack web development services including custom website development, web applications, 
                    API development, database design, and UI/UX design.</p>
                </div>
                
                <div class="card" style="margin-bottom: var(--spacing-md);">
                    <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-sm);">
                        <i class="fas fa-question-circle"></i> How long does a typical project take?
                    </h3>
                    <p>Project timelines vary depending on complexity and requirements. A simple website might take 2-3 weeks, 
                    while a complex web application could take 2-3 months or more.</p>
                </div>
                
                <div class="card" style="margin-bottom: var(--spacing-md);">
                    <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-sm);">
                        <i class="fas fa-question-circle"></i> Do you work with international clients?
                    </h3>
                    <p>Yes! I work with clients from all over the world. Communication is primarily through email, video calls, 
                    and project management tools.</p>
                </div>
                
                <div class="card">
                    <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-sm);">
                        <i class="fas fa-question-circle"></i> What is your response time?
                    </h3>
                    <p>I typically respond to inquiries within 24-48 hours during business days. For urgent matters, 
                    please mention it in your message.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="social-links">
                    <a href="https://github.com/inam0980" class="social-link" target="_blank" rel="noopener" aria-label="GitHub">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://linkedin.com/in/inam-khan-757a21297" class="social-link" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="mailto:inampathan0000000@gmail.com" class="social-link" aria-label="Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
            <p class="footer-text">&copy; <?php echo date('Y'); ?> Inam Khan. All rights reserved.</p>
        </div>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottom-nav">
        <a href="index.php">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="about.php">
            <i class="fas fa-user"></i>
            <span>About</span>
        </a>
        <a href="skills.php">
            <i class="fas fa-code"></i>
            <span>Skills</span>
        </a>
        <a href="projects.php">
            <i class="fas fa-folder"></i>
            <span>Projects</span>
        </a>
        <a href="certifications.php">
            <i class="fas fa-certificate"></i>
            <span>Certifications</span>
        </a>
    </nav>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
</body>
</html>
