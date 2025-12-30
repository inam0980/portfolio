<?php
require_once 'config/db.php';
$pageTitle = "Certifications - Portfolio";

// Fetch certifications from database
$stmt = $pdo->query("SELECT * FROM certifications ORDER BY year DESC, display_order ASC");
$certifications = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My professional certifications and completed courses">
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
                <h1 class="hero-title" style="font-size: clamp(2.5rem, 5vw, 3.5rem);">Certifications</h1>
                <p class="hero-description">Professional courses and certifications I've completed</p>
            </div>
        </div>
    </section>

    <!-- Certifications Section -->
    <section class="section">
        <div class="container">
            <?php if (count($certifications) > 0): ?>
                <div class="grid grid-3">
                    <?php foreach ($certifications as $cert): ?>
                        <div class="card" style="text-align: center;">
                            <i class="fas fa-certificate" style="font-size: 3rem; color: var(--primary-color); margin-bottom: var(--spacing-md);"></i>
                            
                            <h3 class="card-title" style="font-size: 1.25rem;"><?php echo htmlspecialchars($cert['name']); ?></h3>
                            
                            <p style="color: var(--primary-color); font-weight: 600; margin-bottom: var(--spacing-xs);">
                                <?php echo htmlspecialchars($cert['provider']); ?>
                            </p>
                            
                            <p style="color: var(--text-light); font-size: 0.875rem; margin-bottom: var(--spacing-md);">
                                <i class="fas fa-calendar-alt"></i> 
                                <?php echo htmlspecialchars($cert['year']); ?>
                            </p>
                            
                            <?php if (!empty($cert['certificate_url'])): ?>
                                <a href="<?php echo htmlspecialchars($cert['certificate_url']); ?>" 
                                   class="btn btn-primary" 
                                   target="_blank" 
                                   rel="noopener"
                                   style="width: 100%;">
                                    <i class="fas fa-external-link-alt"></i> View Certificate
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center">
                    <i class="fas fa-award" style="font-size: 4rem; color: var(--text-light); margin-bottom: var(--spacing-md);"></i>
                    <h3>No Certifications Yet</h3>
                    <p class="text-secondary">Certifications will appear here once they're added.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Stats Section -->
    <?php if (count($certifications) > 0): ?>
        <section class="section" style="background: var(--bg-secondary);">
            <div class="container">
                <h2 class="section-title">Certification Statistics</h2>
                
                <div class="grid grid-4">
                    <div class="card text-center">
                        <i class="fas fa-award" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-sm);"></i>
                        <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-xs);">
                            <?php echo count($certifications); ?>
                        </h3>
                        <p>Total Certifications</p>
                    </div>
                    
                    <div class="card text-center">
                        <i class="fas fa-calendar-check" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-sm);"></i>
                        <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-xs);">
                            <?php 
                            $currentYear = date('Y');
                            $thisYearCount = 0;
                            foreach ($certifications as $cert) {
                                if ($cert['year'] == $currentYear) {
                                    $thisYearCount++;
                                }
                            }
                            echo $thisYearCount;
                            ?>
                        </h3>
                        <p>This Year (<?php echo $currentYear; ?>)</p>
                    </div>
                    
                    <div class="card text-center">
                        <i class="fas fa-graduation-cap" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-sm);"></i>
                        <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-xs);">
                            <?php 
                            $providers = array_unique(array_column($certifications, 'provider'));
                            echo count($providers);
                            ?>
                        </h3>
                        <p>Learning Platforms</p>
                    </div>
                    
                    <div class="card text-center">
                        <i class="fas fa-chart-line" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-sm);"></i>
                        <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-xs);">
                            Continuous
                        </h3>
                        <p>Learning Journey</p>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Learning Platforms -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Learning Platforms I Use</h2>
            
            <div class="grid grid-4">
                <?php
                $platforms = [
                    ['name' => 'Coursera', 'icon' => 'fa-graduation-cap', 'url' => 'https://www.coursera.org'],
                    ['name' => 'Udemy', 'icon' => 'fa-book-open', 'url' => 'https://www.udemy.com'],
                    ['name' => 'freeCodeCamp', 'icon' => 'fa-code', 'url' => 'https://www.freecodecamp.org'],
                    ['name' => 'LinkedIn Learning', 'icon' => 'fa-linkedin', 'url' => 'https://www.linkedin.com/learning'],
                    ['name' => 'Pluralsight', 'icon' => 'fa-play-circle', 'url' => 'https://www.pluralsight.com'],
                    ['name' => 'edX', 'icon' => 'fa-university', 'url' => 'https://www.edx.org'],
                    ['name' => 'Codecademy', 'icon' => 'fa-laptop-code', 'url' => 'https://www.codecademy.com'],
                    ['name' => 'Udacity', 'icon' => 'fa-rocket', 'url' => 'https://www.udacity.com']
                ];
                
                foreach ($platforms as $platform): ?>
                    <div class="card text-center" style="transition: all var(--transition-base);">
                        <i class="fas <?php echo $platform['icon']; ?>" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-md);"></i>
                        <h3 style="font-size: 1.1rem;"><?php echo $platform['name']; ?></h3>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; text-align: center;">
        <div class="container">
            <h2 style="color: white;">Want to Work With a Certified Professional?</h2>
            <p style="color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto var(--spacing-lg);">
                With continuous learning and industry certifications, I bring up-to-date expertise to every project.
            </p>
            <a href="contact.php" class="btn btn-outline">Get In Touch</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="social-links">
                    <a href="https://github.com/yourusername" class="social-link" target="_blank" rel="noopener" aria-label="GitHub">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://linkedin.com/in/yourusername" class="social-link" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://twitter.com/yourusername" class="social-link" target="_blank" rel="noopener" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="mailto:your.email@example.com" class="social-link" aria-label="Email">
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
        <a href="contact.php">
            <i class="fas fa-envelope"></i>
            <span>Contact</span>
        </a>
    </nav>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
</body>
</html>
