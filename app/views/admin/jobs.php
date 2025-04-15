<div class="section-header">
    <div class="section-actions">
        <a href="<?= SITE_URL ?>/admin/addJob" class="btn-primary">
            <i class="fa-solid fa-plus"></i> Add New Job
        </a>
    </div>
</div>

<div class="dashboard-card">
    <div class="card-header">
        <div class="card-filters">
            <div class="filter-group">
                <label for="statusFilter">Filter by Status:</label>
                <select id="statusFilter" class="filter-select">
                    <option value="all" <?= ($activeFilter ?? '') === 'all' ? 'selected' : '' ?>>All Status</option>
                    <option value="pending" <?= ($activeFilter ?? '') === 'pending_admin' ? 'selected' : '' ?>>Pending Review</option>
                    <option value="approved" <?= ($activeFilter ?? '') === 'approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="rejected" <?= ($activeFilter ?? '') === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                </select>
            </div>
            
            <div class="search-box">
                <input type="text" id="jobSearch" placeholder="Search jobs..." class="search-input">
                <button class="search-button"><i class="fa-solid fa-search"></i></button>
            </div>
        </div>
    </div>
    
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
                <table class="data-table jobs-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Applications</th>
                            <th>Posted</th>
                            <th>Admin Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job): ?>
                            <tr data-status="<?= strtolower($job['admin_status']) ?>">
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
                        <form id="deleteForm" method="POST">
                            <input type="hidden" id="deleteJobId" name="job_id" value="">
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
    // Status filter functionality
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;
            if (selectedStatus === 'all') {
                window.location.href = '<?= SITE_URL ?>/admin/jobs';
            } else {
                window.location.href = '<?= SITE_URL ?>/admin/jobs?filter=' + selectedStatus;
            }
        });
    }
    
    // Search functionality
    const searchInput = document.getElementById('jobSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.jobs-table tbody tr');
            
            rows.forEach(row => {
                const title = row.querySelector('.job-title-cell strong').textContent.toLowerCase();
                const location = row.querySelector('.job-location').textContent.toLowerCase();
                const company = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || location.includes(searchTerm) || company.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
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

document.getElementById('deleteForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const jobId = document.getElementById('deleteJobId').value;
    this.action = '<?= SITE_URL ?>/admin/jobs/delete/' + jobId;
    this.submit();
});
</script>