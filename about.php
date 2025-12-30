<?php
require_once 'config/db.php';
$pageTitle = "About Me - Portfolio";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn more about my background, experience, and career objectives">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- AOS Animation Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    
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
                <h1 class="hero-title" style="font-size: clamp(2.5rem, 5vw, 3.5rem);">About Me</h1>
                <p class="hero-description">Get to know more about my journey and aspirations</p>
            </div>
        </div>
    </section>

    <!-- About Content -->
    <section class="section">
        <div class="container">
            <div style="max-width: 1000px; margin: 0 auto;">
                <!-- Profile Image -->
                <div style="text-align: center; margin-bottom: var(--spacing-2xl);">
                    <img src="assets/images/profile.jpg" alt="Inam Khan" style="width: 300px; height: 300px; border-radius: 50%; object-fit: cover; border: 5px solid var(--primary-color); box-shadow: 0 0 40px rgba(255, 102, 0, 0.4);">
                    <h2 style="margin-top: var(--spacing-lg); font-size: 2.5rem;">Hello! I'm <span style="color: var(--primary-color);">Inam Khan</span></h2>
                    <h3 style="color: var(--text-secondary); font-weight: 500; margin-top: var(--spacing-sm); font-size: 1.5rem;">
                        Aspiring Data Analyst
                    </h3>
                </div>
                
                <!-- Bio Content Cards -->
                <div style="display: grid; gap: var(--spacing-lg);">
                    <!-- Card 1 -->
                    <div class="card" style="position: relative; overflow: hidden;">
                        <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: var(--primary-color); opacity: 0.08; border-radius: 50%; filter: blur(40px);"></div>
                        <div style="position: relative; z-index: 1; display: flex; gap: var(--spacing-lg); align-items: start;">
                            <div style="flex-shrink: 0;">
                                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(255, 102, 0, 0.3);">
                                    <i class="fas fa-chart-line" style="font-size: 2rem; color: #fff;"></i>
                                </div>
                            </div>
                            <div style="flex: 1;">
                                <h4 style="color: var(--primary-color); margin-bottom: var(--spacing-sm); font-size: 1.3rem;">Data Enthusiast</h4>
                                <p style="font-size: 1.05rem; line-height: 1.8; color: var(--text-light);">
                                    A passionate data enthusiast with a keen eye for transforming complex datasets into meaningful insights that drive business decisions.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card 2 -->
                    <div class="card" style="position: relative; overflow: hidden;">
                        <div style="position: absolute; bottom: -30px; left: -30px; width: 120px; height: 120px; background: var(--secondary-color); opacity: 0.08; border-radius: 50%; filter: blur(40px);"></div>
                        <div style="position: relative; z-index: 1; display: flex; gap: var(--spacing-lg); align-items: start;">
                            <div style="flex-shrink: 0;">
                                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--secondary-color), var(--primary-color)); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(255, 102, 0, 0.3);">
                                    <i class="fas fa-graduation-cap" style="font-size: 2rem; color: #fff;"></i>
                                </div>
                            </div>
                            <div style="flex: 1;">
                                <h4 style="color: var(--primary-color); margin-bottom: var(--spacing-sm); font-size: 1.3rem;">Educational Background</h4>
                                <p style="font-size: 1.05rem; line-height: 1.8; color: var(--text-light);">
                                    I'm a motivated and detail-oriented aspiring Data Analyst with a foundational education in Computer Science and Data Science from Lovely Professional University, Punjab. My expertise lies in leveraging analytical tools and programming to drive data-driven decision-making and deliver impactful projects.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card 3 -->
                    <div class="card" style="position: relative; overflow: hidden;">
                        <div style="position: absolute; top: -30px; left: -30px; width: 120px; height: 120px; background: var(--primary-color); opacity: 0.08; border-radius: 50%; filter: blur(40px);"></div>
                        <div style="position: relative; z-index: 1; display: flex; gap: var(--spacing-lg); align-items: start;">
                            <div style="flex-shrink: 0;">
                                <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(255, 102, 0, 0.3);">
                                    <i class="fas fa-code" style="font-size: 2rem; color: #fff;"></i>
                                </div>
                            </div>
                            <div style="flex: 1;">
                                <h4 style="color: var(--primary-color); margin-bottom: var(--spacing-sm); font-size: 1.3rem;">Beyond Work</h4>
                                <p style="font-size: 1.05rem; line-height: 1.8; color: var(--text-light);">
                                    When I'm not crunching numbers or building data models, I enjoy exploring new technologies, contributing to open-source projects, and expanding my knowledge in the ever-evolving field of data science.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: var(--spacing-2xl); text-align: center; display: flex; gap: var(--spacing-sm); justify-content: center; flex-wrap: wrap;">
                    <a href="contact.php" class="btn btn-primary" style="padding: 1rem 2.5rem; font-size: 1.1rem;">
                        <i class="fas fa-envelope" style="margin-right: 0.5rem;"></i> Get In Touch
                    </a>
                    <?php
                    // Find resume file dynamically
                    $resumeFiles = glob('assets/resume.*');
                    if (!empty($resumeFiles)):
                        $resumeFile = basename($resumeFiles[0]);
                    ?>
                        <a href="assets/<?php echo htmlspecialchars($resumeFile); ?>" class="btn btn-secondary" style="padding: 1rem 2.5rem; font-size: 1.1rem;" download>
                            <i class="fas fa-download"></i> Download Resume
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Career Objective -->
    <section class="section" style="background: var(--bg-secondary);">
        <div class="container">
            <h2 class="section-title">Career Objective</h2>
            
            <div style="max-width: 800px; margin: 0 auto; text-align: center;">
                <div class="card" style="background: white;">
                    <i class="fas fa-bullseye" style="font-size: 3rem; color: var(--primary-color); margin-bottom: var(--spacing-md);"></i>
                    <p style="font-size: 1.15rem; line-height: 1.8; color: var(--text-primary);">
                        To leverage my technical expertise in data analysis and programming skills in a challenging role as a 
                        <strong>Data Analyst</strong>, where I can transform complex datasets into meaningful insights that drive 
                        business decisions, collaborate with talented teams, and continue growing professionally while delivering 
                        exceptional value through data-driven solutions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Education Timeline -->
    <section class="section" style="background: var(--bg-secondary);">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Education</h2>
            <div style="max-width: 900px; margin: 0 auto;">
                <div class="timeline">
                    <div class="timeline-item" data-aos="fade-up" data-aos-delay="0">
                        <div class="timeline-date">Aug 2023 - Present</div>
                        <h3 class="timeline-title">B.Tech in Computer Science and Engineering (Data Science)</h3>
                        <div class="timeline-company">Lovely Professional University, Jalandhar, Punjab</div>
                        <p>
                            Currently pursuing Bachelor of Technology with specialization in Data Science. Focused on data analysis, 
                            machine learning, statistical modeling, and data-driven decision making. Actively working on practical 
                            projects involving Python, SQL, and data visualization.
                        </p>
                        <p style="margin-top: var(--spacing-sm);">
                            <strong>Relevant Coursework:</strong> Data Structures & Algorithms, Database Management Systems, 
                            Machine Learning, Statistical Analysis, Python Programming, Data Visualization
                        </p>
                    </div>
                    <div class="timeline-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="timeline-date">Jun 2021 - Mar 2023</div>
                        <h3 class="timeline-title">Senior Secondary Examination (Class 12th)</h3>
                        <div class="timeline-company">U.S.S. College, Jalalpur, Siwan</div>
                        <p>
                            Completed senior secondary education with focus on Science and Mathematics. Developed strong analytical 
                            and problem-solving skills that laid the foundation for pursuing Computer Science and Data Science.
                        </p>
                    </div>
                    <div class="timeline-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="timeline-date">Apr 2020 - Mar 2021</div>
                        <h3 class="timeline-title">Secondary School Examination (Class 10th)</h3>
                        <div class="timeline-company">Emmanuel Mission High School, Siwan, Bihar</div>
                        <p>
                            Completed secondary education with distinction. Developed early interest in mathematics and logical 
                            reasoning which sparked passion for technology and data analysis.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interests & Hobbies -->
    <section class="section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Interests & Hobbies</h2>
            <div class="grid grid-4">
                <div class="card text-center" data-aos="zoom-in" data-aos-delay="0">
                    <i class="fas fa-code" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-sm);"></i>
                    <h3 style="font-size: 1.25rem;">Coding</h3>
                    <p>Building side projects and contributing to open-source</p>
                </div>
                <div class="card text-center" data-aos="zoom-in" data-aos-delay="100">
                    <i class="fas fa-book-reader" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-sm);"></i>
                    <h3 style="font-size: 1.25rem;">Learning</h3>
                    <p>Constantly exploring new technologies and frameworks</p>
                </div>
                <div class="card text-center" data-aos="zoom-in" data-aos-delay="200">
                    <i class="fas fa-users" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-sm);"></i>
                    <h3 style="font-size: 1.25rem;">Community</h3>
                    <p>Attending tech meetups and sharing knowledge</p>
                </div>
                <div class="card text-center" data-aos="zoom-in" data-aos-delay="300">
                    <i class="fas fa-gamepad" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: var(--spacing-sm);"></i>
                    <h3 style="font-size: 1.25rem;">Gaming</h3>
                    <p>Enjoying strategy games and problem-solving challenges</p>
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
        <a href="about.php" class="active">
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
        <!-- AOS Animation Library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
        <script>
            AOS.init({
                duration: 800,
                once: true
            });
        </script>
</body>
</html>
