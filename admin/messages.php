<?php
require_once '../config/db.php';
require_once 'auth.php';

requireLogin();

// Handle mark as read
if (isset($_GET['action']) && $_GET['action'] === 'read' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("UPDATE contacts SET is_read = 1 WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    header('Location: messages.php');
    exit();
}

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    header('Location: messages.php?deleted=1');
    exit();
}

// Fetch all messages
$messages = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC")->fetchAll();

include 'header.php';
?>

<div class="content-area">
    <h1 style="margin-bottom: var(--spacing-lg);">Contact Messages</h1>
    
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">Message deleted successfully!</div>
    <?php endif; ?>
    
    <div class="card">
        <?php if (count($messages) > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                        <tr style="<?php echo $msg['is_read'] ? '' : 'background: #fef3c7;'; ?>">
                            <td>
                                <?php if ($msg['is_read']): ?>
                                    <span class="badge badge-success">Read</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Unread</span>
                                <?php endif; ?>
                            </td>
                            <td><strong><?php echo htmlspecialchars($msg['name']); ?></strong></td>
                            <td>
                                <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>" 
                                   style="color: var(--primary-color);">
                                    <?php echo htmlspecialchars($msg['email']); ?>
                                </a>
                            </td>
                            <td>
                                <details>
                                    <summary style="cursor: pointer; color: var(--primary-color);">
                                        <?php echo htmlspecialchars(substr($msg['message'], 0, 50)) . '...'; ?>
                                    </summary>
                                    <p style="margin-top: var(--spacing-sm); padding: var(--spacing-sm); background: var(--bg-secondary); border-radius: var(--radius-sm);">
                                        <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                                    </p>
                                </details>
                            </td>
                            <td><?php echo date('M j, Y g:i A', strtotime($msg['created_at'])); ?></td>
                            <td>
                                <?php if (!$msg['is_read']): ?>
                                    <a href="?action=read&id=<?php echo $msg['id']; ?>" 
                                       style="color: var(--primary-color); margin-right: var(--spacing-sm);"
                                       title="Mark as read">
                                        <i class="fas fa-check"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="?action=delete&id=<?php echo $msg['id']; ?>" 
                                   style="color: #ef4444;"
                                   title="Delete"
                                   onclick="return confirm('Delete this message?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="text-align: center; padding: var(--spacing-2xl);">
                <i class="fas fa-inbox" style="font-size: 3rem; color: var(--text-light);"></i>
                <p style="margin-top: var(--spacing-md); color: var(--text-secondary);">No messages yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
