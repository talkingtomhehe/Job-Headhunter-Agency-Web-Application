<div class="filter-bar">
    <div class="filter-options">
        <a href="<?= SITE_URL ?>/admin/jobs" class="filter-btn <?= $currentFilter === 'all' ? 'active' : '' ?>">All Jobs</a>
        <a href="<?= SITE_URL ?>/admin/jobs?filter=pending" class="filter-btn <?= $currentFilter === 'pending' ? 'active' : '' ?>">Pending</a>
        <a href="<?= SITE_URL ?>/admin/jobs?filter=active" class="filter-btn <?= $currentFilter === 'active' ? 'active' : '' ?>">Active</a>
        <a href="<?= SITE_URL ?>/admin/jobs?filter=rejected" class="filter-btn <?= $currentFilter === 'rejected' ? 'active' : '' ?>">Rejected</a>
    </div>
    
    <a href="<?= SITE_URL ?>/admin/addJob" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Add New Job
    </a>
</div>

<div class="dashboard-card">
    <div class="card-body">
        <?php if (empty($jobs)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <p>No jobs found in this category</p>
            </div>
        <?php else: ?>
            <div class="responsive-table">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Applications</th>
                            <th>Posted</th>
                            <th>Status</th>
                            <th>Admin Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job): ?>
                            <tr>
                                <td>
                                    <div class="job-title-cell">
                                        <strong><?= htmlspecialchars($job['title']) ?></strong>
                                        <span class="job-location">
                                            <i class="fa-solid fa-location-dot"></i> 
                                            <?= htmlspecialchars($job['location']) ?>
                                        </span>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($job['company_name']) ?></td>
                                <td>
                                    <span class="application-count"><?= $job['application_count'] ?></span>
                                </td>
                                <td><?= date('M d, Y', strtotime($job['created_at'])) ?></td>
                                <td>
                                    <span class="status-badge status-<?= strtolower($job['status']) ?>">
                                        <?= ucfirst($job['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge admin-status-<?= strtolower($job['admin_status']) ?>">
                                        <?= ucfirst($job['admin_status']) ?>
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <a href="<?= SITE_URL ?>/admin/jobs/view/<?= $job['job_id'] ?>" class="btn-icon" title="View Job">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="<?= SITE_URL ?>/admin/jobs/edit/<?= $job['job_id'] ?>" class="btn-icon" title="Edit Job">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <?php if ($job['admin_status'] === 'pending'): ?>
                                        <form action="<?= SITE_URL ?>/admin/jobs/approve/<?= $job['job_id'] ?>" method="POST" style="display: inline;">
                                            <button type="submit" class="btn-icon btn-approve-icon" title="Approve Job">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="<?= SITE_URL ?>/admin/jobs/reject/<?= $job['job_id'] ?>" method="POST" style="display: inline;">
                                            <button type="submit" class="btn-icon btn-reject-icon" title="Reject Job">
                                                <i class="fa-solid fa-times"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <button type="button" class="btn-icon btn-delete" data-id="<?= $job['job_id'] ?>" title="Delete Job">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Delete Modal -->
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <h2>Confirm Deletion</h2>
                    <p>Are you sure you want to delete this job posting? This action cannot be undone.</p>
                    <div class="modal-actions">
                        <button id="cancelDelete" class="btn-secondary">Cancel</button>
                        <form id="deleteForm" method="POST" action="<?= SITE_URL ?>/admin/jobs/delete">
                            <input type="hidden" name="job_id" id="deleteJobId" value="">
                            <button type="submit" class="btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete modal functionality
    const modal = document.getElementById('deleteModal');
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const closeBtn = document.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancelDelete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const jobId = this.getAttribute('data-id');
            document.getElementById('deleteJobId').value = jobId;
            modal.style.display = 'block';
        });
    });
    
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
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>