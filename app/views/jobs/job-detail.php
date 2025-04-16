<main>
    <!-- Job detail hero banner section with company info -->
    <section class="jd-job-hero-banner">
        <div class="container">
            <div class="jd-back-link">
                <a href="<?= SITE_URL ?>/job" class="jd-btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Back to Jobs
                </a>
            </div>
            
            <?php if (isset($job) && $job): ?>
                <div class="jd-job-header-card">
                    <div class="jd-job-header-content">
                        <div class="jd-company-logo">
                            <img src="<?= SITE_URL . PUBLIC_PATH ?>/<?= !empty($job['logo_path']) ? $job['logo_path'] : 'assets/images/default-logo.png' ?>" 
                                alt="<?= htmlspecialchars($job['company_name']) ?>"
                                onerror="this.src='<?= SITE_URL . PUBLIC_PATH ?>/assets/images/default-logo.png'">
                        </div>
                        <div class="jd-job-title-container">
                            <h1 class="jd-job-title"><?= htmlspecialchars($job['title']) ?></h1>
                            <p class="jd-company-name"><?= htmlspecialchars($job['company_name']) ?></p>
                            
                            <div class="jd-job-tags">
                                <?php if (!empty($job['work_model'])): ?>
                                    <span class="jd-job-tag work-model"><i class="fa-solid fa-house"></i> <?= htmlspecialchars($job['work_model']) ?></span>
                                <?php endif; ?>
                                
                                <?php if (!empty($job['job_type'])): ?>
                                    <span class="jd-job-tag job-type"><i class="fa-solid fa-clock"></i> <?= htmlspecialchars($job['job_type']) ?></span>
                                <?php endif; ?>
                                
                                <?php if (!empty($job['experience_level'])): ?>
                                    <span class="jd-job-tag experience"><i class="fa-solid fa-graduation-cap"></i> <?= htmlspecialchars($job['experience_level']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="jd-apply-btn-container">
                            <a href="<?= SITE_URL ?>/job/apply/<?= $job['job_id'] ?>" class="jd-apply-button">
                                <i class="fa-solid fa-paper-plane"></i> Apply Now
                            </a>
                            
                            <?php if (!empty($job['pdf_path'])): ?>
                                <a href="<?= SITE_URL ?>/job/downloadPdf/<?= $job['job_id'] ?>" class="jd-download-pdf-button">
                                    <i class="fa-solid fa-file-pdf"></i> Download Job Description
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Job detail main content section -->
    <section class="jd-job-detail-section">
        <div class="container">
            <?php if (isset($job) && $job): ?>
                <div class="jd-job-content-wrapper">
                    <!-- Left column: Job details -->
                    <div class="jd-job-detail-card main-content">
                        <div class="jd-job-meta-info">
                            <div class="jd-meta-item">
                                <span class="jd-meta-label"><i class="fa-solid fa-location-dot"></i> Location</span>
                                <span class="jd-meta-value"><?= htmlspecialchars($job['location']) ?></span>
                            </div>
                            
                            <?php if (!empty($job['salary_min']) || !empty($job['salary_max'])): ?>
                            <div class="jd-meta-item">
                                <span class="jd-meta-label"><i class="fa-solid fa-money-bill"></i> Salary</span>
                                <span class="jd-meta-value"><?= $formatSalary($job['salary_min'], $job['salary_max']) ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($job['job_type'])): ?>
                            <div class="jd-meta-item">
                                <span class="jd-meta-label"><i class="fa-solid fa-briefcase"></i> Employment Type</span>
                                <span class="jd-meta-value"><?= htmlspecialchars($job['job_type']) ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($job['work_model'])): ?>
                            <div class="jd-meta-item">
                                <span class="jd-meta-label"><i class="fa-solid fa-house"></i> Work Model</span>
                                <span class="jd-meta-value"><?= htmlspecialchars($job['work_model']) ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($job['experience_level'])): ?>
                            <div class="jd-meta-item">
                                <span class="jd-meta-label"><i class="fa-solid fa-graduation-cap"></i> Experience</span>
                                <span class="jd-meta-value"><?= htmlspecialchars($job['experience_level']) ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="jd-meta-item">
                                <span class="jd-meta-label"><i class="fa-regular fa-calendar"></i> Posted</span>
                                <span class="jd-meta-value"><?= $formatDate($job['created_at']) ?></span>
                            </div>
                            
                            <?php if (!empty($job['application_deadline'])): ?>
                            <div class="jd-meta-item deadline">
                                <span class="jd-meta-label"><i class="fa-solid fa-hourglass-end"></i> Application Deadline</span>
                                <span class="jd-meta-value"><?= $formatDate($job['application_deadline']) ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="jd-job-description">
                            <h2><i class="fa-solid fa-file-alt"></i> Job Description</h2>
                            <div class="jd-description-content">
                                <?= nl2br(htmlspecialchars($job['description'])) ?>
                            </div>
                        </div>
                        
                        <div class="jd-job-requirements">
                            <h2><i class="fa-solid fa-list-check"></i> Requirements</h2>
                            <div class="jd-requirements-content">
                                <?= nl2br(htmlspecialchars($job['requirements'])) ?>
                            </div>
                        </div>
                        
                        <?php if (!empty($job['benefits'])): ?>
                        <div class="jd-job-benefits">
                            <h2><i class="fa-solid fa-gift"></i> Benefits</h2>
                            <div class="jd-benefits-content">
                                <?= nl2br(htmlspecialchars($job['benefits'])) ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="jd-job-footer">
                            <div class="jd-action-buttons">
                                <a href="<?= SITE_URL ?>/job/apply/<?= $job['job_id'] ?>" class="jd-apply-button">
                                    <i class="fa-solid fa-paper-plane"></i> Apply Now
                                </a>
                                
                                <button type="button" class="jd-share-button" id="shareJobBtn">
                                    <i class="fa-solid fa-share-nodes"></i> Share
                                </button>
                                
                                <div class="jd-share-dropdown" id="shareDropdown">
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(SITE_URL . '/job/viewJob/' . $job['job_id']) ?>" target="_blank" class="jd-share-option linkedin">
                                        <i class="fa-brands fa-linkedin"></i> LinkedIn
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text=<?= urlencode('Check out this job: ' . $job['title'] . ' at ' . $job['company_name']) ?>&url=<?= urlencode(SITE_URL . '/job/viewJob/' . $job['job_id']) ?>" target="_blank" class="jd-share-option twitter">
                                        <i class="fa-brands fa-twitter"></i> X (Twitter)
                                    </a>
                                    <a href="mailto:?subject=<?= urlencode('Job Opportunity: ' . $job['title'] . ' at ' . $job['company_name']) ?>&body=<?= urlencode('I found this job and thought you might be interested: ' . SITE_URL . '/job/viewJob/' . $job['job_id']) ?>" class="jd-share-option email">
                                        <i class="fa-solid fa-envelope"></i> Email
                                    </a>
                                    <button id="copyLinkBtn" class="jd-share-option copy" data-url="<?= SITE_URL ?>/job/viewJob/<?= $job['job_id'] ?>">
                                        <i class="fa-solid fa-copy"></i> Copy Link
                                    </button>
                                </div>
                            </div>
                            
                            <?php if (!empty($job['pdf_path'])): ?>
                                <a href="<?= SITE_URL ?>/job/downloadPdf/<?= $job['job_id'] ?>" class="jd-download-pdf-button">
                                    <i class="fa-solid fa-file-pdf"></i> Download Job Description
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Right column: Company info and similar jobs -->
                    <div class="jd-job-sidebar">
                        <!-- Company info card -->
                        <div class="jd-company-card">
                            <h3><i class="fa-solid fa-building"></i> About the Company</h3>
                            
                            <div class="jd-company-info">
                                <div class="jd-company-logo">
                                    <img src="<?= SITE_URL . PUBLIC_PATH ?>/<?= !empty($job['logo_path']) ? $job['logo_path'] : 'assets/images/default-logo.png' ?>" 
                                        alt="<?= htmlspecialchars($job['company_name']) ?>"
                                        onerror="this.src='<?= SITE_URL . PUBLIC_PATH ?>/assets/images/default-logo.png'">
                                </div>
                                
                                <h4 class="jd-company-name"><?= htmlspecialchars($job['company_name']) ?></h4>
                                
                                <?php if (!empty($company['industry'])): ?>
                                <div class="jd-company-detail">
                                    <i class="fa-solid fa-industry"></i>
                                    <span><?= htmlspecialchars($company['industry']) ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($company['company_size'])): ?>
                                <div class="jd-company-detail">
                                    <i class="fa-solid fa-users"></i>
                                    <span><?= htmlspecialchars($company['company_size']) ?> Employees</span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($company['website'])): ?>
                                <div class="jd-company-detail">
                                    <i class="fa-solid fa-globe"></i>
                                    <a href="<?= htmlspecialchars($company['website']) ?>" target="_blank">Visit Website</a>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($company['description'])): ?>
                                <div class="jd-company-description">
                                    <?= nl2br(htmlspecialchars($company['description'])) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Job application deadline card -->
                        <?php if (!empty($job['application_deadline'])): ?>
                        <div class="jd-deadline-card">
                            <div class="jd-deadline-icon">
                                <i class="fa-solid fa-hourglass-half"></i>
                            </div>
                            <div class="jd-deadline-info">
                                <h4>Application Deadline</h4>
                                <p><?= $formatDate($job['application_deadline']) ?></p>
                                <?php
                                $deadline = new DateTime($job['application_deadline']);
                                $now = new DateTime();
                                $interval = $now->diff($deadline);
                                $expired = $deadline < $now;
                                if(!$expired):
                                ?>
                                <span class="jd-days-left"><?= $interval->days ?> days left to apply</span>
                                <?php else: ?>
                                <span class="jd-deadline-expired">Deadline has passed</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="jd-job-not-found">
                    <h2>Job Not Found</h2>
                    <p>The job listing you're looking for doesn't exist or has been removed.</p>
                    <a href="<?= SITE_URL ?>/job" class="jd-btn-primary">Browse All Jobs</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Related jobs section -->
    <?php if (isset($relatedJobs) && !empty($relatedJobs)): ?>
    <section class="jd-related-jobs">
        <div class="container">
            <h2 class="section-title">Similar Jobs<span class="title-underline"></span></h2>
            
            <div class="jobs-container">
                <?php foreach ($relatedJobs as $relatedJob): ?>
                    <div class="job-card" onclick="window.location.href='<?= SITE_URL ?>/job/viewJob/<?= $relatedJob['job_id'] ?>'">
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
                                    <?php if (!empty($relatedJob['work_model'])): ?>
                                        <span class="job-tag"><?= htmlspecialchars($relatedJob['work_model']) ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($relatedJob['job_type'])): ?>
                                        <span class="job-tag"><?= htmlspecialchars($relatedJob['job_type']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="job-meta">
                                <p class="job-location"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($relatedJob['location']) ?></p>
                                <p class="job-salary"><i class="fa-solid fa-money-bill"></i> <?= $formatSalary($relatedJob['salary_min'], $relatedJob['salary_max']) ?></p>
                                <?php if (isset($timeAgo) && is_callable($timeAgo)): ?>
                                <p class="job-date"><i class="fa-regular fa-calendar"></i> Posted <?= $timeAgo($relatedJob['created_at']) ?></p>
                                <?php else: ?>
                                <p class="job-date"><i class="fa-regular fa-calendar"></i> Posted <?= $formatDate($relatedJob['created_at']) ?></p>
                                <?php endif; ?>
                                <a href="<?= SITE_URL ?>/job/viewJob/<?= $relatedJob['job_id'] ?>" class="view-job-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Share button functionality
    const shareBtn = document.getElementById('shareJobBtn');
    const shareDropdown = document.getElementById('shareDropdown');
    const copyLinkBtn = document.getElementById('copyLinkBtn');
    
    if (shareBtn && shareDropdown) {
        shareBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            shareDropdown.classList.toggle('active');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!shareDropdown.contains(e.target) && e.target !== shareBtn) {
                shareDropdown.classList.remove('active');
            }
        });
    }
    
    // Copy link functionality
    if (copyLinkBtn) {
        copyLinkBtn.addEventListener('click', function() {
            const url = this.dataset.url;
            navigator.clipboard.writeText(url).then(function() {
                const originalText = copyLinkBtn.innerHTML;
                copyLinkBtn.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';
                
                setTimeout(function() {
                    copyLinkBtn.innerHTML = originalText;
                }, 2000);
            });
        });
    }
});
</script>