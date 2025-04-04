<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

// Get company ID from URL
$company_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get current page for pagination
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$items_per_page = 5;
$offset = ($page - 1) * $items_per_page;

// Initialize database connection
$db = new Database();

// Get company details
$sql = "SELECT * FROM companies WHERE company_id = ?";
$result = $db->query($sql, [$company_id]);
$company = $result[0] ?? null;

if (!$company) {
    header("Location: " . BASE_URL . "/public/?page=404");
    exit();
}

// Debug company data
echo "<pre style='display:none'>";
var_dump($company);
echo "</pre>";

// Get total number of jobs
$sql = "SELECT COUNT(*) as total FROM job_posts WHERE company_id = ? AND status = 'approved'";
$result = $db->query($sql, [$company_id]);
$total_jobs = $result[0]['total'] ?? 0;
$total_pages = ceil($total_jobs / $items_per_page);

// Get jobs with pagination
$sql = "SELECT * FROM job_posts
        WHERE company_id = ? AND status = 'approved'
        ORDER BY created_at DESC
        LIMIT ? OFFSET ?";
$jobs = $db->query($sql, [$company_id, $items_per_page, $offset]);

// Debug jobs data
echo "<pre style='display:none'>";
var_dump($jobs);
echo "</pre>";

// Set page title
$pageTitle = $company['company_name'];

// Include header
include(LAYOUTS_PATH . '/header.php');
?>

<!-- Main Content -->
<div class="main-content">
    <div class="company-detail-container">
        <!-- Company Header Section - This part stays fixed -->
        <?php include(COMPONENTS_PATH . '/company-header.php'); ?>

        <!-- Dynamic Content Section - This part changes based on tab -->
        <?php
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'home';

        switch($current_tab) {
            case 'about':
                include(COMPONENTS_PATH . '/company-about.php');
                break;
            case 'jobs':
                include(COMPONENTS_PATH . '/company-jobs.php');
                break;
            default:
                // Home tab content
                ?>
                <div class="section-wrapper overview-section">
                    <div class="content-section">
                        <h2 class="section-title">Overview</h2>
                        <p><?php echo nl2br(htmlspecialchars($company['description'] ?? 'Text here... see more')); ?></p>
                        <a href="<?php echo BASE_URL; ?>/public/?page=company-detail&id=<?php echo $company_id; ?>&tab=about" class="show-all-details">
                            Show all details
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Recent Jobs Section -->
                <div class="section-wrapper jobs-section">
                    <?php if (!empty($jobs)): ?>
                        <?php include(COMPONENTS_PATH . '/recent-jobs.php'); ?>
                    <?php else: ?>
                        <div class="content-section">
                            <h2 class="section-title">Recent job openings</h2>
                            <p>No job openings available at the moment.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
                break;
        }
        ?>
    </div>
</div>

<?php include(LAYOUTS_PATH . '/footer.php'); ?>

<!-- Link to CSS file -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/assets/css/company-detail.css">

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">