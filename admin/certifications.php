<?php
require_once '../config/db.php';
require_once 'auth.php';

requireLogin();

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM certifications WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    header('Location: certifications.php?deleted=1');
    exit();
}

// Handle add
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_cert'])) {
    $name = trim($_POST['name'] ?? '');
    $provider = trim($_POST['provider'] ?? '');
    $year = (int)($_POST['year'] ?? date('Y'));
    $certificate_url = trim($_POST['certificate_url'] ?? '');
    $imageName = '';

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../assets/images/certifications/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileInfo = pathinfo($_FILES['image']['name']);
            $extension = strtolower($fileInfo['extension']);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (in_array($extension, $allowedExtensions)) {
                if ($_FILES['image']['size'] <= 3000000) { // 3MB limit
                    $imageName = uniqid('cert_') . '.' . $extension;
                    $uploadPath = $uploadDir . $imageName;
                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                        $error = 'Failed to upload image. Check directory permissions.';
                        $imageName = '';
                    }
                } else {
                    $error = 'Image size must be less than 3MB.';
                }
            } else {
                $error = 'Invalid image format. Only JPG, PNG, GIF, and WebP are allowed.';
            }
        } else {
            $error = 'Failed to upload image. Error code: ' . $_FILES['image']['error'];
        }
    }

    if (empty($error)) {
        $stmt = $pdo->prepare("INSERT INTO certifications (name, provider, year, certificate_url, image) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $provider, $year, $certificate_url, $imageName])) {
            $success = 'Certification added successfully!';
        }
    }
}

// Fetch all certifications
$certs = $pdo->query("SELECT * FROM certifications ORDER BY year DESC")->fetchAll();

include 'header.php';
?>

<div class="content-area">
    <h1 style="margin-bottom: var(--spacing-lg);">Manage Certifications</h1>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">Certification deleted successfully!</div>
    <?php endif; ?>
    
    <!-- Add Certification Form -->
    <div class="card" style="margin-bottom: var(--spacing-xl);">
        <h2 style="margin-bottom: var(--spacing-md);">Add New Certification</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="grid grid-2" style="gap: var(--spacing-md);">
                <div class="form-group">
                    <label for="name" class="form-label">Certification Name *</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           placeholder="e.g., Full Stack Web Development" required>
                </div>
                
                <div class="form-group">
                    <label for="provider" class="form-label">Provider *</label>
                    <input type="text" id="provider" name="provider" class="form-control" 
                           placeholder="e.g., Coursera, Udemy" required>
                </div>
            </div>
            
            <div class="grid grid-2" style="gap: var(--spacing-md);">
                <div class="form-group">
                    <label for="year" class="form-label">Year *</label>
                    <input type="number" id="year" name="year" class="form-control" 
                           min="2000" max="2100" value="<?php echo date('Y'); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="certificate_url" class="form-label">Certificate URL (optional)</label>
                    <input type="url" id="certificate_url" name="certificate_url" class="form-control" 
                           placeholder="https://...">
                </div>
            </div>
            
            <div class="form-group">
                <label for="image" class="form-label">Certificate Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <small style="color: var(--text-light); display: block; margin-top: 0.5rem;">
                    Recommended: 600x400px, Max size: 3MB
                </small>
            </div>
            
            <button type="submit" name="add_cert" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Certification
            </button>
        </form>
    </div>
    
    <!-- Certifications List -->
    <div class="card">
        <h2 style="margin-bottom: var(--spacing-md);">All Certifications</h2>
        <?php if (count($certs) > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Certification Name</th>
                        <th>Provider</th>
                        <th>Year</th>
                        <th>Certificate Link</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($certs as $cert): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cert['name']); ?></td>
                            <td><?php echo htmlspecialchars($cert['provider']); ?></td>
                            <td><?php echo htmlspecialchars($cert['year']); ?></td>
                            <td>
                                <?php if (!empty($cert['certificate_url'])): ?>
                                    <a href="<?php echo htmlspecialchars($cert['certificate_url']); ?>" target="_blank">View</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($cert['image'])): ?>
                                    <img src="../assets/images/certifications/<?php echo htmlspecialchars($cert['image']); ?>" alt="Certificate Image" style="max-width: 80px; max-height: 60px; border-radius: 6px;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?action=edit&id=<?php echo $cert['id']; ?>" style="color: var(--primary-color); margin-right: var(--spacing-sm);" title="Edit certification">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="?action=delete&id=<?php echo $cert['id']; ?>" style="color: #ef4444;" onclick="return confirm('Delete this certification?');" title="Delete certification">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; color: var(--text-secondary);">No certifications added yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
