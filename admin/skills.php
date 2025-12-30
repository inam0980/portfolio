<?php
require_once '../config/db.php';
require_once 'auth.php';

requireLogin();

// Fetch skill categories for dropdown
$categoriesStmt = $pdo->query("SELECT * FROM skill_categories ORDER BY name");
$skillCategories = $categoriesStmt->fetchAll();

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM skills WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    header('Location: skills.php?deleted=1');
    exit();
}

// Get skill for editing
$editSkill = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM skills WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    $editSkill = $stmt->fetch();
}

// Handle add and edit
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_skill'])) {
    $category_id = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $skill_name = trim($_POST['skill_name'] ?? '');
    $level = (int)($_POST['level'] ?? 0);
    
    if (empty($skill_name) || $level < 0 || $level > 100) {
        $error = 'Please fill all fields correctly.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO skills (category_id, skill_name, level) VALUES (?, ?, ?)");
        if ($stmt->execute([$category_id, $skill_name, $level])) {
            $success = 'Skill added successfully!';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_skill'])) {
    $id = (int)$_POST['skill_id'];
    $category_id = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $skill_name = trim($_POST['skill_name'] ?? '');
    $level = (int)($_POST['level'] ?? 0);
    
    if (empty($skill_name) || $level < 0 || $level > 100) {
        $error = 'Please fill all fields correctly.';
    } else {
        $stmt = $pdo->prepare("UPDATE skills SET category_id = ?, skill_name = ?, level = ? WHERE id = ?");
        if ($stmt->execute([$category_id, $skill_name, $level, $id])) {
            $success = 'Skill updated successfully!';
            header('Location: skills.php?updated=1');
            exit();
        }
    }
}

// Fetch all skills with category names
$skills = $pdo->query("
    SELECT s.*, sc.name as category_name, sc.icon as category_icon
    FROM skills s
    LEFT JOIN skill_categories sc ON s.category_id = sc.id
    ORDER BY sc.name, s.skill_name
")->fetchAll();

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
    
    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success">Skill updated successfully!</div>
    <?php endif; ?>
    
    <!-- Add/Edit Skill Form -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <h2 style="margin-bottom: var(--spacing-md);">
            <?php echo $editSkill ? 'Edit Skill' : 'Add New Skill'; ?>
        </h2>
        <form method="POST">
            <?php if ($editSkill): ?>
                <input type="hidden" name="skill_id" value="<?php echo $editSkill['id']; ?>">
            <?php endif; ?>
            
            <div class="grid grid-3" style="gap: var(--spacing-md);">
                <div class="form-group">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" class="form-control">
                        <option value="">-- Select Category --</option>
                        <?php foreach ($skillCategories as $category): ?>
                            <option value="<?php echo $category['id']; ?>"
                                <?php echo ($editSkill && $editSkill['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="skill_name" class="form-label">Skill Name *</label>
                    <input type="text" id="skill_name" name="skill_name" class="form-control" 
                           placeholder="e.g., JavaScript" 
                           value="<?php echo $editSkill ? htmlspecialchars($editSkill['skill_name']) : ''; ?>"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="level" class="form-label">Proficiency Level (0-100) *</label>
                    <input type="number" id="level" name="level" class="form-control" 
                           min="0" max="100" 
                           value="<?php echo $editSkill ? $editSkill['level'] : '50'; ?>"
                           required>
                </div>
            </div>
            
            <div style="display: flex; gap: var(--spacing-sm);">
                <?php if ($editSkill): ?>
                    <button type="submit" name="update_skill" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Skill
                    </button>
                    <a href="skills.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                <?php else: ?>
                    <button type="submit" name="add_skill" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Skill
                    </button>
                <?php endif; ?>
            </div>
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
                            <td>
                                <?php if ($skill['category_name']): ?>
                                    <span class="badge badge-success">
                                        <i class="fas <?php echo htmlspecialchars($skill['category_icon']); ?>"></i>
                                        <?php echo htmlspecialchars($skill['category_name']); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge" style="background: #999;">Uncategorized</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $skill['level']; ?>%</td>
                            <td>
                                <div style="background: var(--bg-secondary); height: 8px; border-radius: 10px; overflow: hidden; width: 200px;">
                                    <div style="background: var(--primary-color); height: 100%; width: <?php echo $skill['level']; ?>%;"></div>
                                </div>
                            </td>
                            <td>
                                <a href="?action=edit&id=<?php echo $skill['id']; ?>" 
                                   style="color: var(--primary-color); margin-right: var(--spacing-sm);"
                                   title="Edit skill">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="?action=delete&id=<?php echo $skill['id']; ?>" 
                                   style="color: #ef4444;"
                                   onclick="return confirm('Delete this skill?');"
                                   title="Delete skill">
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
