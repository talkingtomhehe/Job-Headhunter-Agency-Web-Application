<?php
require_once MODELS_PATH . '/job.php';

$company_id = isset($_GET['id']) ? $_GET['id'] : null;
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$current_page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
$jobs_per_page = 10;

// Thêm các tham số lọc và sắp xếp
$job_type = isset($_GET['type']) ? $_GET['type'] : '';
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Get total jobs and paginated jobs
$jobModel = new Job();
$total_jobs = $jobModel->getTotalJobs($company_id, $search_query, $job_type);
$jobs = $jobModel->getJobs($company_id, $search_query, $current_page, $jobs_per_page, $job_type, $sort_by);

// Lấy danh sách các loại công việc
$job_types = $jobModel->getJobTypes();
?>

<div class="company-jobs-section">
    <?php include COMPONENTS_PATH . '/job-search.php'; ?>

    <div class="filters-section">
        <div class="filter-group">
            <label for="sort-by">Sắp xếp theo:</label>
            <select id="sort-by" name="sort" onchange="updateFilters()">
                <option value="newest" <?php echo $sort_by === 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
                <option value="oldest" <?php echo $sort_by === 'oldest' ? 'selected' : ''; ?>>Cũ nhất</option>
                <option value="salary_high" <?php echo $sort_by === 'salary_high' ? 'selected' : ''; ?>>Lương cao nhất</option>
                <option value="salary_low" <?php echo $sort_by === 'salary_low' ? 'selected' : ''; ?>>Lương thấp nhất</option>
            </select>
        </div>
    </div>

    <?php if (!empty($jobs)): ?>
        <div class="job-listings">
            <?php foreach ($jobs as $job): ?>
                <div class="job-card">
                    <div class="job-info">
                        <div class="company-logo-small">
                            <?php if (!empty($job['company_logo'])): ?>
                                <img src="<?php echo BASE_URL . '/public/' . ltrim($job['company_logo'], '/'); ?>"
                                     alt="<?php echo htmlspecialchars($job['company_name']); ?> logo">
                            <?php else: ?>
                                <div class="no-logo-small">
                                    <?php echo strtoupper(substr($job['company_name'], 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="job-details">
                            <a href="<?php echo BASE_URL; ?>/public/?page=job-detail&id=<?php echo $job['job_id']; ?>"
                               class="job-title">
                                <?php echo htmlspecialchars($job['title']); ?>
                            </a>
                            <div class="company-name">
                                <?php echo htmlspecialchars($job['company_name']); ?>
                            </div>
                            <div class="job-tags">
                                <?php if ($job['job_type']): ?>
                                    <span class="job-type-tag">
                                        <?php echo htmlspecialchars($job['job_type']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="job-right-section">
                        <div class="job-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo htmlspecialchars($job['location']); ?>
                        </div>
                        <?php if ($job['salary_min'] && $job['salary_max']): ?>
                            <div class="salary-range">
                                <i class="fas fa-dollar-sign"></i>
                                <?php echo number_format($job['salary_min']) . ' - ' . number_format($job['salary_max']) . ' USD'; ?>
                            </div>
                        <?php endif; ?>
                        <div class="posted-date">
                            <i class="fas fa-clock"></i>
                            <?php
                            $posted_date = new DateTime($job['created_at']);
                            $now = new DateTime();
                            $interval = $posted_date->diff($now);

                            if ($interval->days == 0) {
                                echo "Hôm nay";
                            } elseif ($interval->days == 1) {
                                echo "Hôm qua";
                            } else {
                                echo $interval->days . " ngày trước";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php include COMPONENTS_PATH . '/pagination.php'; ?>

    <?php else: ?>
        <div class="no-jobs-found">
            <i class="fas fa-search"></i>
            <h3>Không tìm thấy việc làm phù hợp</h3>
            <p>Hãy thử tìm kiếm với từ khóa khác hoặc điều chỉnh bộ lọc</p>
        </div>
    <?php endif; ?>
</div>

<script>
function updateFilters() {
    const urlParams = new URLSearchParams(window.location.search);

    // Cập nhật các tham số từ select boxes
    const sortBy = document.getElementById('sort-by').value;

    if (sortBy) urlParams.set('sort', sortBy);
    else urlParams.delete('sort');

    // Reset trang về 1 khi thay đổi bộ lọc
    urlParams.delete('page_num');

    // Chuyển hướng đến URL mới với các bộ lọc đã cập nhật
    window.location.href = window.location.pathname + '?' + urlParams.toString();
}
</script>