<div class="dashboard-section">
    <?php if (empty($applications)): ?>
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fa-solid fa-file-lines"></i>
            </div>
            <h3>No Applications Yet</h3>
            <p>Applications from job seekers will appear here</p>
            <a href="<?= SITE_URL ?>/employer/jobs" class="btn-primary">View Your Jobs</a>
        </div>
    <?php else: ?>
        <div class="dashboard-card">
            <div class="card-header">
                <div class="card-filters">
                    <div class="filter-group">
                        <label for="statusFilter">Filter by Status:</label>
                        <select id="statusFilter" class="filter-select">
                            <option value="all">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="reviewing">Reviewing</option>
                            <option value="shortlisted">Shortlisted</option>
                            <option value="rejected">Rejected</option>
                            <option value="hired">Hired</option>
                        </select>
                    </div>
                    
                    <div class="search-box">
                        <input type="text" id="applicationSearch" placeholder="Search applications..." class="search-input">
                        <button class="search-button"><i class="fa-solid fa-search"></i></button>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="responsive-table">
                    <table class="data-table applications-table">
                        <thead>
                            <tr>
                                <th>Applicant</th>
                                <th>Job Position</th>
                                <th>Applied Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $application): ?>
                                <?php 
                                    // Determine which status field to use
                                    $statusField = isset($application['application_status']) ? 'application_status' : 'status';
                                ?>
                                <tr data-status="<?= strtolower($application[$statusField]) ?>">
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
                                    <td><?= htmlspecialchars($application['job_title']) ?></td>
                                    <td><?= date('M d, Y', strtotime($application['created_at'])) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($application[$statusField]) ?>">
                                            <?= ucfirst($application[$statusField]) ?>
                                        </span>
                                    </td>
                                    <td class="actions-cell">
                                        <a href="<?= SITE_URL ?>/employer/applications/view/<?= $application['application_id'] ?>" class="btn-icon" title="View Application">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
            const rows = document.querySelectorAll('.applications-table tbody tr');
            
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
    const searchInput = document.getElementById('applicationSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.applications-table tbody tr');
            
            rows.forEach(row => {
                const applicantName = row.querySelector('.applicant-info strong').textContent.toLowerCase();
                const jobTitle = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                
                if (applicantName.includes(searchTerm) || jobTitle.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>