<?php
require_once '../config/db.php';
require_once 'auth.php';

requireLogin();

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}

// Get statistics
$totalProjects = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$recentProjects = $pdo->query("SELECT COUNT(*) FROM projects WHERE is_recent = 1")->fetchColumn();
$totalSkills = $pdo->query("SELECT COUNT(*) FROM skills")->fetchColumn();
$totalCertifications = $pdo->query("SELECT COUNT(*) FROM certifications")->fetchColumn();
$unreadMessages = $pdo->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0")->fetchColumn();
$totalMessages = $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();

// Get latest messages
$latestMessages = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5")->fetchAll();

// Get latest projects
$latestProjects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --header-height: 70px;
        }
        
        .admin-layout {
            display: flex;
            min-height: 100vh;
            background: var(--bg-secondary);
        }
        
        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-dark);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: var(--spacing-lg);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-menu {
            padding: var(--spacing-md);
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            padding: var(--spacing-sm) var(--spacing-md);
            color: rgba(255,255,255,0.8);
            border-radius: var(--radius-md);
            margin-bottom: var(--spacing-xs);
            transition: all var(--transition-base);
        }
        
        .menu-item:hover,
        .menu-item.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
        }
        
        .top-header {
            height: var(--header-height);
            background: white;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 var(--spacing-lg);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .content-area {
            padding: var(--spacing-lg);
        }
        
        .stat-card {
            background: white;
            padding: var(--spacing-lg);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border-left: 4px solid var(--primary-color);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: var(--spacing-xs);
        }
        
        .data-table {
            width: 100%;
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        .data-table th,
        .data-table td {
            padding: var(--spacing-md);
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        .data-table th {
            background: var(--bg-secondary);
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .data-table tr:hover {
            background: var(--bg-secondary);
        }
        
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }
        
        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2 style="margin: 0; color: white;">
                    <i class="fas fa-crown"></i> Admin Panel
                </h2>
                <p style="font-size: 0.875rem; color: rgba(255,255,255,0.6); margin-top: 0.25rem;">
                    Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
                </p>
            </div>
            
            <nav class="sidebar-menu">
                <a href="dashboard.php" class="menu-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
                <a href="projects.php" class="menu-item">
                    <i class="fas fa-folder"></i>
                    Manage Projects
                </a>
                <a href="skills.php" class="menu-item">
                    <i class="fas fa-code"></i>
                    Manage Skills
                </a>
                <a href="certifications.php" class="menu-item">
                    <i class="fas fa-certificate"></i>
                    Manage Certifications
                </a>
                <a href="messages.php" class="menu-item">
                    <i class="fas fa-envelope"></i>
                    Messages
                    <?php if ($unreadMessages > 0): ?>
                        <span class="badge badge-warning"><?php echo $unreadMessages; ?></span>
                    <?php endif; ?>
                </a>
                <hr style="border-color: rgba(255,255,255,0.1); margin: var(--spacing-md) 0;">
                <a href="../index.php" class="menu-item" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    View Site
                </a>
                <a href="?action=logout" class="menu-item">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <h1 style="margin: 0; font-size: 1.5rem;">Dashboard</h1>
                <div style="display: flex; gap: var(--spacing-md); align-items: center;">
                    <a href="../index.php" class="btn btn-secondary" target="_blank">
                        <i class="fas fa-eye"></i> Preview Site
                    </a>
                </div>
            </header>
            
            <div class="content-area">
                <!-- Statistics Cards -->
                <div class="grid grid-4" style="margin-bottom: var(--spacing-xl);">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $totalProjects; ?></div>
                        <div style="color: var(--text-secondary);">
                            <i class="fas fa-folder"></i> Total Projects
                        </div>
                        <div style="margin-top: var(--spacing-xs); font-size: 0.875rem; color: var(--text-light);">
                            <?php echo $recentProjects; ?> marked as recent
                        </div>
                    </div>
                    
                    <div class="stat-card" style="border-left-color: var(--secondary-color);">
                        <div class="stat-number"><?php echo $totalSkills; ?></div>
                        <div style="color: var(--text-secondary);">
                            <i class="fas fa-code"></i> Total Skills
                        </div>
                        <div style="margin-top: var(--spacing-xs); font-size: 0.875rem; color: var(--text-light);">
                            Across all categories
                        </div>
                    </div>
                    
                    <div class="stat-card" style="border-left-color: var(--accent-color);">
                        <div class="stat-number"><?php echo $totalCertifications; ?></div>
                        <div style="color: var(--text-secondary);">
                            <i class="fas fa-certificate"></i> Certifications
                        </div>
                        <div style="margin-top: var(--spacing-xs); font-size: 0.875rem; color: var(--text-light);">
                            Professional courses
                        </div>
                    </div>
                    
                    <div class="stat-card" style="border-left-color: #10b981;">
                        <div class="stat-number"><?php echo $totalMessages; ?></div>
                        <div style="color: var(--text-secondary);">
                            <i class="fas fa-envelope"></i> Messages
                        </div>
                        <div style="margin-top: var(--spacing-xs); font-size: 0.875rem; color: var(--text-light);">
                            <?php echo $unreadMessages; ?> unread
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div style="background: white; padding: var(--spacing-lg); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); margin-bottom: var(--spacing-xl);">
                    <h2 style="margin-bottom: var(--spacing-md);">Quick Actions</h2>
                    <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap;">
                        <a href="add-project.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Project
                        </a>
                        <a href="add-skill.php" class="btn btn-secondary">
                            <i class="fas fa-plus"></i> Add New Skill
                        </a>
                        <a href="add-certification.php" class="btn btn-secondary">
                            <i class="fas fa-plus"></i> Add Certification
                        </a>
                        <a href="messages.php" class="btn btn-secondary">
                            <i class="fas fa-envelope"></i> View Messages
                        </a>
                    </div>
                </div>
                
                <!-- Latest Projects -->
                <div style="background: white; padding: var(--spacing-lg); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); margin-bottom: var(--spacing-xl);">
                    <h2 style="margin-bottom: var(--spacing-md);">Latest Projects</h2>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Tech Stack</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestProjects as $project): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($project['title']); ?></strong></td>
                                    <td><?php echo htmlspecialchars(substr($project['tech_stack'], 0, 30)) . '...'; ?></td>
                                    <td>
                                        <?php if ($project['is_recent']): ?>
                                            <span class="badge badge-success">Recent</span>
                                        <?php else: ?>
                                            <span class="badge badge-info">Active</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($project['created_at'])); ?></td>
                                    <td>
                                        <a href="edit-project.php?id=<?php echo $project['id']; ?>" style="color: var(--primary-color);">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div style="margin-top: var(--spacing-md); text-align: center;">
                        <a href="projects.php" class="btn btn-secondary">View All Projects</a>
                    </div>
                </div>
                
                <!-- Latest Messages -->
                <div style="background: white; padding: var(--spacing-lg); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
                    <h2 style="margin-bottom: var(--spacing-md);">Recent Messages</h2>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestMessages as $message): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($message['name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($message['email']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($message['message'], 0, 50)) . '...'; ?></td>
                                    <td><?php echo date('M j, Y', strtotime($message['created_at'])); ?></td>
                                    <td>
                                        <?php if ($message['is_read']): ?>
                                            <span class="badge badge-info">Read</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">Unread</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div style="margin-top: var(--spacing-md); text-align: center;">
                        <a href="messages.php" class="btn btn-secondary">View All Messages</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
