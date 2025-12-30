<?php
require_once 'config/db.php';

// Get project ID from URL
$projectId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($projectId === 0) {
    header('Location: projects.php');
    exit;
}

// Fetch project details
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$projectId]);
$project = $stmt->fetch();

if (!$project) {
    header('Location: projects.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($project['title']); ?> - Inam Khan</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">Inam Khan</a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="skills.php">Skills</a></li>
                <li><a href="projects.php" class="active">Projects</a></li>
                <li><a href="certifications.php">Certifications</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <button class="menu-toggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <!-- Project Detail Section -->
    <section class="section" style="padding-top: calc(70px + var(--spacing-xl)); padding-bottom: calc(var(--spacing-2xl) + 80px);">
        <div class="container">
            <div style="max-width: 1000px; margin: 0 auto;">
                <!-- Back Button -->
                <a href="projects.php" class="btn btn-secondary" style="margin-bottom: var(--spacing-lg); display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-arrow-left"></i> Back to Projects
                </a>
                
                <!-- Project Card -->
                <div class="card" style="position: relative; overflow: hidden; margin-bottom: var(--spacing-xl);">
                    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: var(--primary-color); opacity: 0.08; border-radius: 50%; filter: blur(60px);"></div>
                    <div style="position: relative; z-index: 1;">
                        <?php if ($project['image']): ?>
                            <img src="assets/images/projects/<?php echo htmlspecialchars($project['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($project['title']); ?>" 
                                 style="width: 100%; height: 400px; object-fit: cover; border-radius: var(--radius-md); margin-bottom: var(--spacing-xl); box-shadow: 0 10px 30px rgba(255, 102, 0, 0.2);">
                        <?php endif; ?>
                        
                        <h1 style="color: var(--primary-color); margin-bottom: var(--spacing-lg); font-size: clamp(1.8rem, 4vw, 2.5rem); font-weight: 700;">
                            <?php echo htmlspecialchars($project['title']); ?>
                        </h1>
                        
                        <!-- Tech Stack Tags -->
                        <div class="card-tags" style="margin-bottom: var(--spacing-xl);">
                            <?php 
                            $techStack = explode(',', $project['tech_stack']);
                            foreach ($techStack as $tech): ?>
                                <span class="tag"><?php echo htmlspecialchars(trim($tech)); ?></span>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Project Links -->
                        <div style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap; margin-bottom: var(--spacing-2xl); padding-bottom: var(--spacing-xl); border-bottom: 2px solid var(--border-color);">
                            <?php if ($project['github_link']): ?>
                                <a href="<?php echo htmlspecialchars($project['github_link']); ?>" 
                                   class="btn btn-secondary" target="_blank" rel="noopener" style="flex: 1; min-width: 150px; justify-content: center;">
                                    <i class="fab fa-github" style="margin-right: 0.5rem;"></i> View Code
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($project['live_link']): ?>
                                <a href="<?php echo htmlspecialchars($project['live_link']); ?>" 
                                   class="btn btn-primary" target="_blank" rel="noopener" style="flex: 1; min-width: 150px; justify-content: center;">
                                    <i class="fas fa-external-link-alt" style="margin-right: 0.5rem;"></i> Live Demo
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Description -->
                        <div>
                            <div style="display: flex; align-items: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-lg);">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 5px 15px rgba(255, 102, 0, 0.3);">
                                    <i class="fas fa-info-circle" style="font-size: 1.5rem; color: #fff;"></i>
                                </div>
                                <h3 style="color: var(--primary-color); margin: 0; font-size: 1.8rem;">
                                    Project Description
                                </h3>
                            </div>
                            <p style="font-size: 1.1rem; line-height: 1.9; color: var(--text-light); padding: var(--spacing-md); background: rgba(255, 102, 0, 0.05); border-left: 4px solid var(--primary-color); border-radius: var(--radius-md);">
                                <?php echo nl2br(htmlspecialchars($project['description'])); ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- More Projects -->
                <div class="card text-center" style="background: linear-gradient(135deg, rgba(255, 102, 0, 0.1), rgba(255, 69, 0, 0.05)); border: 2px dashed var(--border-color);">
                    <i class="fas fa-folder-open" style="font-size: 3rem; color: var(--primary-color); margin-bottom: var(--spacing-md);"></i>
                    <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-md);">Explore More Projects</h3>
                    <p style="color: var(--text-light); margin-bottom: var(--spacing-lg);">Check out my other projects and see what I've been working on</p>
                    <a href="projects.php" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;">
                        <i class="fas fa-arrow-right" style="margin-right: 0.5rem;"></i> View All Projects
                    </a>
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
        <a href="projects.php" class="active">
            <i class="fas fa-folder"></i>
            <span>Projects</span>
        </a>
        <a href="contact.php">
            <i class="fas fa-envelope"></i>
            <span>Contact</span>
        </a>
    </nav>

    <script src="assets/js/main.js"></script>
</body>
</html>
