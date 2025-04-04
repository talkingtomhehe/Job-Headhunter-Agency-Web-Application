<?php
require_once MODELS_PATH . '/job.php';

$jobModel = new Job();
$recent_jobs = $jobModel->getJobs($company['company_id'], '', 1, 3, '', 'newest');
?>

<div class="section-wrapper overview-section">
    <div class="content-section">
        <h2 class="section-title">Giới thiệu</h2>
        <div class="company-info-details">
            <div class="info-item">
                <h3>Trụ sở chính</h3>
                <p><?php echo htmlspecialchars($company['headquarters_address'] ?? 'Chưa cập nhật'); ?></p>
            </div>

            <div class="info-item">
                <h3>Website</h3>
                <p>
                    <?php if (!empty($company['website_url'])): ?>
                        <a href="<?php echo htmlspecialchars($company['website_url']); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo htmlspecialchars($company['website_url']); ?>
                        </a>
                    <?php else: ?>
                        Chưa cập nhật
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>

    <?php if (!empty($company['company_description'])): ?>
    <div class="content-section">
        <h2 class="section-title">Về chúng tôi</h2>
        <div class="company-description">
            <?php echo nl2br(htmlspecialchars($company['company_description'])); ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="content-section">
        <h2 class="section-title">Vị trí tuyển dụng mới nhất</h2>
        <?php if (!empty($recent_jobs)): ?>
            <div class="recent-jobs">
                <?php foreach ($recent_jobs as $job): ?>
                    <div class="job-card">
                        <div class="job-info">
                            <div class="job-details">
                                <a href="<?php echo BASE_URL; ?>/public/?page=job-detail&id=<?php echo $job['job_id']; ?>"
                                   class="job-title">
                                    <?php echo htmlspecialchars($job['title']); ?>
                                </a>
                                <div class="job-meta">
                                    <span class="job-type-tag">
                                        <?php echo htmlspecialchars($job['job_type']); ?>
                                    </span>
                                    <span class="job-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?php echo htmlspecialchars($job['location']); ?>
                                    </span>
                                    <?php if ($job['salary_min'] && $job['salary_max']): ?>
                                        <span class="salary-range">
                                            <i class="fas fa-dollar-sign"></i>
                                            <?php echo number_format($job['salary_min']) . ' - ' . number_format($job['salary_max']) . ' USD'; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="no-jobs">Chưa có vị trí tuyển dụng nào</p>
        <?php endif; ?>
    </div>
</div>