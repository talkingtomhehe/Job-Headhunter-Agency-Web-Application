<div class="page-header">
    <div class="back-link">
        <a href="<?= SITE_URL ?>/admin/jobs">
            <i class="fa-solid fa-arrow-left"></i> Back to Job Listings
        </a>
    </div>
</div>

<div class="admin-job-view">
    <div class="dashboard-card">
        <div class="card-header">
            <div class="job-title-header">
                <h2><?= htmlspecialchars($job['title']) ?></h2>
                <span class="status-badge admin-status-<?= strtolower($job['admin_status']) ?>">
                    <?= ucfirst($job['admin_status']) ?>
                </span>
            </div>
            
            <div class="card-actions">
                <a href="<?= SITE_URL ?>/admin/jobs/edit/<?= $job['job_id'] ?>" class="btn-action btn-edit">
                    <i class="fa-solid fa-pencil"></i> Edit Job
                </a>
                
                <?php if ($job['status'] === 'pending'): ?>
                <div class="approval-actions">
                    <form action="<?= SITE_URL ?>/admin/jobs/approve/<?= $job['job_id'] ?>" method="POST" style="display: inline;">
                        <button type="submit" class="btn-approve">
                            <i class="fa-solid fa-check"></i> Approve
                        </button>
                    </form>
                    <form action="<?= SITE_URL ?>/admin/jobs/reject/<?= $job['job_id'] ?>" method="POST" style="display: inline;">
                        <button type="submit" class="btn-reject">
                            <i class="fa-solid fa-times"></i> Reject
                        </button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card-body">
            <div class="job-meta-section">
                <div class="job-company-info">
                    <div class="company-logo-container">
                        <?php
                        $logoPath = !empty($company['logo_path']) ? $company['logo_path'] : 'uploads/logo/defaultlogo.jpg';
                        ?>
                        <img src="<?= SITE_URL . PUBLIC_PATH . '/' . $logoPath ?>" alt="<?= htmlspecialchars($company['company_name']) ?>" class="company-logo">
                    </div>
                    <div class="company-details">
                        <h3><?= htmlspecialchars($company['company_name'] ?? 'Unknown Company') ?></h3>
                        <p class="employer-name">Posted by: <?= isset($employer) && $employer ? htmlspecialchars($employer['full_name']) : 'Unknown' ?></p>
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
                    
                    <?php if (!empty($job['work_model'])): ?>
                    <div class="meta-item">
                        <i class="fa-solid fa-house-laptop"></i>
                        <span><?= ucfirst(htmlspecialchars($job['work_model'])) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($job['experience_level'])): ?>
                    <div class="meta-item">
                        <i class="fa-solid fa-chart-line"></i>
                        <span><?= ucfirst(htmlspecialchars($job['experience_level'])) ?> Level</span>
                    </div>
                    <?php endif; ?>
                    
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
                    
                    <div class="meta-item">
                        <i class="fa-solid fa-calendar"></i>
                        <span>Posted: <?= date('M d, Y', strtotime($job['created_at'])) ?></span>
                    </div>
                </div>
            </div>

            <div class="job-content-section">
                <div class="job-section">
                    <h3>Description</h3>
                    <div class="job-description">
                        <?= nl2br(htmlspecialchars($job['description'])) ?>
                    </div>
                </div>
                
                <div class="job-section">
                    <h3>Requirements</h3>
                    <div class="job-requirements">
                        <?= nl2br(htmlspecialchars($job['requirements'])) ?>
                    </div>
                </div>
                
                <?php if (!empty($job['benefits'])): ?>
                <div class="job-section">
                    <h3>Benefits</h3>
                    <div class="job-benefits">
                        <?= nl2br(htmlspecialchars($job['benefits'])) ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($job['pdf_path'])): ?>
                <div class="job-section pdf-section">
                    <h3>Additional Documents</h3>
                    <div class="pdf-container">
                        <a href="<?= SITE_URL . PUBLIC_PATH . '/' . $job['pdf_path'] ?>" target="_blank" class="btn-document">
                            <i class="fa-solid fa-file-pdf"></i> View Complete Job Description (PDF)
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="dashboard-card applications-card">
        <div class="card-header">
            <h2>Applications (<?= isset($applications) ? count($applications) : 0 ?>)</h2>
        </div>
        
        <div class="card-body">
            <?php if (empty($applications)): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-file-circle-xmark"></i>
                    </div>
                    <p>No applications have been submitted for this job yet</p>
                </div>
            <?php else: ?>
                <div class="responsive-table">
                    <table class="data-table applications-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Applied Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $application): ?>
                                <tr>
                                    <td>
                                        <div class="applicant-cell">
                                            <?php
                                            $avatarPath = !empty($application['avatar_path']) ? $application['avatar_path'] : 'assets/images/defaultavatar.jpg';
                                            ?>
                                            <img src="<?= SITE_URL . PUBLIC_PATH . '/' . $avatarPath ?>" alt="<?= htmlspecialchars($application['full_name']) ?>" class="applicant-avatar">
                                            <div class="applicant-info">
                                                <strong><?= htmlspecialchars($application['full_name']) ?></strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($application['created_at'])) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($application['status']) ?>">
                                            <?= ucfirst($application['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= SITE_URL ?>/admin/applications/view/<?= $application['application_id'] ?>" class="btn-icon" title="View Application">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>