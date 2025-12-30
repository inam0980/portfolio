<?php
require_once '../config/db.php';
require_once 'auth.php';

requireLogin();

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Get image name before deleting
    $stmt = $pdo->prepare("SELECT image FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();
    
    if ($project) {
        // Delete image file if it exists and is not default
        if ($project['image'] !== 'default-project.jpg') {
            $imagePath = '../assets/images/projects/' . $project['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        // Delete from database
        $deleteStmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        $deleteStmt->execute([$id]);
        
        header('Location: projects.php?deleted=1');
        exit();
    }
}

// Fetch all projects
$stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
$projects = $stmt->fetchAll();

include 'header.php';
?>

<div class="content-area">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
        <h1>Manage Projects</h1>
        <a href="add-project.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Project
        </a>
    </div>
    
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">Project deleted successfully!</div>
    <?php endif; ?>
    
    <div class="card">
        <?php if (count($projects) > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Tech Stack</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td>
                                <img src="../assets/images/projects/<?php echo htmlspecialchars($project['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($project['title']); ?>"
                                     style="width: 80px; height: 50px; object-fit: cover; border-radius: var(--radius-sm);"
                                     onerror="this.src='https://via.placeholder.com/80x50/667eea/ffffff?text=No+Image'">
                            </td>
                            <td><strong><?php echo htmlspecialchars($project['title']); ?></strong></td>
                            <td><?php echo htmlspecialchars(substr($project['tech_stack'], 0, 40)); ?>...</td>
                            <td>
                                <?php if ($project['is_recent']): ?>
                                    <span class="badge badge-success">Recent</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($project['created_at'])); ?></td>
                            <td>
                                <a href="edit-project.php?id=<?php echo $project['id']; ?>" 
                                   style="color: var(--primary-color); margin-right: var(--spacing-sm);"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="?action=delete&id=<?php echo $project['id']; ?>" 
                                   style="color: #ef4444;"
                                   title="Delete"
                                   onclick="return confirm('Are you sure you want to delete this project?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="text-align: center; padding: var(--spacing-2xl);">
                <i class="fas fa-folder-open" style="font-size: 3rem; color: var(--text-light);"></i>
                <p style="margin-top: var(--spacing-md); color: var(--text-secondary);">No projects yet. Add your first project!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
