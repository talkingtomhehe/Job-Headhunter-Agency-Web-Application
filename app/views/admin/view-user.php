<div class="page-header">
    <div class="back-link">
        <a href="<?= SITE_URL ?>/admin/users">
            <i class="fa-solid fa-arrow-left"></i> Back to User Management
        </a>
    </div>
</div>

<div class="admin-user-view profile-container">
    <!-- User Details Card -->
    <div class="dashboard-card profile-card">
        <div class="card-header">
            <div class="user-title-header">
                <h1><?= htmlspecialchars($user['full_name']) ?></h1>
                <span class="user-role-badge role-<?= $user['role'] ?>">
                    <?php if ($user['role'] === 'admin'): ?>
                        <i class="fa-solid fa-shield"></i> Administrator
                    <?php elseif ($user['role'] === 'company_admin'): ?>
                        <i class="fa-solid fa-building"></i> Employer
                    <?php else: ?>
                        <i class="fa-solid fa-user"></i> Job Seeker
                    <?php endif; ?>
                </span>
            </div>
            
            <div class="card-actions">
                <?php if ($user['role'] !== 'admin'): ?>
                    <button type="button" class="btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="<?= $user['user_id'] ?>">
                        <i class="fa-solid fa-trash"></i> Delete User
                    </button>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card-body">
            <div class="profile-section">
                <h3>Basic Information</h3>
                <div class="profile-content">
                    <div class="user-detail">
                        <span class="label">Email:</span>
                        <span class="value"><?= htmlspecialchars($user['email']) ?></span>
                    </div>
                    
                    <?php if (!empty($user['phone'])): ?>
                    <div class="user-detail">
                        <span class="label">Phone:</span>
                        <span class="value"><?= htmlspecialchars($user['phone']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="user-detail">
                        <span class="label">Joined:</span>
                        <span class="value"><?= date('F j, Y', strtotime($user['created_at'])) ?></span>
                    </div>
                </div>
            </div>
            
            <?php if ($user['role'] === 'company_admin' && isset($company)): ?>
            <!-- Company Information Section (using company profile styling) -->
            <div class="profile-section">
                <h3>Company Information</h3>
                <div class="profile-content">
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
                                    <div class="company-info-item">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span><?= htmlspecialchars($company['headquarters_address']) ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($company['industry'])): ?>
                                    <div class="company-info-item">
                                        <i class="fa-solid fa-briefcase"></i>
                                        <span><?= htmlspecialchars($company['industry']) ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($company['company_size'])): ?>
                                    <div class="company-info-item">
                                        <i class="fa-solid fa-users"></i>
                                        <span><?= htmlspecialchars($company['company_size']) ?> employees</span>
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
                                
                                <div class="company-info-item">
                                    <i class="fa-solid fa-briefcase"></i>
                                    <span><?= $jobCount ?? 0 ?> job<?= ($jobCount ?? 0) !== 1 ? 's' : '' ?> posted</span>
                                </div>
                                
                                <div class="company-info-item">
                                    <i class="fa-solid fa-calendar-alt"></i>
                                    <span>Joined: <?= date('F j, Y', strtotime($company['created_at'])) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (!empty($company['description'])): ?>
                        <div class="company-description">
                            <?= nl2br(htmlspecialchars($company['description'])) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Applications Section for Job Seekers -->
    <?php if ($user['role'] === 'job_seeker' && isset($applications)): ?>
    <div class="dashboard-card profile-card">
        <div class="card-header">
            <h2>Applications (<?= $applicationCount ?>)</h2>
        </div>
        
        <div class="card-body">
            <?php if (empty($applications)): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <p class="empty-text">No job applications submitted</p>
                </div>
            <?php else: ?>
                <div class="responsive-table">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Job</th>
                                <th>Company</th>
                                <th>Application Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $application): ?>
                                <tr>
                                    <td>
                                        <a href="<?= SITE_URL ?>/admin/jobs/view/<?= $application['job_id'] ?>">
                                            <?= htmlspecialchars($application['job_title']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="company-name-cell">
                                            <?php if (!empty($application['logo_path'])): ?>
                                                <img src="<?= SITE_URL ?>/public/uploads/logos/<?= $application['logo_path'] ?>" alt="<?= htmlspecialchars($application['company_name']) ?>" class="company-logo-small">
                                            <?php endif; ?>
                                            <span><?= htmlspecialchars($application['company_name']) ?></span>
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
    <?php endif; ?>
    
    <?php if ($user['role'] === 'company_admin' && isset($jobs)): ?>
    <div class="profile-section">
        <div class="section-header-flex">
            <h3>Jobs Posted (<?= count($jobs) ?>)</h3>
        </div>
        <div class="profile-content">
            <?php if (empty($jobs)): ?>
                <p class="empty-text">No jobs posted yet.</p>
            <?php else: ?>
                <div class="profile-jobs-list">
                    <?php foreach ($jobs as $job): ?>
                    <a href="<?= SITE_URL ?>/admin/jobs/view/<?= $job['job_id'] ?>" class="profile-job-item">
                        <div class="profile-job-content">
                            <h4 class="profile-job-title"><?= htmlspecialchars($job['title']) ?></h4>
                            <div class="profile-job-meta">
                                <span><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($job['location']) ?></span>
                                <span><i class="fa-solid fa-briefcase"></i> <?= htmlspecialchars($job['job_type']) ?></span>
                                <?php if (isset($job['work_model']) && !empty($job['work_model'])): ?>
                                    <span><i class="fa-solid fa-clock"></i> <?= htmlspecialchars(ucfirst($job['work_model'])) ?></span>
                                <?php else: ?>
                                    <span><i class="fa-solid fa-clock"></i> Not specified</span>
                                <?php endif; ?>
                                <span class="profile-job-status status-<?= strtolower($job['status']) ?>">
                                    <?= ucfirst($job['status']) ?>
                                </span>
                                <span class="admin-status-badge admin-status-<?= strtolower($job['admin_status']) ?>">
                                    <?= ucfirst($job['admin_status']) ?>
                                </span>
                            </div>
                        </div>
                        <div class="profile-job-arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php if ($user['role'] !== 'admin'): ?>
<!-- Delete User Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Confirm Delete</h2>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this user? This action cannot be undone.</p>
            <div class="warning-message">
                <?php if ($user['role'] === 'company_admin'): ?>
                    <p><strong>Warning:</strong> Deleting this employer will also delete their company profile and all associated job postings.</p>
                <?php elseif ($user['role'] === 'job_seeker'): ?>
                    <p><strong>Warning:</strong> Deleting this job seeker will also delete all their applications and profile data.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="modal-footer">
            <form action="<?= SITE_URL ?>/admin/users/delete/<?= $user['user_id'] ?>" method="POST">
                <button type="button" id="cancelDelete" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-danger">Delete User</button>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete modal functionality
    const modal = document.getElementById('deleteModal');
    const closeBtn = document.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancelDelete');
    const deleteBtn = document.querySelector('[data-toggle="modal"]');
    
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.style.display = 'block';
        });
    }
    
    // Closing the modal
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
    
    // Close when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target == modal) {
            modal.style.display = 'none';
        }
    });
});
</script>