<?php
require_once '../config/db.php';
require_once 'auth.php';

requireLogin();

$success = '';
$error = '';
$project = null;

// Fetch project categories for dropdown
$categoriesStmt = $pdo->query("SELECT * FROM project_categories ORDER BY name");
$categories = $categoriesStmt->fetchAll();

// Get project ID
if (!isset($_GET['id'])) {
    header('Location: projects.php');
    exit();
}

$id = (int)$_GET['id'];

// Fetch project details
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    header('Location: projects.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $tech_stack = trim($_POST['tech_stack'] ?? '');
    $github_link = trim($_POST['github_link'] ?? '');
    $live_link = trim($_POST['live_link'] ?? '');
    $category_id = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $is_recent = isset($_POST['is_recent']) ? 1 : 0;
    
    if (empty($title) || empty($description) || empty($tech_stack)) {
        $error = 'Title, description, and tech stack are required fields.';
    } elseif (!empty($github_link) && !filter_var($github_link, FILTER_VALIDATE_URL)) {
        $error = 'Invalid GitHub link format. Please enter a valid URL.';
    } elseif (!empty($live_link) && !filter_var($live_link, FILTER_VALIDATE_URL)) {
        $error = 'Invalid Live Demo link format. Please enter a valid URL.';
    } else {
        $imageName = $project['image'];
        
        // Handle new image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../assets/images/projects/';
                
                if (!is_dir($uploadDir)) {
                    if (!mkdir($uploadDir, 0777, true)) {
                        $error = 'Failed to create upload directory.';
                    }
                }
                
                if (empty($error)) {
                    $fileInfo = pathinfo($_FILES['image']['name']);
                    $extension = strtolower($fileInfo['extension']);
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    
                    if (in_array($extension, $allowedExtensions)) {
                        if ($_FILES['image']['size'] <= 5000000) {
                            // Delete old image
                            if (!empty($project['image'])) {
                                $oldImagePath = $uploadDir . $project['image'];
                                if (file_exists($oldImagePath)) {
                                    unlink($oldImagePath);
                                }
                            }
                            
                            $imageName = uniqid('project_') . '.' . $extension;
                            $uploadPath = $uploadDir . $imageName;
                            
                            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                                $error = 'Failed to upload image. Check directory permissions.';
                            }
                        } else {
                            $error = 'Image size must be less than 5MB.';
                        }
                    } else {
                        $error = 'Invalid image format. Only JPG, PNG, GIF, and WebP are allowed.';
                    }
                }
            } else {
                // Provide specific error messages
                switch ($_FILES['image']['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $error = 'Image file is too large.';
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $error = 'Image was only partially uploaded.';
                        break;
                    default:
                        $error = 'Failed to upload image. Error code: ' . $_FILES['image']['error'];
                }
            }
        }
        
        if (empty($error)) {
            try {
                $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, tech_stack = ?, github_link = ?, live_link = ?, image = ?, category_id = ?, is_recent = ? WHERE id = ?");
                $result = $stmt->execute([$title, $description, $tech_stack, $github_link, $live_link, $imageName, $category_id, $is_recent, $id]);
                
                if ($result) {
                    $success = 'Project updated successfully!';
                    // Refresh project data
                    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
                    $stmt->execute([$id]);
                    $project = $stmt->fetch();
                } else {
                    $error = 'Failed to update project.';
                }
            } catch (PDOException $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
}

include 'header.php';
?>

<div class="content-area">
    <h1 style="margin-bottom: var(--spacing-lg);">Edit Project</h1>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <div class="card">
        <form method="POST" enctype="multipart/form-data">
            <div class="grid grid-3" style="gap: var(--spacing-lg);">
                <div class="form-group">
                    <label for="title" class="form-label">Project Title *</label>
                    <input type="text" id="title" name="title" class="form-control" 
                           value="<?php echo htmlspecialchars($project['title']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="tech_stack" class="form-label">Tech Stack (comma-separated) *</label>
                    <input type="text" id="tech_stack" name="tech_stack" class="form-control" 
                           value="<?php echo htmlspecialchars($project['tech_stack']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" class="form-control">
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" 
                                <?php echo ($project['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="description" class="form-label">Description *</label>
                <textarea id="description" name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($project['description']); ?></textarea>
            </div>
            
            <div class="grid grid-2" style="gap: var(--spacing-lg);">
                <div class="form-group">
                    <label for="github_link" class="form-label">GitHub Link</label>
                    <input type="url" id="github_link" name="github_link" class="form-control" 
                           value="<?php echo htmlspecialchars($project['github_link']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="live_link" class="form-label">Live Demo Link</label>
                    <input type="url" id="live_link" name="live_link" class="form-control" 
                           value="<?php echo htmlspecialchars($project['live_link']); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Current Image</label>
                <div style="margin-bottom: var(--spacing-sm);">
                    <img src="../assets/images/projects/<?php echo htmlspecialchars($project['image']); ?>" 
                         alt="Current project image"
                         style="max-width: 300px; border-radius: var(--radius-md);"
                         onerror="this.src='https://via.placeholder.com/300x150/667eea/ffffff?text=No+Image'">
                </div>
                <label for="image" class="form-label">Upload New Image (optional)</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <small style="color: var(--text-light); display: block; margin-top: 0.5rem;">
                    Recommended: 800x400px, Max size: 5MB
                </small>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: var(--spacing-sm); cursor: pointer;">
                    <input type="checkbox" name="is_recent" value="1" 
                           <?php echo $project['is_recent'] ? 'checked' : ''; ?>>
                    <span>Mark as Recent Project (will appear in featured section)</span>
                </label>
            </div>
            
            <div style="display: flex; gap: var(--spacing-sm); margin-top: var(--spacing-lg);">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Project
                </button>
                <a href="projects.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
