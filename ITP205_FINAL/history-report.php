<?php
require_once 'includes/config.php';
require_once 'includes/data_functions.php';
require_once 'includes/csrf.php';

if (!isLoggedIn()) {
    $_SESSION['show_login_modal'] = true;
    header("Location: index.php");
    exit();
}

// use logged in user id
$current_user_id = $_SESSION['user_id'] ?? null;

if (!$current_user_id) {
    $_SESSION['login_error'] = "User session not found. Please log in again.";
    header("Location: index.php");
    exit();
}

// fetch alerts of user
$stmt = $conn->prepare("
    SELECT * FROM emergencies
    WHERE user_id = ?
    ORDER BY time DESC
");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$reports_data = [];
while ($row = $result->fetch_assoc()) {
    $reports_data[] = [
        'id' => $row['id'],
        'user_name' => $row['user_name'] ?? 'Anonymous',
        'user_email' => $row['user_email'] ?? '',
        'urgency' => $row['help_level'],
        'status' => $row['status'],
        'location' => $row['location'],
        'message' => $row['description'],
        'timestamp' => $row['time']
    ];
}

include 'includes/header.php';
?>

<div class="section" style="margin: 2rem auto; max-width: 900px; font-family: Arial, sans-serif; text-align: center;">

    <h1 class="page-title">Your Report History</h1>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="success-message" style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem;">
            <?php echo htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?>
        </div>
    <?php endif; ?>

    <div class="alerts-container" style="display: flex; flex-direction: column; gap: 1.5rem; align-items: center; width: 100%;">
        <?php if (empty($reports_data)): ?>
            <div class="no-alerts" style="text-align: center; padding: 3rem; background: white; border-radius: 10px; color: #666; width: 100%;">
                You have not submitted any alerts yet.
            </div>
        <?php else: ?>
            <?php foreach ($reports_data as $alert): 
                $urgency_color = strtolower($alert['urgency'] ?? 'low') == 'critical' ? '#dc3545' :
                                 (strtolower($alert['urgency'] ?? 'low') == 'high' ? '#ff6b6b' :
                                 (strtolower($alert['urgency'] ?? 'low') == 'medium' ? '#ffc107' : '#28a745'));
            ?>
                <form action="update-report.php" method="POST" style="width: 100%; max-width: 800px; background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 1.5rem; border-left: 5px solid <?php echo $urgency_color; ?>; margin-bottom: 1rem;" class="alert-card">
                    <?php echo getCSRFTokenField(); ?>
                    <input type="hidden" name="report_id" value="<?php echo htmlspecialchars($alert['id']); ?>">

                    <div class="alert-header" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 1rem;">
                        <div class="alert-urgency" style="display: flex; gap: 0.5rem; flex-wrap: wrap; justify-content: center;">
                            <select name="urgency" class="urgency-select" style="padding: 0.35rem 0.75rem; border-radius: 12px; font-weight: bold; font-size: 0.75rem;">
                                <option value="critical" <?php if (($alert['urgency'] ?? '') === 'critical') echo 'selected'; ?>>Critical</option>
                                <option value="high" <?php if (($alert['urgency'] ?? '') === 'high') echo 'selected'; ?>>High</option>
                                <option value="medium" <?php if (($alert['urgency'] ?? '') === 'medium') echo 'selected'; ?>>Medium</option>
                                <option value="low" <?php if (($alert['urgency'] ?? '') === 'low') echo 'selected'; ?>>Low</option>
                            </select>
                        </div>

                        <div class="alert-time" style="color: #666; font-size: 0.9rem; margin-top: 0.5rem;">
                            <?php echo htmlspecialchars($alert['timestamp'] ?? 'N/A'); ?>
                        </div>
                    </div>

                    <div class="alert-body" style="margin-bottom: 1rem; text-align: left;">
                        <div class="alert-info" style="margin-bottom: 0.75rem; color: #333;">
                            <strong>Message:</strong>
                            <textarea name="message" style="width: 100%; min-height: 80px; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;"><?php echo htmlspecialchars($alert['message']); ?></textarea>
                        </div>
                    </div>

                    <div class="alert-actions" style="display: flex; flex-wrap: wrap; gap: 0.75rem; padding-top: 1rem; border-top: 1px solid #eee; justify-content: center;">
                        <button type="submit" style="background: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer; padding: 0.5rem;">Update</button>
                    </div>
                </form>

                <form action="delete-report.php" method="POST" style="width: 100%; max-width: 800px; text-align: center; margin-bottom: 1rem;" onsubmit="return confirm('Are you sure you want to delete this alert?');">
                    <?php echo getCSRFTokenField(); ?>
                    <input type="hidden" name="alert_id" value="<?php echo htmlspecialchars($alert['id']); ?>">
                    <button type="submit" style="background: #dc3545; color: white; border: none; border-radius: 6px; cursor: pointer; padding: 0.5rem;">Delete</button>
                </form>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <a href="help.php" style="display: inline-block; margin-top: 2rem; padding: 0.75rem 1.5rem; background: #6c757d; color: white; border-radius: 6px; text-decoration: none;">Submit New Alert</a>
</div>

<script>
    document.querySelectorAll('.alert-card').forEach(card => {
        const select = card.querySelector('.urgency-select');
        select.addEventListener('change', function() {
            let color;
            switch(this.value) {
                case 'critical': color = '#dc3545'; break;
                case 'high': color = '#ff6b6b'; break;
                case 'medium': color = '#ffc107'; break;
                default: color = '#28a745';
            }
            card.style.borderLeftColor = color;
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
