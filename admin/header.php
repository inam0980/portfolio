<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Portfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --sidebar-width: 260px;
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
            padding: var(--spacing-lg);
        }
        
        .card {
            background: white;
            padding: var(--spacing-lg);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
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
        
        .data-table {
            width: 100%;
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
        }
        
        .data-table tr:hover {
            background: var(--bg-secondary);
        }
    </style>
</head>
<body>
    <div class="admin-layout">
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
                <a href="dashboard.php" class="menu-item">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="projects.php" class="menu-item">
                    <i class="fas fa-folder"></i> Manage Projects
                </a>
                <a href="skills.php" class="menu-item">
                    <i class="fas fa-code"></i> Manage Skills
                </a>
                <a href="categories.php" class="menu-item">
                    <i class="fas fa-tags"></i> Manage Categories
                </a>
                <a href="certifications.php" class="menu-item">
                    <i class="fas fa-certificate"></i> Manage Certifications
                </a>
                <a href="cv-management.php" class="menu-item">
                    <i class="fas fa-file-pdf"></i> Manage CV
                </a>
                <a href="messages.php" class="menu-item">
                    <i class="fas fa-envelope"></i> Messages
                </a>
                <hr style="border-color: rgba(255,255,255,0.1); margin: var(--spacing-md) 0;">
                <a href="../index.php" class="menu-item" target="_blank">
                    <i class="fas fa-external-link-alt"></i> View Site
                </a>
                <a href="?action=logout" class="menu-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </aside>
        
        <main class="main-content">
