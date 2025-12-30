<?php
require_once '../config/db.php';
require_once 'auth.php';

requireLogin();

$success = '';
$error = '';

// Check if tables exist
try {
    $pdo->query("SELECT 1 FROM project_categories LIMIT 1");
    $pdo->query("SELECT 1 FROM skill_categories LIMIT 1");
    $tablesExist = true;
} catch (PDOException $e) {
    $tablesExist = false;
}

if (!$tablesExist) {
    include 'header.php';
    ?>
    <div class="content-area">
        <h1 style="margin-bottom: var(--spacing-lg);">Manage Categories</h1>
        
        <div class="card" style="background: linear-gradient(135deg, rgba(255, 102, 0, 0.1), rgba(255, 69, 0, 0.05)); border: 2px solid var(--primary-color);">
            <div style="text-align: center; padding: var(--spacing-xl);">
                <i class="fas fa-database" style="font-size: 4rem; color: var(--primary-color); margin-bottom: var(--spacing-lg);"></i>
                <h2 style="color: var(--primary-color); margin-bottom: var(--spacing-md);">Database Setup Required</h2>
                <p style="color: var(--text-light); font-size: 1.1rem; line-height: 1.8; margin-bottom: var(--spacing-xl);">
                    The category management feature requires additional database tables. Please run the SQL migration to set up the required tables.
                </p>
                
                <div style="background: white; padding: var(--spacing-lg); border-radius: var(--radius-lg); text-align: left; margin-bottom: var(--spacing-xl);">
                    <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-md);">
                        <i class="fas fa-tasks"></i> Setup Instructions:
                    </h3>
                    <ol style="color: var(--text-secondary); line-height: 2; font-size: 1.05rem;">
                        <li>Open <strong>phpMyAdmin</strong> (http://localhost/phpmyadmin)</li>
                        <li>Select your database: <strong>portfolio_db</strong></li>
                        <li>Click on the <strong>SQL</strong> tab</li>
                        <li>Copy and paste the SQL from <code>database_categories_migration.sql</code></li>
                        <li>Click <strong>Go</strong> to execute</li>
                        <li>Refresh this page</li>
                    </ol>
                </div>
                
                <a href="https://localhost/phpmyadmin" target="_blank" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;">
                    <i class="fas fa-external-link-alt"></i> Open phpMyAdmin
                </a>
            </div>
        </div>
    </div>
    <?php
    include 'footer.php';
    exit;
}

// Handle Add Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_project_category') {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        if (!empty($name)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO project_categories (name, description) VALUES (?, ?)");
                if ($stmt->execute([$name, $description])) {
                    $success = 'Project category added successfully!';
                }
            } catch (PDOException $e) {
                $error = 'Error: ' . $e->getMessage();
            }
        } else {
            $error = 'Category name is required.';
        }
    }
    
    if ($_POST['action'] === 'add_skill_category') {
        $name = trim($_POST['name'] ?? '');
        $icon = trim($_POST['icon'] ?? 'fa-star');
        
        if (!empty($name)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO skill_categories (name, icon) VALUES (?, ?)");
                if ($stmt->execute([$name, $icon])) {
                    $success = 'Skill category added successfully!';
                }
            } catch (PDOException $e) {
                $error = 'Error: ' . $e->getMessage();
            }
        } else {
            $error = 'Category name is required.';
        }
    }
}

// Handle Delete
if (isset($_GET['delete_project_cat'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM project_categories WHERE id = ?");
        $stmt->execute([$_GET['delete_project_cat']]);
        $success = 'Project category deleted successfully!';
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}

if (isset($_GET['delete_skill_cat'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM skill_categories WHERE id = ?");
        $stmt->execute([$_GET['delete_skill_cat']]);
        $success = 'Skill category deleted successfully!';
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}

// Fetch categories
$projectCategories = $pdo->query("SELECT * FROM project_categories ORDER BY name")->fetchAll();
$skillCategories = $pdo->query("SELECT * FROM skill_categories ORDER BY name")->fetchAll();

include 'header.php';
?>

<div class="content-area">
    <h1 style="margin-bottom: var(--spacing-lg);">Manage Categories</h1>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <div class="grid grid-2" style="gap: var(--spacing-xl); margin-bottom: var(--spacing-xl);">
        <!-- Project Categories -->
        <div class="card">
            <h2 style="color: var(--primary-color); margin-bottom: var(--spacing-lg);">
                <i class="fas fa-folder"></i> Project Categories
            </h2>
            
            <form method="POST" style="margin-bottom: var(--spacing-xl);">
                <input type="hidden" name="action" value="add_project_category">
                
                <div class="form-group">
                    <label class="form-label">Category Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g., Web Apps, API Projects" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <input type="text" name="description" class="form-control" placeholder="Optional description">
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </form>
            
            <h3 style="margin-bottom: var(--spacing-md);">Existing Categories</h3>
            <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                <?php foreach ($projectCategories as $cat): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--spacing-sm); background: rgba(255, 102, 0, 0.05); border-radius: var(--radius-md); border-left: 3px solid var(--primary-color);">
                        <div>
                            <strong style="color: var(--primary-color);"><?php echo htmlspecialchars($cat['name']); ?></strong>
                            <?php if ($cat['description']): ?>
                                <br><small style="color: var(--text-secondary);"><?php echo htmlspecialchars($cat['description']); ?></small>
                            <?php endif; ?>
                        </div>
                        <a href="?delete_project_cat=<?php echo $cat['id']; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this category? Projects will not be deleted.')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($projectCategories)): ?>
                    <p style="color: var(--text-secondary); text-align: center; padding: var(--spacing-lg);">No categories yet</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Skill Categories -->
        <div class="card">
            <h2 style="color: var(--primary-color); margin-bottom: var(--spacing-lg);">
                <i class="fas fa-code"></i> Skill Categories
            </h2>
            
            <form method="POST" style="margin-bottom: var(--spacing-xl);">
                <input type="hidden" name="action" value="add_skill_category">
                
                <div class="form-group">
                    <label class="form-label">Category Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g., Backend Framework, Data Science" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Icon (Font Awesome class)</label>
                    <input type="text" name="icon" class="form-control" placeholder="e.g., fa-server, fa-database" value="fa-star">
                    <small style="color: var(--text-secondary);">Find icons at <a href="https://fontawesome.com/icons" target="_blank">fontawesome.com</a></small>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </form>
            
            <h3 style="margin-bottom: var(--spacing-md);">Existing Categories</h3>
            <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                <?php foreach ($skillCategories as $cat): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: var(--spacing-sm); background: rgba(255, 102, 0, 0.05); border-radius: var(--radius-md); border-left: 3px solid var(--primary-color);">
                        <div>
                            <i class="fas <?php echo htmlspecialchars($cat['icon']); ?>" style="color: var(--primary-color); margin-right: var(--spacing-xs);"></i>
                            <strong style="color: var(--primary-color);"><?php echo htmlspecialchars($cat['name']); ?></strong>
                        </div>
                        <a href="?delete_skill_cat=<?php echo $cat['id']; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this category? Skills will not be deleted.')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($skillCategories)): ?>
                    <p style="color: var(--text-secondary); text-align: center; padding: var(--spacing-lg);">No categories yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="card" style="background: linear-gradient(135deg, rgba(255, 102, 0, 0.1), rgba(255, 69, 0, 0.05)); border: 2px dashed var(--border-color);">
        <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-md);">
            <i class="fas fa-info-circle"></i> How to Use Categories
        </h3>
        <ul style="color: var(--text-light); line-height: 1.8;">
            <li><strong>Project Categories:</strong> When adding/editing projects, you can assign them to categories like "Web Apps", "API Projects", etc.</li>
            <li><strong>Skill Categories:</strong> When adding/editing skills, you can group them under categories like "Backend Framework", "Data Science", etc.</li>
            <li><strong>Display:</strong> Categories will be shown as filters on the Projects page and as section headings on the Skills page.</li>
            <li><strong>Icons:</strong> Use Font Awesome icon classes (e.g., fa-server, fa-database, fa-react) for skill categories.</li>
        </ul>
    </div>
</div>

<?php include 'footer.php'; ?>
