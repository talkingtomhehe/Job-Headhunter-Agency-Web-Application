<div class="page-header">
    <div class="back-link">
        <a href="<?= SITE_URL ?>/admin/users">
            <i class="fa-solid fa-arrow-left"></i> Back to User Management
        </a>
    </div>
</div>

<div class="admin-user-view">
    <div class="dashboard-card">
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
                    <button class="btn-secondary dropdown-toggle">
                        Actions <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="<?= SITE_URL ?>/admin/users/edit/<?= $user['user_id'] ?>" class="dropdown-item">
                            <i class="fa-solid fa-pen-to-square"></i> Edit User
                        </a>
                        <a href="#" class="dropdown-item text-danger" data-toggle="modal" data-target="#deleteModal" data-id="<?= $user['user_id'] ?>">
                            <i class="fa-solid fa-trash"></i> Delete User
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card-body">
            <div class="user-info-section">
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
                
                <?php if ($user['role'] === 'company_admin' && isset($company)): ?>
                <div class="company-info">
                    <h3>Company Information</h3>
                    <div class="company-profile">
                        <?php if (!empty($company['logo_path'])): ?>
                        <div class="company-logo">
                            <img src="<?= SITE_URL ?>/uploads/logos/<?= $company['logo_path'] ?>" alt="<?= htmlspecialchars($company['company_name']) ?>">
                        </div>
                        <?php endif; ?>
                        
                        <div class="company-details">
                            <h4><?= htmlspecialchars($company['company_name']) ?></h4>
                            <?php if (!empty($company['industry'])): ?>
                            <div class="detail">
                                <i class="fa-solid fa-briefcase"></i> <?= htmlspecialchars($company['industry']) ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($company['company_size'])): ?>
                            <div class="detail">
                                <i class="fa-solid fa-users"></i> <?= htmlspecialchars($company['company_size']) ?> employees
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($company['website'])): ?>
                            <div class="detail">
                                <i class="fa-solid fa-globe"></i> <a href="<?= htmlspecialchars($company['website']) ?>" target="_blank"><?= htmlspecialchars($company['website']) ?></a>
                            </div>
                            <?php endif; ?>
                            
                            <div class="detail">
                                <i class="fa-solid fa-briefcase"></i> <?= $jobCount ?> job<?= $jobCount !== 1 ? 's' : '' ?> posted
                            </div>
                            
                            <a href="<?= SITE_URL ?>/admin/companies/view/<?= $company['company_id'] ?>" class="btn-text">
                                <i class="fa-solid fa-eye"></i> View Company Profile
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php if ($user['role'] === 'job_seeker' && isset($applications)): ?>
    <div class="dashboard-card applications-card">
        <div class="card-header">
            <h2>Applications (<?= $applicationCount ?>)</h2>
        </div>
        
        <div class="card-body">
            <?php if (empty($applications)): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <p>No job applications submitted</p>
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
                                                <img src="<?= SITE_URL ?>/uploads/logos/<?= $application['logo_path'] ?>" alt="<?= htmlspecialchars($application['company_name']) ?>" class="company-logo-small">
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
            <form action="<?= SITE_URL ?>/admin/users/delete" method="POST">
                <input type="hidden" name="user_id" id="deleteUserId" value="<?= $user['user_id'] ?>">
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
            document.getElementById('deleteUserId').value = this.getAttribute('data-id');
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