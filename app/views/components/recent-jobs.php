<div class="content-section">
    <h2 class="section-title">Recent job openings</h2>
    <div class="job-list">
        <?php foreach ($jobs as $job): ?>
            <div class="job-card">
                <div class="job-info">
                    <div class="company-logo-small">
                        <?php if ($company['logo_path']): ?>
                            <img src="<?php echo BASE_URL . '/public/' . ltrim($company['logo_path'], '/'); ?>"
                                 alt="<?php echo htmlspecialchars($company['company_name']); ?> logo"
                                 onerror="this.style.display='none'">
                        <?php else: ?>
                            <div class="no-logo-small">
                                <?php echo strtoupper(substr($company['company_name'] ?? 'A', 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="job-details">
                        <h3>
                            <a href="/jobs/<?php echo $job['job_id']; ?>">
                                <?php echo htmlspecialchars($job['title']); ?>
                            </a>
                        </h3>
                        <div class="job-meta">
                            <span><?php echo htmlspecialchars($company['company_name']); ?></span>
                        </div>
                        <div class="job-type-tags">
                            <a href="/jobs?type=hybrid" class="job-type-tag">Hybrid</a>
                            <a href="/jobs?category=data-science" class="job-type-tag">Data Science/ Data Analysis</a>
                        </div>
                    </div>
                </div>
                <div class="job-right-section">
                    <div class="job-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo htmlspecialchars($job['location']); ?></span>
                    </div>
                    <div class="salary-range">
                        <i class="fas fa-dollar-sign"></i>
                        <?php echo htmlspecialchars($job['salary_range'] ?? '$80 - $100'); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($total_pages > 1): ?>
        <a href="#" class="show-more-jobs">
            Show more jobs
            <i class="fas fa-chevron-right"></i>
        </a>
    <?php endif; ?>
</div>