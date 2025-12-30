<?php
require_once '../config/db.php';
require_once 'auth.php';

requireLogin();

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM skills WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    header('Location: skills.php?deleted=1');
    exit();
}

// Handle add
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_skill'])) {
    $category = $_POST['category'] ?? '';
    $skill_name = trim($_POST['skill_name'] ?? '');
    $level = (int)($_POST['level'] ?? 0);
    
    if (empty($skill_name) || $level < 0 || $level > 100) {
        $error = 'Please fill all fields correctly.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO skills (category, skill_name, level) VALUES (?, ?, ?)");
        if ($stmt->execute([$category, $skill_name, $level])) {
            $success = 'Skill added successfully!';
        }
    }
}

// Fetch all skills
$skills = $pdo->query("SELECT * FROM skills ORDER BY category, skill_name")->fetchAll();

include 'header.php';
?>

<div class="content-area">
    <h1 style="margin-bottom: var(--spacing-lg);">Manage Skills</h1>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">Skill deleted successfully!</div>
    <?php endif; ?>
    
    <!-- Add Skill Form -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <h2 style="margin-bottom: var(--spacing-md);">Add New Skill</h2>
        <form method="POST">
            <div class="grid grid-3" style="gap: var(--spacing-md);">
                <div class="form-group">
                    <label for="category" class="form-label">Category *</label>
                    <select id="category" name="category" class="form-control" required>
                        <option value="Programming">Programming</option>
                        <option value="Data">Data</option>
                        <option value="Tools">Tools</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="skill_name" class="form-label">Skill Name *</label>
                    <input type="text" id="skill_name" name="skill_name" class="form-control" 
                           placeholder="e.g., JavaScript" required>
                </div>
                
                <div class="form-group">
                    <label for="level" class="form-label">Proficiency Level (0-100) *</label>
                    <input type="number" id="level" name="level" class="form-control" 
                           min="0" max="100" value="50" required>
                </div>
            </div>
            
            <button type="submit" name="add_skill" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Skill
            </button>
        </form>
    </div>
    
    <!-- Skills List -->
    <div class="card">
        <h2 style="margin-bottom: var(--spacing-md);">All Skills</h2>
        <?php if (count($skills) > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Skill Name</th>
                        <th>Category</th>
                        <th>Level</th>
                        <th>Progress</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($skills as $skill): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($skill['skill_name']); ?></strong></td>
                            <td><span class="badge badge-success"><?php echo htmlspecialchars($skill['category']); ?></span></td>
                            <td><?php echo $skill['level']; ?>%</td>
                            <td>
                                <div style="background: var(--bg-secondary); height: 8px; border-radius: 10px; overflow: hidden; width: 200px;">
                                    <div style="background: var(--primary-color); height: 100%; width: <?php echo $skill['level']; ?>%;"></div>
                                </div>
                            </td>
                            <td>
                                <a href="?action=delete&id=<?php echo $skill['id']; ?>" 
                                   style="color: #ef4444;"
                                   onclick="return confirm('Delete this skill?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; color: var(--text-secondary);">No skills added yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
