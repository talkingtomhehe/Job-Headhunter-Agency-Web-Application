<div class="dashboard-section">
    <div class="section-header">
        <div class="section-actions">
            <a href="<?= SITE_URL ?>/employer/jobs/create" class="btn-primary" onclick="window.location.href='<?= SITE_URL ?>/employer/jobs/create'">
                <i class="fa-solid fa-plus"></i> Post New Job
            </a>
        </div>
    </div>
    
    <?php if (empty($jobs)): ?>
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            <h3>No Jobs Posted Yet</h3>
            <p>Get started by creating your first job listing</p>
            <a href="<?= SITE_URL ?>/employer/jobs/create" class="btn-primary">Post Your First Job</a>
        </div>
    <?php else: ?>
        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-filters">
                    <div class="filter-group">
                        <label for="statusFilter">Filter by Status:</label>
                        <select id="statusFilter" class="filter-select">
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                            <option value="draft">Draft</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    
                    <div class="search-box">
                        <input type="text" id="jobSearch" placeholder="Search jobs..." class="search-input">
                        <button class="search-button"><i class="fa-solid fa-search"></i></button>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="responsive-table">
                    <table class="data-table jobs-table">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Applications</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($jobs as $job): ?>
                                <tr data-status="<?= strtolower($job['status']) ?>">
                                    <td>
                                        <div class="job-title-cell">
                                            <strong><?= htmlspecialchars($job['title']) ?></strong>
                                            <span class="job-location">
                                                <i class="fa-solid fa-location-dot"></i> 
                                                <?= htmlspecialchars($job['location']) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="application-count"><?= $job['application_count'] ?></span>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($job['created_at'])) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($job['status']) ?>">
                                            <?= ucfirst($job['status']) ?>
                                        </span>
                                    </td>
                                    <td class="actions-cell">
                                        <a href="<?= SITE_URL ?>/employer/jobs/viewJob/<?= $job['job_id'] ?>" class="btn-icon" title="View Job">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="<?= SITE_URL ?>/employer/jobs/editJob/<?= $job['job_id'] ?>" class="btn-icon" title="Edit Job">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <button type="button" class="btn-icon btn-delete" data-id="<?= $job['job_id'] ?>" title="Delete Job">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if (count($jobs) > 0): ?>
                <div class="pagination-container">
                    <?php
                    $totalItems = $totalItems ?? count($jobs);  
                    $itemsPerPage = $itemsPerPage ?? 10; 
                    $currentPage = $currentPage ?? 1;  
                    $urlPattern = SITE_URL . '/employer/jobs?page={page}';
                    
                    include ROOT_PATH . '/app/views/components/pagination.php';
                    ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <h2>Confirm Deletion</h2>
                <p>Are you sure you want to delete this job posting? This action cannot be undone.</p>
                <div class="modal-actions">
                    <button id="cancelDelete" class="btn-secondary">Cancel</button>
                    <form id="deleteForm" method="POST" action="<?= SITE_URL ?>/employer/jobs/deleteJob">
                        <input type="hidden" name="job_id" id="deleteJobId" value="">
                        <button type="submit" class="btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status filter functionality
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;
            const rows = document.querySelectorAll('.jobs-table tbody tr');
            
            rows.forEach(row => {
                const status = row.getAttribute('data-status');
                if (selectedStatus === 'all' || status === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
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
                
                if (title.includes(searchTerm) || location.includes(searchTerm)) {
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
    const closeBtn = document.querySelector('.close-btn');
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