<?php
require_once 'config/db.php';
$pageTitle = "Recent Projects - Portfolio";

// Fetch recent projects from database
$stmt = $pdo->prepare("SELECT * FROM projects WHERE is_recent = 1 ORDER BY created_at DESC");
$stmt->execute();
$recentProjects = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My latest and most recent web development projects">
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
                <h1 class="hero-title" style="font-size: clamp(2.5rem, 5vw, 3.5rem);">Recent Projects</h1>
                <p class="hero-description">My latest work and featured projects</p>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section class="section">
        <div class="container">
            <?php if (count($recentProjects) > 0): ?>
                <div class="grid grid-3">
                    <?php foreach ($recentProjects as $project): ?>
                        <div class="card">
                            <?php if ($project['image']): ?>
                                <img src="assets/images/projects/<?php echo htmlspecialchars($project['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($project['title']); ?>" 
                                     class="card-image"
                                     onerror="this.src='https://via.placeholder.com/400x200/667eea/ffffff?text=<?php echo urlencode($project['title']); ?>'">
                            <?php endif; ?>
                            
                            <div style="position: absolute; top: var(--spacing-md); right: var(--spacing-md); background: var(--accent-color); color: white; padding: 0.25rem 0.75rem; border-radius: var(--radius-sm); font-size: 0.75rem; font-weight: 600;">
                                RECENT
                            </div>
                            
                            <h3 class="card-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                            <p class="card-description"><?php echo htmlspecialchars($project['description']); ?></p>
                            
                            <div class="card-tags">
                                <?php 
                                $techStack = explode(',', $project['tech_stack']);
                                foreach ($techStack as $tech): ?>
                                    <span class="tag"><?php echo htmlspecialchars(trim($tech)); ?></span>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="card-links">
                                <?php if ($project['github_link']): ?>
                                    <a href="<?php echo htmlspecialchars($project['github_link']); ?>" 
                                       class="btn btn-secondary" 
                                       target="_blank" 
                                       rel="noopener"
                                       style="flex: 1; text-align: center;">
                                        <i class="fab fa-github"></i> Code
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($project['live_link']): ?>
                                    <a href="<?php echo htmlspecialchars($project['live_link']); ?>" 
                                       class="btn btn-primary" 
                                       target="_blank" 
                                       rel="noopener"
                                       style="flex: 1; text-align: center;">
                                        <i class="fas fa-external-link-alt"></i> Live Demo
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                            <p style="font-size: 0.875rem; color: var(--text-light); margin-top: var(--spacing-sm);">
                                <i class="fas fa-calendar-alt"></i> 
                                <?php echo date('F j, Y', strtotime($project['created_at'])); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="text-center mt-3">
                    <a href="projects.php" class="btn btn-primary">View All Projects</a>
                </div>
            <?php else: ?>
                <div class="text-center">
                    <i class="fas fa-folder-open" style="font-size: 4rem; color: var(--text-light); margin-bottom: var(--spacing-md);"></i>
                    <h3>No Recent Projects Yet</h3>
                    <p class="text-secondary">Check back soon for my latest work!</p>
                    <a href="projects.php" class="btn btn-primary" style="margin-top: var(--spacing-md);">View All Projects</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; text-align: center;">
        <div class="container">
            <h2 style="color: white;">Have a Project in Mind?</h2>
            <p style="color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto var(--spacing-lg);">
                Let's collaborate and bring your ideas to life with clean, efficient code.
            </p>
            <a href="contact.php" class="btn btn-outline">Start a Conversation</a>
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
        <a href="projects.php" class="active">
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
