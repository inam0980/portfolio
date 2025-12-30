<?php
require_once 'config/db.php';
$pageTitle = "Home - Portfolio";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Professional portfolio website showcasing projects, skills, and experience">
    <meta name="keywords" content="portfolio, web developer, full-stack developer, projects">
    <meta name="author" content="Inam Khan">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Font Awesome for Icons -->
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <p class="hero-subtitle">Hello, I'm</p>
                <h1 class="hero-title">Inam Khan</h1>
                <p class="hero-description">
                    Data Analyst | Django Developer | Transforming Raw Data into Actionable Insights
                    <br>
                    Leveraging analytical tools and programming to drive data-driven decision-making
                </p>
                <div class="hero-cta">
                    <a href="projects.php" class="btn btn-primary">View My Work</a>
                    <a href="contact.php" class="btn btn-outline">Get In Touch</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats Section -->
    <section class="section" style="background: var(--bg-secondary);">
        <div class="container">
            <div class="grid grid-4">
                <?php
                // Get statistics from database
                $stats = [
                    ['icon' => 'fa-code', 'count' => 0, 'label' => 'Projects Completed'],
                    ['icon' => 'fa-award', 'count' => 0, 'label' => 'Certifications'],
                    ['icon' => 'fa-lightbulb', 'count' => 0, 'label' => 'Skills Mastered'],
                    ['icon' => 'fa-coffee', 'count' => '500+', 'label' => 'Cups of Coffee']
                ];
                
                // Get actual counts from database
                $projectCount = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
                $certCount = $pdo->query("SELECT COUNT(*) FROM certifications")->fetchColumn();
                $skillCount = $pdo->query("SELECT COUNT(*) FROM skills")->fetchColumn();
                
                $stats[0]['count'] = $projectCount;
                $stats[1]['count'] = $certCount;
                $stats[2]['count'] = $skillCount;
                
                foreach ($stats as $stat): ?>
                    <div class="card text-center">
                        <i class="fas <?php echo $stat['icon']; ?>" style="font-size: 3rem; color: var(--primary-color); margin-bottom: var(--spacing-sm);"></i>
                        <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-xs);"><?php echo $stat['count']; ?></h3>
                        <p><?php echo $stat['label']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Projects Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Featured Projects</h2>
            
            <div class="grid grid-3">
                <?php
                // Fetch recent projects from database
                $stmt = $pdo->prepare("SELECT * FROM projects WHERE is_recent = 1 ORDER BY created_at DESC LIMIT 3");
                $stmt->execute();
                $recentProjects = $stmt->fetchAll();
                
                if (count($recentProjects) > 0):
                    foreach ($recentProjects as $project): ?>
                        <div class="card">
                            <?php if ($project['image']): ?>
                                <img src="assets/images/projects/<?php echo htmlspecialchars($project['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($project['title']); ?>" 
                                     class="card-image">
                            <?php endif; ?>
                            
                            <h3 class="card-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                            <p class="card-description"><?php echo htmlspecialchars(substr($project['description'], 0, 120)) . '...'; ?></p>
                            
                            <div class="card-tags">
                                <?php 
                                $techStack = explode(',', $project['tech_stack']);
                                foreach (array_slice($techStack, 0, 3) as $tech): ?>
                                    <span class="tag"><?php echo htmlspecialchars(trim($tech)); ?></span>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="card-links">
                                <?php if ($project['github_link']): ?>
                                    <a href="<?php echo htmlspecialchars($project['github_link']); ?>" 
                                       class="btn btn-secondary" target="_blank" rel="noopener">
                                        <i class="fab fa-github"></i> Code
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($project['live_link']): ?>
                                    <a href="<?php echo htmlspecialchars($project['live_link']); ?>" 
                                       class="btn btn-primary" target="_blank" rel="noopener">
                                        <i class="fas fa-external-link-alt"></i> Live Demo
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach;
                else: ?>
                    <p class="text-center text-secondary">No featured projects yet. Check back soon!</p>
                <?php endif; ?>
            </div>
            
            <div class="text-center mt-3">
                <a href="projects.php" class="btn btn-primary">View All Projects</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; text-align: center;">
        <div class="container">
            <h2 style="color: white;">Let's Work Together</h2>
            <p style="color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto var(--spacing-lg);">
                Have a project in mind? Let's discuss how we can work together to bring your ideas to life.
            </p>
            <a href="contact.php" class="btn btn-outline">Contact Me</a>
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
        <a href="index.php" class="active">
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
