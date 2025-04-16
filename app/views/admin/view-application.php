<div class="page-header">
    <div class="back-link">
        <a href="<?= SITE_URL ?>/admin/applications">
            <i class="fa-solid fa-arrow-left"></i> Back to Applications
        </a>
    </div>
</div>

<div class="admin-job-view">
    <div class="dashboard-card">
        <div class="card-header">
            <div class="job-title-header">
                <h2>Application for: <?= htmlspecialchars($job['title']) ?></h2>
                <span class="status-badge admin-status-<?= strtolower($application['admin_status']) ?>">
                    <?= ucfirst($application['admin_status']) ?>
                </span>
            </div>
            
            <div class="card-actions">
                <div class="approval-actions">
                    <form action="<?= SITE_URL ?>/admin/applications/approve" method="POST" style="display: inline;">
                        <input type="hidden" name="application_id" value="<?= $application['application_id'] ?>">
                        <button type="submit" class="btn-approve" <?= $application['admin_status'] == 'approved' ? 'disabled' : '' ?>>
                            <i class="fa-solid fa-check"></i> Approve
                        </button>
                    </form>
                    <form action="<?= SITE_URL ?>/admin/applications/reject" method="POST" style="display: inline;">
                        <input type="hidden" name="application_id" value="<?= $application['application_id'] ?>">
                        <button type="submit" class="btn-reject" <?= $application['admin_status'] == 'rejected' ? 'disabled' : '' ?>>
                            <i class="fa-solid fa-times"></i> Reject
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="job-meta-section">
                <div class="job-company-info">
                    <div class="applicant-avatar">
                        <?php
                        $avatarPath = !empty($user['avatar_path']) ? $user['avatar_path'] : 'assets/images/defaultavatar.jpg';
                        ?>
                        <img src="<?= SITE_URL . PUBLIC_PATH . '/' . $avatarPath ?>" alt="<?= htmlspecialchars($user['full_name']) ?>" class="user-avatar">
                    </div>
                    <div class="company-details">
                        <h3><?= htmlspecialchars($application['full_name']) ?></h3>
                        <p class="employer-name">Applied on: <?= date('F d, Y', strtotime($application['created_at'])) ?></p>
                    </div>
                </div>

                <div class="job-meta-grid">
                    <div class="meta-item">
                        <i class="fa-solid fa-envelope"></i>
                        <span><?= htmlspecialchars($application['email']) ?></span>
                    </div>
                    
                    <?php if (!empty($application['phone'])): ?>
                    <div class="meta-item">
                        <i class="fa-solid fa-phone"></i>
                        <span><?= htmlspecialchars($application['phone']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="meta-item">
                        <i class="fa-solid fa-briefcase"></i>
                        <span>Job: <?= htmlspecialchars($job['title']) ?></span>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fa-solid fa-building"></i>
                        <span>Company: <?= htmlspecialchars($job['company_name'] ?? 'N/A') ?></span>
                    </div>
                </div>
            </div>

            <div class="job-content-section">
                <div class="job-section">
                    <h3>Cover Letter</h3>
                    <div class="job-description">
                        <?= nl2br(htmlspecialchars($application['cover_letter'] ?? 'No cover letter provided.')) ?>
                    </div>
                </div>
                
                <?php if (!empty($application['resume_path'])): ?>
                <div class="job-section pdf-section">
                    <h3>Resume/CV</h3>
                    <div class="pdf-container">
                        <a href="<?= SITE_URL . PUBLIC_PATH ?>/<?= $application['resume_path'] ?>" target="_blank" class="btn-document">
                            <i class="fa-solid fa-file-pdf"></i> View Resume
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="dashboard-card applications-card">
        <div class="card-header">
            <h2>Job Details</h2>
        </div>
        
        <div class="card-body">
            <div class="job-meta-section">
                <div class="job-company-info">
                    <div class="company-logo-container">
                        <?php
                        $logoPath = !empty($job['company_logo']) ? $job['company_logo'] : 'uploads/logo/defaultlogo.jpg';
                        ?>
                        <img src="<?= SITE_URL . PUBLIC_PATH . '/' . $logoPath ?>" alt="<?= htmlspecialchars($job['company_name'] ?? 'Company') ?>" class="company-logo">
                    </div>
                    <div class="company-details">
                        <h3><?= htmlspecialchars($job['title']) ?></h3>
                        <p><?= htmlspecialchars($job['company_name'] ?? 'Unknown Company') ?></p>
                    </div>
                </div>

                <div class="job-meta-grid">
                    <div class="meta-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <span><?= htmlspecialchars($job['location']) ?></span>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fa-solid fa-briefcase"></i>
                        <span><?= htmlspecialchars($job['job_type']) ?></span>
                    </div>
                    
                    <?php if (!empty($job['salary_min']) || !empty($job['salary_max'])): ?>
                    <div class="meta-item">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <span>
                            <?php if (!empty($job['salary_min']) && !empty($job['salary_max'])): ?>
                                $<?= number_format($job['salary_min']) ?> - $<?= number_format($job['salary_max']) ?>
                            <?php elseif (!empty($job['salary_min'])): ?>
                                From $<?= number_format($job['salary_min']) ?>
                            <?php elseif (!empty($job['salary_max'])): ?>
                                Up to $<?= number_format($job['salary_max']) ?>
                            <?php endif; ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="job-section">
                <h3>Job Description</h3>
                <div class="job-description">
                    <?= nl2br(htmlspecialchars($job['description'])) ?>
                </div>
            </div>
            
            <a href="<?= SITE_URL ?>/admin/jobs/view/<?= $job['job_id'] ?>" class="btn-primary">
                <i class="fa-solid fa-eye"></i> View Full Job Details
            </a>
        </div>
    </div>
</div>