<main>
    <!-- Job detail section -->
    <section class="job-detail-section">
        <div class="container">
            <!-- Back to jobs link -->
            <div class="back-link">
                <a href="<?= SITE_URL ?>/jobs" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Back to Jobs
                </a>
            </div>
            
            <?php if (isset($job) && $job): ?>
                <div class="job-detail-card">
                    <div class="job-header">
                        <div class="company-logo">
                            <img src="<?= SITE_URL . PUBLIC_PATH ?>/<?= !empty($job['logo_path']) ? $job['logo_path'] : 'assets/images/default-logo.png' ?>" 
                                 alt="<?= htmlspecialchars($job['company_name']) ?>"
                                 onerror="this.src='<?= SITE_URL . PUBLIC_PATH ?>/assets/images/default-logo.png'">
                        </div>
                        <div class="job-title-container">
                            <h1 class="job-title"><?= htmlspecialchars($job['title']) ?></h1>
                            <p class="company-name"><?= htmlspecialchars($job['company_name']) ?></p>
                        </div>
                        <div class="apply-btn-container">
                            <a href="<?= SITE_URL ?>/jobs/apply/<?= $job['job_id'] ?>" class="apply-button">Apply Now</a>
                            <a href="<?= SITE_URL ?>/jobs/download/<?= $job['job_id'] ?>" class="download-pdf-button">
                                <i class="fa-solid fa-download"></i> Download PDF
                            </a>
                        </div>
                    </div>
                    
                    <div class="job-meta-info">
                        <div class="meta-item">
                            <span class="meta-label"><i class="fa-solid fa-location-dot"></i> Location</span>
                            <span class="meta-value"><?= htmlspecialchars($job['location']) ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label"><i class="fa-solid fa-money-bill"></i> Salary</span>
                            <span class="meta-value"><?= formatSalary($job['salary_min'], $job['salary_max']) ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label"><i class="fa-solid fa-briefcase"></i> Employment Type</span>
                            <span class="meta-value"><?= htmlspecialchars($job['employment_type']) ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label"><i class="fa-solid fa-house"></i> Work Model</span>
                            <span class="meta-value"><?= htmlspecialchars($job['work_model']) ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label"><i class="fa-solid fa-graduation-cap"></i> Experience</span>
                            <span class="meta-value"><?= htmlspecialchars($job['experience_level']) ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label"><i class="fa-regular fa-calendar"></i> Posted</span>
                            <span class="meta-value"><?= formatDate($job['created_at']) ?></span>
                        </div>
                    </div>
                    
                    <div class="job-description">
                        <h2>Job Description</h2>
                        <div class="description-content">
                            <?= nl2br(htmlspecialchars($job['description'])) ?>
                        </div>
                    </div>
                    
                    <div class="job-requirements">
                        <h2>Requirements</h2>
                        <div class="requirements-content">
                            <?= nl2br(htmlspecialchars($job['requirements'])) ?>
                        </div>
                    </div>
                    
                    <div class="job-benefits">
                        <h2>Benefits</h2>
                        <div class="benefits-content">
                            <?= nl2br(htmlspecialchars($job['benefits'])) ?>
                        </div>
                    </div>
                    
                    <div class="job-footer">
                        <a href="<?= SITE_URL ?>/jobs/apply/<?= $job['job_id'] ?>" class="apply-button">Apply Now</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="error-message">
                    <h2>Job Not Found</h2>
                    <p>The job listing you're looking for doesn't exist or has been removed.</p>
                    <a href="<?= SITE_URL ?>/jobs" class="btn-primary">Browse All Jobs</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Related jobs section -->
    <?php if (isset($relatedJobs) && !empty($relatedJobs)): ?>
    <section class="related-jobs">
        <div class="container">
            <h2 class="section-title">Similar Jobs<span class="title-underline"></span></h2>
            
            <div class="jobs-container">
                <?php foreach ($relatedJobs as $relatedJob): ?>
                    <div class="job-card" onclick="window.location.href='<?= SITE_URL ?>/jobs/view/<?= $relatedJob['job_id'] ?>'">
                        <div class="job-header">
                            <div class="company-logo">
                                <img src="<?= SITE_URL . PUBLIC_PATH ?>/<?= !empty($relatedJob['logo_path']) ? $relatedJob['logo_path'] : 'assets/images/default-logo.png' ?>" 
                                     alt="<?= htmlspecialchars($relatedJob['company_name']) ?>"
                                     onerror="this.src='<?= SITE_URL . PUBLIC_PATH ?>/assets/images/default-logo.png'">
                            </div>
                            <div class="job-info">
                                <h3 class="job-title"><?= htmlspecialchars($relatedJob['title']) ?></h3>
                                <p class="company-name"><?= htmlspecialchars($relatedJob['company_name']) ?></p>
                                <div class="job-tags">
                                    <span class="job-tag"><?= htmlspecialchars($relatedJob['work_model']) ?></span>
                                    <span class="job-tag"><?= htmlspecialchars($relatedJob['category_name']) ?></span>
                                </div>
                            </div>
                            <div class="job-meta">
                                <p class="job-location"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($relatedJob['location']) ?></p>
                                <p class="job-salary"><i class="fa-solid fa-money-bill"></i> <?= formatSalary($relatedJob['salary_min'], $relatedJob['salary_max']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>