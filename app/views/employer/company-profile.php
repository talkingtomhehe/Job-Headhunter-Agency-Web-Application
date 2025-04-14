<div class="dashboard-section">
    <div class="section-header">
        <div class="section-actions">
            <a href="<?= SITE_URL ?>/employer/profile/edit" class="btn-primary">
                <i class="fa-solid fa-pencil"></i> Edit Profile
            </a>
        </div>
    </div>
    
    <div class="profile-container">
        <div class="dashboard-card profile-card">
            <div class="card-header">
                <h2>Company Information</h2>
            </div>
            <div class="card-body">
                <!-- Restructured company header -->
                <div class="company-header">
                    <div class="company-name-section">
                        <h1 class="company-name"><?= htmlspecialchars($company['company_name']) ?></h1>
                    </div>
                    
                    <div class="company-info-section">
                        <div class="company-logo-container">
                            <?php if (!empty($company['logo_path'])): ?>
                                <img src="<?= SITE_URL . PUBLIC_PATH . '/' . $company['logo_path'] ?>" alt="<?= htmlspecialchars($company['company_name']) ?>" class="company-logo">
                            <?php else: ?>
                                <div class="company-logo-placeholder">
                                    <?= substr($company['company_name'], 0, 1) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="company-basic-info">
                            <?php if (!empty($company['headquarters_address'])): ?>
                                <div class="company-info-item company-location">
                                    <i class="fa-solid fa-location-dot"></i> 
                                    <span><?= htmlspecialchars($company['headquarters_address']) ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($company['website'])): ?>
                                <div class="company-info-item company-website">
                                    <i class="fa-solid fa-globe"></i>
                                    <a href="<?= filter_var($company['website'], FILTER_VALIDATE_URL) ? $company['website'] : 'https://' . $company['website'] ?>" target="_blank">
                                        <?= htmlspecialchars($company['website']) ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($company['industry'])): ?>
                                <div class="company-info-item company-industry">
                                    <i class="fa-solid fa-briefcase"></i>
                                    <span><?= htmlspecialchars($company['industry']) ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($company['company_size'])): ?>
                                <div class="company-info-item company-size">
                                    <i class="fa-solid fa-users"></i>
                                    <span><?= htmlspecialchars($company['company_size']) ?> employees</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <?php if (!empty($company['description'])): ?>
                <div class="profile-section">
                    <h3>About the Company</h3>
                    <div class="profile-content">
                        <div class="company-description">
                            <?= nl2br(htmlspecialchars($company['description'])) ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="profile-section">
                    <div class="section-header-flex">
                        <h3>Jobs Posted</h3>
                        <?php if (isset($jobs) && count($jobs) > 5): ?>
                            <a href="<?= SITE_URL ?>/employer/jobs" class="view-all-link">View All Jobs <i class="fa-solid fa-arrow-right"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="profile-content">
                        <?php if (isset($jobs) && count($jobs) > 0): ?>
                            <div class="profile-jobs-list">
                                <?php foreach($jobs as $job): ?>
                                <a href="<?= SITE_URL ?>/employer/jobs/viewJob/<?= $job['job_id'] ?>" class="profile-job-item">
                                    <div class="profile-job-content">
                                        <h4 class="profile-job-title"><?= htmlspecialchars($job['title']) ?></h4>
                                        <div class="profile-job-meta">
                                            <span><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($job['location']) ?></span>
                                            <span><i class="fa-solid fa-clock"></i> 
                                                <?php 
                                                if (isset($job['work_model'])) {
                                                    echo htmlspecialchars(ucfirst($job['work_model'])); 
                                                } else {
                                                    echo 'Not specified';
                                                }
                                                ?>
                                            </span>
                                            <span class="profile-job-status status-<?= strtolower($job['status']) ?>">
                                                <?= ucfirst($job['status']) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="profile-job-arrow">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="empty-text">No jobs posted yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>