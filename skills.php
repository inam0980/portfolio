<?php
require_once 'config/db.php';
$pageTitle = "Skills - Portfolio";

// Fetch skills with category information
$stmt = $pdo->query("
    SELECT s.*, sc.name as category_name, sc.icon as category_icon
    FROM skills s
    LEFT JOIN skill_categories sc ON s.category_id = sc.id
    ORDER BY sc.name, s.display_order, s.skill_name
");
$allSkills = $stmt->fetchAll();

// Group skills by category
$skillsByCategory = [];
foreach ($allSkills as $skill) {
    $categoryName = $skill['category_name'] ?: 'Uncategorized';
    $skillsByCategory[$categoryName][] = $skill;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My technical skills and expertise in programming, data, and tools">
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
                <h1 class="hero-title" style="font-size: clamp(2.5rem, 5vw, 3.5rem);">My Skills</h1>
                <p class="hero-description">Technical expertise and proficiency across various technologies</p>
            </div>
        </div>
    </section>

    <!-- Skills Content -->
    <section class="section">
        <div class="container">
            <?php if (count($skillsByCategory) > 0): ?>
                <?php foreach ($skillsByCategory as $category => $skills): ?>
                    <div style="margin-bottom: var(--spacing-2xl);">
                        <h2 style="margin-bottom: var(--spacing-xl); display: flex; align-items: center; gap: var(--spacing-sm);">
                            <?php
                            // Get icon from first skill in category or use default
                            $categoryIcon = $skills[0]['category_icon'] ?? 'fa-star';
                            ?>
                            <i class="fas <?php echo $categoryIcon; ?>" style="color: var(--primary-color);"></i>
                            <?php echo htmlspecialchars($category); ?> Skills
                        </h2>
                        
                        <div class="grid grid-2">
                            <?php foreach ($skills as $skill): ?>
                                <div class="card" style="position: relative; overflow: hidden;">
                                    <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: var(--primary-color); opacity: 0.08; border-radius: 50%; filter: blur(25px);"></div>
                                    <div style="position: relative; z-index: 1;">
                                        <div class="skill-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md);">
                                            <span class="skill-name" style="font-size: 1.1rem; font-weight: 600; color: var(--text-light);"><?php echo htmlspecialchars($skill['skill_name']); ?></span>
                                            <span class="skill-level" style="font-size: 1.3rem; font-weight: 700; color: var(--primary-color); background: rgba(255, 102, 0, 0.1); padding: 0.25rem 0.75rem; border-radius: 20px;"><?php echo htmlspecialchars($skill['level']); ?>%</span>
                                        </div>
                                        <div class="progress-bar" style="height: 12px; background: rgba(255, 102, 0, 0.15); border-radius: 10px; overflow: hidden; box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);">
                                            <div class="progress-fill" 
                                                 data-width="<?php echo htmlspecialchars($skill['level']); ?>" 
                                                 style="width: 0%; height: 100%; background: linear-gradient(90deg, var(--primary-color), var(--secondary-color)); border-radius: 10px; transition: width 1.5s ease-out; box-shadow: 0 0 10px rgba(255, 102, 0, 0.5);">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center">
                    <p class="text-secondary">No skills data available yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Additional Skills Section -->
    <section class="section" style="background: var(--bg-secondary);">
        <div class="container">
            <h2 class="section-title">Additional Expertise</h2>
            
            <div class="grid grid-3">
                <div class="card text-center">
                    <i class="fas fa-mobile-alt" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-md);"></i>
                    <h3>Responsive Design</h3>
                    <p>Creating mobile-first, responsive websites that work seamlessly across all devices and screen sizes.</p>
                </div>
                
                <div class="card text-center">
                    <i class="fas fa-search" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-md);"></i>
                    <h3>SEO Optimization</h3>
                    <p>Implementing SEO best practices to improve visibility and ranking in search engine results.</p>
                </div>
                
                <div class="card text-center">
                    <i class="fas fa-rocket" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-md);"></i>
                    <h3>Performance</h3>
                    <p>Optimizing website performance for fast loading times and smooth user experiences.</p>
                </div>
                
                <div class="card text-center">
                    <i class="fas fa-shield-alt" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-md);"></i>
                    <h3>Security</h3>
                    <p>Implementing security best practices to protect applications from vulnerabilities and threats.</p>
                </div>
                
                <div class="card text-center">
                    <i class="fas fa-git-alt" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-md);"></i>
                    <h3>Version Control</h3>
                    <p>Proficient with Git and GitHub for version control and collaborative development workflows.</p>
                </div>
                
                <div class="card text-center">
                    <i class="fas fa-puzzle-piece" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-md);"></i>
                    <h3>Problem Solving</h3>
                    <p>Strong analytical and debugging skills to identify and resolve complex technical challenges.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Technologies & Frameworks -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Technologies & Frameworks</h2>
            
            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: var(--spacing-md); max-width: 1000px; margin: 0 auto;">
                <?php
                $technologies = [
                    'HTML5', 'CSS3', 'JavaScript', 'PHP', 'Python', 'MySQL', 'PostgreSQL', 
                    'MongoDB', 'React', 'Vue.js', 'Node.js', 'Express', 'Laravel', 'Bootstrap', 
                    'Tailwind CSS', 'jQuery', 'AJAX', 'REST API', 'Git', 'GitHub', 'Docker', 
                    'Linux', 'VS Code', 'Figma', 'Adobe XD', 'Photoshop'
                ];
                
                foreach ($technologies as $tech): ?>
                    <div style="padding: 0.75rem 1.5rem; background: white; border: 2px solid var(--border-color); border-radius: var(--radius-md); font-weight: 600; transition: all var(--transition-base); cursor: default;"
                         onmouseover="this.style.borderColor='var(--primary-color)'; this.style.transform='translateY(-3px)'; this.style.boxShadow='var(--shadow-md)';"
                         onmouseout="this.style.borderColor='var(--border-color)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <?php echo htmlspecialchars($tech); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; text-align: center;">
        <div class="container">
            <h2 style="color: white;">Interested in Working Together?</h2>
            <p style="color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto var(--spacing-lg);">
                Let's discuss how my skills can help bring your project to life.
            </p>
            <a href="contact.php" class="btn btn-outline">Get In Touch</a>
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
        <a href="skills.php" class="active">
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
