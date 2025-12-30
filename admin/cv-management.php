<?php
require_once '../config/db.php';
require_once 'auth.php';

requireLogin();

$success = '';
$error = '';

// Handle CV Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['cv_file'])) {
    if ($_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileInfo = pathinfo($_FILES['cv_file']['name']);
        $extension = strtolower($fileInfo['extension']);
        $allowedExtensions = ['pdf', 'doc', 'docx'];
        
        if (in_array($extension, $allowedExtensions)) {
            if ($_FILES['cv_file']['size'] <= 10000000) { // 10MB limit
                // Delete old resume file if exists
                $oldFiles = glob($uploadDir . 'resume.*');
                foreach ($oldFiles as $oldFile) {
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                
                $newFileName = 'resume.' . $extension;
                $uploadPath = $uploadDir . $newFileName;
                
                if (move_uploaded_file($_FILES['cv_file']['tmp_name'], $uploadPath)) {
                    $success = 'CV uploaded successfully! File: ' . $newFileName;
                } else {
                    $error = 'Failed to upload CV. Check directory permissions.';
                }
            } else {
                $error = 'File size must be less than 10MB.';
            }
        } else {
            $error = 'Invalid file format. Only PDF, DOC, and DOCX are allowed.';
        }
    } else {
        switch ($_FILES['cv_file']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $error = 'File is too large.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $error = 'File was only partially uploaded.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $error = 'No file was uploaded.';
                break;
            default:
                $error = 'Failed to upload file. Error code: ' . $_FILES['cv_file']['error'];
        }
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $filePath = '../assets/resume.' . htmlspecialchars($_GET['delete']);
    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            $success = 'CV deleted successfully!';
        } else {
            $error = 'Failed to delete CV.';
        }
    }
}

// Check for existing CV files
$cvFiles = glob('../assets/resume.*');
$currentCV = !empty($cvFiles) ? basename($cvFiles[0]) : null;

include 'header.php';
?>

<div class="content-area">
    <h1 style="margin-bottom: var(--spacing-lg);">
        <i class="fas fa-file-pdf"></i> Manage CV/Resume
    </h1>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <div class="grid grid-2" style="gap: var(--spacing-xl);">
        <!-- Upload Section -->
        <div class="card">
            <h2 style="color: var(--primary-color); margin-bottom: var(--spacing-lg);">
                <i class="fas fa-upload"></i> Upload New CV
            </h2>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">Select CV File *</label>
                    <input type="file" 
                           name="cv_file" 
                           class="form-control" 
                           accept=".pdf,.doc,.docx" 
                           required>
                    <small style="color: var(--text-secondary); display: block; margin-top: var(--spacing-xs);">
                        Supported formats: PDF, DOC, DOCX (Max size: 10MB)
                    </small>
                </div>
                
                <div style="background: rgba(255, 102, 0, 0.1); padding: var(--spacing-md); border-radius: var(--radius-md); border-left: 4px solid var(--primary-color); margin-bottom: var(--spacing-lg);">
                    <strong style="color: var(--primary-color);">
                        <i class="fas fa-info-circle"></i> Important:
                    </strong>
                    <ul style="margin-top: var(--spacing-xs); color: var(--text-secondary); line-height: 1.6;">
                        <li>Uploading a new CV will replace the existing one</li>
                        <li>The file will be saved as "resume.pdf" or "resume.docx"</li>
                        <li>Download link will automatically update on the website</li>
                    </ul>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-cloud-upload-alt"></i> Upload CV
                </button>
            </form>
        </div>
        
        <!-- Current CV Section -->
        <div class="card">
            <h2 style="color: var(--primary-color); margin-bottom: var(--spacing-lg);">
                <i class="fas fa-file-alt"></i> Current CV
            </h2>
            
            <?php if ($currentCV): ?>
                <div style="background: linear-gradient(135deg, rgba(255, 102, 0, 0.1), rgba(255, 69, 0, 0.05)); padding: var(--spacing-xl); border-radius: var(--radius-lg); text-align: center; border: 2px solid var(--border-color);">
                    <i class="fas fa-file-pdf" style="font-size: 4rem; color: var(--primary-color); margin-bottom: var(--spacing-md);"></i>
                    <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-sm);">
                        <?php echo htmlspecialchars($currentCV); ?>
                    </h3>
                    <p style="color: var(--text-secondary); margin-bottom: var(--spacing-lg);">
                        <i class="fas fa-calendar-alt"></i> 
                        Last modified: <?php echo date('F j, Y g:i A', filemtime($cvFiles[0])); ?>
                    </p>
                    <p style="color: var(--text-secondary); margin-bottom: var(--spacing-xl);">
                        <i class="fas fa-hdd"></i> 
                        Size: <?php echo round(filesize($cvFiles[0]) / 1024, 2); ?> KB
                    </p>
                    
                    <div style="display: flex; gap: var(--spacing-sm); justify-content: center; flex-wrap: wrap;">
                        <a href="../assets/<?php echo htmlspecialchars($currentCV); ?>" 
                           class="btn btn-primary" 
                           target="_blank">
                            <i class="fas fa-eye"></i> Preview CV
                        </a>
                        <a href="../assets/<?php echo htmlspecialchars($currentCV); ?>" 
                           class="btn btn-secondary" 
                           download>
                            <i class="fas fa-download"></i> Download
                        </a>
                        <a href="?delete=<?php echo pathinfo($currentCV, PATHINFO_EXTENSION); ?>" 
                           class="btn btn-danger"
                           onclick="return confirm('Are you sure you want to delete the current CV?')">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: var(--spacing-2xl); color: var(--text-secondary);">
                    <i class="fas fa-file-upload" style="font-size: 4rem; opacity: 0.3; margin-bottom: var(--spacing-md);"></i>
                    <p style="font-size: 1.1rem;">No CV uploaded yet</p>
                    <p style="margin-top: var(--spacing-sm);">Upload your CV using the form on the left</p>
                </div>
            <?php endif; ?>
            
            <div style="margin-top: var(--spacing-xl); padding: var(--spacing-md); background: rgba(255, 102, 0, 0.05); border-radius: var(--radius-md);">
                <h4 style="color: var(--primary-color); margin-bottom: var(--spacing-sm);">
                    <i class="fas fa-link"></i> Download Links on Website
                </h4>
                <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6;">
                    Your CV is accessible from:
                </p>
                <ul style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6; margin-top: var(--spacing-xs);">
                    <li><strong>About Page</strong> - "Download Resume" button</li>
                    <li><strong>Contact Page</strong> - Footer section</li>
                    <li><strong>Homepage</strong> - Hero section (if available)</li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Tips Section -->
    <div class="card" style="margin-top: var(--spacing-xl); background: linear-gradient(135deg, rgba(255, 102, 0, 0.05), rgba(255, 69, 0, 0.02)); border: 2px dashed var(--border-color);">
        <h3 style="color: var(--primary-color); margin-bottom: var(--spacing-md);">
            <i class="fas fa-lightbulb"></i> CV Best Practices
        </h3>
        <div class="grid grid-2" style="gap: var(--spacing-lg);">
            <div>
                <h4 style="color: var(--primary-color); margin-bottom: var(--spacing-sm);">
                    <i class="fas fa-check-circle"></i> Do's
                </h4>
                <ul style="color: var(--text-light); line-height: 1.8;">
                    <li>Keep file size under 5MB for faster downloads</li>
                    <li>Use PDF format for best compatibility</li>
                    <li>Update regularly with new skills and projects</li>
                    <li>Use a professional, clean layout</li>
                    <li>Include contact information clearly</li>
                </ul>
            </div>
            <div>
                <h4 style="color: var(--primary-color); margin-bottom: var(--spacing-sm);">
                    <i class="fas fa-times-circle"></i> Don'ts
                </h4>
                <ul style="color: var(--text-light); line-height: 1.8;">
                    <li>Don't use images-only PDFs (not searchable)</li>
                    <li>Don't include sensitive personal data</li>
                    <li>Don't use overly complex formatting</li>
                    <li>Don't exceed 2-3 pages for entry-level</li>
                    <li>Don't forget to proofread for errors</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
