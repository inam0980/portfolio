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
    
    if (empty($name) || empty($provider)) {
        $error = 'Name and provider are required.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO certifications (name, provider, year, certificate_url) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $provider, $year, $certificate_url])) {
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
        <form method="POST">
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($certs as $cert): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($cert['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($cert['provider']); ?></td>
                            <td><?php echo $cert['year']; ?></td>
                            <td>
                                <?php if ($cert['certificate_url']): ?>
                                    <a href="<?php echo htmlspecialchars($cert['certificate_url']); ?>" 
                                       target="_blank" style="color: var(--primary-color);">
                                        <i class="fas fa-external-link-alt"></i> View
                                    </a>
                                <?php else: ?>
                                    <span style="color: var(--text-light);">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?action=delete&id=<?php echo $cert['id']; ?>" 
                                   style="color: #ef4444;"
                                   onclick="return confirm('Delete this certification?');">
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
